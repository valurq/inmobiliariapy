<?php
    /*==========================
     INICIALIZACIONES VARIAS
     ===========================*/
    date_default_timezone_set("America/Asuncion");
    require "Parametros/conexion.php";
    $consultas = new Consultas();
    $xmlDoc = new DOMDocument();
    //tiempo maximo de ejecucion del script, no deberia de tardar mas de 4 horas
    set_time_limit(14400);
    $currentDate = date("Y_m_d__H_i_s", time()); //para nombrar directorios
    $newDir = "./xml_" . $currentDate; //nuevo directorio a generar para la descarga de xmls
    $log = fopen("process_log_".$currentDate.".log","w");
    $inicio = time();
    fwrite($log, "INFORME: Inicio de Proceso: ".date("Y-m-d H:i:s").PHP_EOL);

    /*===================================================================================
    OBTENCION DE LOS NOMBRES DE FICHEROS XML A DESCARGAR
    =====================================================================================*/
    $nuevosXML = array(); //los ficheros XML que lleven la palabra "Full"
    $dbcampos = array("nom_fichero");
    $dbtabla = "xml_ficheros";
    $dtd = "";
    $ftpconn = ftp_connect("ftp.remax-europe.com"); //conexion al servidor ftp
    //validamos la conexion ftp
    if(ftp_login($ftpconn, "remaxparaguay_xml", "3qqyjQV")){
        ftp_pasv($ftpconn, true);
        //obtenemos el listad de ficheros xml que ya fueron leidos en ocasiones pasadas
        $listaXML = $consultas->consultarDatos(array("nom_fichero"),"xml_ficheros");
        $totalXML = ftp_nlist($ftpconn,"."); //lista de ficheros en el servidor
        $leidosXML = array();
        while($nomXML = $listaXML->fetch_assoc()){
            array_push($leidosXML,$nomXML["nom_fichero"]);
        }
        //obtencion de los XML a cargar
        if(gettype($totalXML)!="boolean"){
            foreach($totalXML as $XML){
                $existe = false;
                foreach($leidosXML as $leido){
                    if($leido==$XML){
                        $existe = true;
                    }
                }
                //guardamos los ficheros en sus respectivos arrays de acuerdo a la 
                //nomenclatura de su nombre
                $espropiedad = strpos($XML, "Properties_114001");
                if ($espropiedad!==false) {
                    //Solo se procesaran los ficheros con extension full
                    $esFull = strpos($XML,"_Full.xml");
                    if (!$existe and $esFull!==false) {
                        array_push($nuevosXML, $XML);
                    }
                }else if (strpos($XML, ".dtd") !== false) {           
                        $dtd =  $XML;

                }              
            }
        }else{
            fwrite($log, "ALERTA: No hay ficheros procesados en la base de datos" . PHP_EOL);
        }

        fwrite($log, "INFORME: Se ha determinado los/el xml/s a leer en tiempo: " . date("Y-m-d H:i:s") . PHP_EOL);

        /*===================================================================================
        DESCARGA DE LOS FICHEROS XML SEGUN LOS NOMBRES ALMACENADOS ANTERIORMENTE 
        =====================================================================================*/
        if(!empty($nuevosXML)){
            mkdir($newDir);
            //descargar primeramente el DTD
            if (ftp_get($ftpconn, $newDir . "/" . $dtd, $dtd, FTP_ASCII)) {
                if($consultas->insertarDato($dbtabla, $dbcampos, "'" . $XML . "'")){
                    fwrite($log, "QUERY: Fichero $XML guardado como procesado en base de datos" . PHP_EOL);
                }else{
                    fwrite($log, "ALERTA-QUERY: Fichero $XML no se registro en base de datos" . PHP_EOL);
                }
            }
            
            foreach($nuevosXML as $XML){
                if(ftp_get($ftpconn,$newDir."/".$XML,$XML,FTP_ASCII)){
                    if($consultas->insertarDato($dbtabla, $dbcampos,"'".$XML."'")){
                        fwrite($log, "QUERY: Fichero $XML guardado como procesado en base de datos" . PHP_EOL);
                    }else{
                        fwrite($log, "ALERTA-QUERY: Fichero $XML no se registro en base de datos" . PHP_EOL);
                    }
                }
            }    
        }
    }else{
        fwrite($log,"FATAL: No se pudo iniciar sesion en el servidor FTP".PHP_EOL);
    }
    ftp_close($ftpconn); //cerrar conexion ftp

    fwrite($log, "INFORME: Se han descargado el/los ficheros xml en tiempo: " . date("Y-m-d H:i:s") . PHP_EOL);

    //liberar variables de la memoria
    unset($listaXML);
    unset($totalXML);
    unset($leidosXML);
    unset($espropiedad);
    unset($existe);
    unset($ftpconn);

    /*==================================================================================== 
    DEFINICION DE ARRAY DE DATOS BUSCADOS CON NOMENCLATURA: CAMPO_BD => NOMBRE_TAG
    =======================================================================================*/
    //Array que contiene los tags que se buscaran de cada <Propertie> (osea de cada propiedad)
    $tags = array(
        "id_remax" => "IntegratorPropertyID", "Finca_ccctral" => "=RegionID",
        "cate_propiedad" => "CommercialResidential", "vendedor_id" => "IntegratorSalesAssociateID",
        "ciudad_id" => "CityID","direccion" => "AddressLine2", "dsc_ciudad" => "City",
        "precio" => "SoldPrice", "moneda_id" => "CurrentListingCurrency",
        "totalm2" => "TotalArea", "fecha_alta" => "OrigListingDate",
        "fecha_vto" => "ExpiryDate", "dsc_inmueble" => "DescriptionText",
        "captacion_com" => "ComTotalPct", "estado" => "=PropertyStatus"
    );

    /*========================================================================================
    FUNCION PARA LEER RECURSIVAMENTE LOS TAGS QUE CONTIENEN TAGS, LOS INDICES ORIGINALES DE 
    $TMPARR NO SE VEN AFECTADOS 
    ==========================================================================================*/
    function leerElemento($tmparr, $tags, $hijos){
        foreach ($hijos as $hijo) {
            foreach ($tags as $tag) {
                $esAtributo = strpos($tag,"=");
                if($esAtributo!==false){
                    if ($hijo->localName == $tag) {
                        $tag = str_replace("=", "", $tag);
                        $tmparr[$tag] = $hijo->getAttribute($tag);
                    }    
                }else{
                   if ($hijo->localName == $tag) {
                        $tmparr[$tag] = $hijo->nodeValue;
                    } 
                }
                /*if ($hijo->localName == $tag) {
                    $tmparr[$tag] = $hijo->nodeValue;
                    break; //prevenir iteraciones de mas
                } */
                if ($hijo->hasChildNodes()) {
                    $otroshijos = $hijo->childNodes;
                    $tmparr = leerElemento($tmparr, $tags, $otroshijos);
                }
            }
        }
        return $tmparr;
    }

    /*==============================================
    PROCESO DE LECTURA DE XML Y CARGA DE PROPIEDADES
    ================================================*/
    //por ahora no hay un sentido concreto en diferenciar los XML CHANGES de los FULL, 
    //ambos son tratados de la misma forma en le proceso de lectura
    foreach($nuevosXML as $XML){
        /*==================================================================================================
        $RESULTADOS ES UN ARRAY DONDE CADA INDICE CONTIENE OTRO ARRAY QUE REPRESENTA UNA PROPIEDAD 
        ==================================================================================================*/
        $xmlDoc->load($newDir."/".$XML);
        $resultados = array();
        //Obtenemos todas las propiedades definidas en el XML
        $propiedades = $xmlDoc->getElementsByTagName("Property");
        
        //recorremos todas las propiedades del xml luega de validar que existan
        if($propiedades->length > 0 and !empty($propiedades)){
            foreach($propiedades as $propiedad){
                //obtenemos todos los tags definidos dentro de <Property>
                $detalles = $propiedad->childNodes;
                $tmparr = array();
                //recorremos los tags definidos dentro de <Property>
                foreach($detalles as $detalle){
                    //contrastamos el nombre del tag que se esta leyendo con la lista de 
                    //tags que estamos buscando
                    foreach($tags as $tag){
                        $esAtributo = strpos($tag, "=");
                        if ($esAtributo !== false) {
                            if ($detalle->localName == $tag) {
                                $tag = str_replace("=", "", $tag);
                                $tmparr[$tag] = $detalle->getAttribute($tag);
                            }
                        } else {
                            if ($detalle->localName == $tag) {
                                $tmparr[$tag] = $detalle->nodeValue;
                            }
                        }
                        /*if ($detalle->localName == $tag) {
                            $tmparr[$tag] = $detalle->nodeValue;
                            break;
                        }*/
                        if($detalle->hasChildNodes()){
                            $hijos = $detalle->childNodes;
                            $tmparr = leerElemento($tmparr, $tags, $hijos);   
                        }
                    }
                    //evitar iteraciones innecesarias
                    if(count($tags)==count($tmparr)){
                        break;
                    }
                }
                if (!empty($tmparr)) {
                    array_push($resultados, $tmparr);
                }
            }
            fwrite($log, "INFORME: Se han encontrado ".count($resultados)." propiedades en el fichero $XML ("
            .date("Y-m-d H:i:s").")" . PHP_EOL);
        }else{
            fwrite($log, "ALERTA: No se encontraron propiedades en el fichero $XML" . PHP_EOL);
        }
        /*======================================================================================
         LECTURA DE LAS PROPIEDADES OBTENIDAS, SE PREPARAN LOS DATOS DE CADA PROPIEDAD DE MODO A 
         USARLOS EN UN QUERY. DEPENDIENDO DE SI LA PROPIEDAD EXISTE O NO EL QUERY SERA UN INSERT O 
         UN UPDATE (CUANDO HAYA DIFERENCIAS).
        ========================================================================================*/
        //esto es un poco ineficiente, este proceso ya se puede llevar acabo arriba bajo la condicional 
        //if(!empty($tmparr)) pero por ahora quedara asi, tampoco creo que incremente atrosmente el costo 
        //del script
        foreach($resultados as $resultado){
            //cada $resultado representa una propiedad
            $campos = array();
            $valores = "";
            $campo_valor = array();
            $tabla = "propiedades";
            $tam = count($resultado);
            $id_remax = "";
            //$indice = el nombre del campo en la base de datos, $valor = el valor de dicho campo
            //con esta iteracion se preparan los datos para insertar la propiedad en base de datos
            foreach($resultado as $indice=>$valor){
                foreach($tags as $campo=>$tag){
                    if($indice == $tag){
                        //para definir los campos del query
                        array_push($campos,$campo);

                        //para dar un valor default a los campos vacios
                        if (empty($valor)) {
                            $valor = 0;
                        }

                        //formatear correctamente las fechas
                        if(($campo=="fecha_alta" or $campo=="fecha_vto") and !empty($valor)){
                            $time = strtotime($valor);
                            $newdate = date('Y-m-d', $time);
                            $valor = $newdate;
                        }

                        //para prevenir errores en el query sql, la comilla es tomada literalmente en el query
                        //evaluar la posibilida de usar una funcion de escape
                        $valor = str_replace("'","",$valor);

                        //Definicion de la categoria segun valor del tag CommercialResidential
                        if ($campo == "cate_propiedad") {
                            if ($valor == 1) {
                                $valor = "RESIDENCIAL";
                            } else if($valor == 2) {
                                $valor = "COMERCIAL";
                            }else{
                                $valor = "INDEFINIDO";
                            }
                        }

                        //el ultimo valor no lleva coma como sufijo (sintaxis de sql)
                        if(strlen($valores)>0){
                            $valores .= ", '$valor' ";
                        }else{
                            $valores .= "'$valor'";
                        }

                        //obtencion del id remax para comparacion
                        if($campo=="id_remax"){
                            $id_remax = $valor;
                        }

                        //para controlar luego campo vs campo en la base de datos en el caso de que la
                        //ya exista
                        $campo_valor[$campo] = $valor;

                        break;
                    }
                }            
            }

            //VALIDACION SQL E INSERCION/MODIFICACION EN BASE DE DATOS
            $registroBD = $consultas->buscarDatoCustom($campos, "propiedades"," WHERE id_remax='$id_remax'");
            $modificar = gettype($registroBD)=="boolean";
            $modificar = ($modificar)?0:$registroBD->num_rows;
            if($modificar>0){
                //corroboramos que todos los campos sean iguales
                //en teoria no pueden haber 2 id_remax iguales
                $registro = $registroBD->fetch_assoc();
                $campos_diferencia = array();
                $valores_diferencia = "";
                foreach($campo_valor as $campo_local=>$valor_local){
                    foreach($registro as $campo_bd=>$valor_bd){ 
                        if($campo_local==$campo_bd){
                            if($valor_local != $valor_bd){
                                array_push($campos_diferencia,$campo_local);
                                if(strlen($valores_diferencia)>0){
                                    $valores_diferencia .= " , '".$valor_local."' ";
                                }else{
                                    $valores_diferencia .= " '".$valor_local."' ";
                                }
                            }
                        }
                    }
                }
                if(!empty($campos_diferencia)){
                    if($consultas->modificarDato($tabla,$campos_diferencia,
                        $valores_diferencia,"id_remax",$id_remax)){
                        fwrite($log, "QUERY: Propiedad $id_remax actualizada desde $XML" . PHP_EOL);
                    }else{
                        fwrite($log, "FATAL-QUERY: Propiedad $id_remax no se pudo actualizar desde $XML" . PHP_EOL);
                    }
                }else{
                    fwrite($log, "INFORME: Propiedad $id_remax ya existe y no necesita actualizarse ($XML)" . PHP_EOL);
                }
            }else{
                if ($consultas->insertarDato($tabla, $campos, $valores)) {
                    fwrite($log, "QUERY: Propiedad $id_remax insertada desde $XML" . PHP_EOL);
                } else {
                    fwrite($log, "FATAL-QUERY: Propiedad $id_remax no se pudo insertar desde $XML" . PHP_EOL);
                }  
            }
        }    
    }

    fwrite($log, "INFORME: Fin de Proceso: " . date("Y-m-d H:i:s").PHP_EOL);
    $duracion = time() - $inicio;
    fwrite($log, "INFORME: Duracion del proceso (segundos): " . $duracion . PHP_EOL);
    fwrite($log, "Log de proceso: process_log_" . $currentDate . ".log" . PHP_EOL);
    fwrite($log, "Log de errores: error_log_" . $currentDate . ".log" . PHP_EOL);

    echo "El script ha terminado de ejecutarse.<br>
    Directorio generado: ".str_replace("./","",$newDir)."<br>
    Log de proceso: process_log_".$currentDate. ".log<br>
    Log de errores: error_log_" . $currentDate . ".log<br>";

?>
