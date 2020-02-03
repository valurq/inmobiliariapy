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
    //validamos la conexion ftp
    $conexion = connectToFtpServer();
    if($conexion !== false){
        //obtenemos el listad de ficheros xml que ya fueron leidos en ocasiones pasadas
        $listaXML = $consultas->consultarDatos(array("nom_fichero"),"xml_ficheros");
        $leidosXML = array();
        while($nomXML = $listaXML->fetch_assoc()){
            array_push($leidosXML,$nomXML["nom_fichero"]);
        }
        
        $totalXML = ftp_nlist($conexion, "."); //lista de ficheros en el servidor
        //obtencion de los XML a cargar
        if(gettype($totalXML)!="boolean"){
            foreach($totalXML as $XML){
                $espropiedad = strpos($XML, "Properties_114001");
                $esFull = strpos($XML, "_Full.xml");
                $esDtd = strpos($XML, ".dtd");
                foreach($leidosXML as $leido){
                    if($leido==$XML and $espropiedad !== false and $esFull !==false){
                        array_push($nuevosXML, $XML);
                    }
                    if($esDtd){
                        $dtd = $XML;
                    }
                }            
            }
        }else{
            fwrite($log, "ALERTA: No hay ficheros procesados en la base de datos" . PHP_EOL);
        }

        fwrite($log, "INFORME: Se ha determinado los/el xml/s a leer en tiempo: " . date("Y-m-d H:i:s") . PHP_EOL);

        var_dump($nuevosXML);

        /*===================================================================================
        DESCARGA DE LOS FICHEROS XML SEGUN LOS NOMBRES ALMACENADOS ANTERIORMENTE 
        =====================================================================================*/
        //descargar primeramente el DTD
        $handler = fopen($newDir . "/" . $dtd, "w");
        if (ftp_fget($conexion, $handler, $dtd, FTP_ASCII, 0)) {
            if ($consultas->insertarDato($dbtabla, $dbcampos, "'" . $XML . "'")) {
                fwrite($log, "QUERY: Fichero $XML guardado como procesado en base de datos" . PHP_EOL);
            } else {
                fwrite($log, "ALERTA-QUERY: Fichero $XML no se registro en base de datos" . PHP_EOL);
            }
        }
        //Reiniciar la conexion
        ftp_close($conexion);
        $conexion = connectToFtpServer();
        if(!empty($nuevosXML)){            
            foreach($nuevosXML as $XML){
                if($conexion !== false){                
                    fwrite($log, "INFORME: Iniciando descarga de --> $XML" . PHP_EOL);
                    $handler = fopen($newDir . "/" . $XML, "w");
                    if(ftp_fget($conexion,$handler,$XML,FTP_ASCII)){
                        if($consultas->insertarDato($dbtabla, $dbcampos,"'".$XML."'")){
                            fwrite($log, "QUERY: Fichero $XML guardado como procesado en base de datos" . PHP_EOL);
                        }else{
                            fwrite($log, "ALERTA-QUERY: Fichero $XML no se registro en base de datos" . PHP_EOL);
                        }
                    }else{
                        fwrite($log, "FATAL: El fichero $XML no se pudo descargar, puede deberse a un problema del firewall" . PHP_EOL);
                    }
                    ftp_close($conexion);
                    $conexion = connectToFtpServer();
                }
            }    
        }else{
            fwrite($log, "INFORE: No hay nuevos XML que cargar" . PHP_EOL);
        }
    }else{
        fwrite($log,"FATAL: No se pudo iniciar sesion en el servidor FTP".PHP_EOL);
    }

    ftp_close($conexion); //cerrar conexion ftp

    fwrite($log, "INFORME: Se han descargado el/los ficheros xml en tiempo: " . date("Y-m-d H:i:s") . PHP_EOL);
    
    //lee los xml nuevos si existiesen
    require "xmlhandler_reader.php";

    fwrite($log, "INFORME: Fin de Proceso: " . date("Y-m-d H:i:s").PHP_EOL);
    $duracion = time() - $inicio;
    fwrite($log, "INFORME: Duracion del proceso (segundos): " . $duracion . PHP_EOL);
    fwrite($log, "Log de proceso: process_log_" . $currentDate . ".log" . PHP_EOL);

    echo "El script ha terminado de ejecutarse.<br>
    Directorio generado: ".str_replace("./","",$newDir)."<br>
    Log de proceso: process_log_".$currentDate. ".log<br>";

    //Retorna TRUE si la conexion fue exitosa y FALSE si no se pudo conectar
    function connectToFtpServer(){
        global $log;
        $conexion = ftp_connect("ftp.remax-europe.com", 21, 90);
        if($conexion){
            if(ftp_login($conexion, "remaxparaguay_xml", "3qqyjQV")){
                if(ftp_pasv($conexion, true)){
                    return $conexion;
                }else{
                    fwrite($log, "FATAL: la conexion ftp no se pudo establecer en modo pasivo" . PHP_EOL);
                }
            }else{
                fwrite($log, "FATAL: no se pudo autenticar el usuario remaxparaguay_xml" . PHP_EOL);
            }
        }else{
            fwrite($log, "FATAL: no se pudo conectar a ftp.remax-europe.com" . PHP_EOL);
        }
        return false;
    }

?>