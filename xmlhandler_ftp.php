<?php
/*==========================
     INICIALIZACIONES VARIAS
     ===========================*/
    date_default_timezone_set("America/Asuncion");
    require "../Parametros/conexion.php";
    $consultas = new Consultas();
    $tabla = "propiedades"; //tabla en la que insertar los registros resultantes
    $currentDate = date("Y_m_d__H_i_s", time()); //para nombrar directorios
    $newDir = "./xml_" . $currentDate; //nuevo directorio a generar para la descarga de xmls
    mkdir($newDir);
    $log = fopen($newDir . "/process_log_" . $currentDate . ".log", "w");
    $inicio = time();
    fwrite($log, "INFORME: Inicio de Proceso: " . date("Y-m-d H:i:s") . PHP_EOL);
    set_time_limit(14400);

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

    //lee los xml nuevos si existiesen
    require "xmlhandler_reader.php";

    fwrite($log, "INFORME: Fin de Proceso: " . date("Y-m-d H:i:s").PHP_EOL);
    $duracion = time() - $inicio;
    fwrite($log, "INFORME: Duracion del proceso (segundos): " . $duracion . PHP_EOL);
    fwrite($log, "Log de proceso: process_log_" . $currentDate . ".log" . PHP_EOL);

    echo "El script ha terminado de ejecutarse.<br>
    Directorio generado: ".str_replace("./","",$newDir)."<br>
    Log de proceso: process_log_".$currentDate. ".log<br>";

?>