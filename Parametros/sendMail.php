<?php
    require "conexion.php";
    require "Mailer.php";

    @$destinatarios = $_POST["destinatarios"];
    @$asunto = $_POST["asunto"];
    @$cuerpo = $_POST["cuerpo"];
    @$reply_to = $_POST["reply_to"];
    @$con_copia = $_POST["con_copia"];
    //si la tabla 'Parametros' aceptase multiples registros,
    // pasar aqui el id del registro a usar para configurar el mailer (default = 1)
    @$config_id = $_POST["config_id"];

    $response = array(
        "status" => "error",
        "desc" => "Error no definido"
    );

    if( isset($destinatarios,$asunto,$cuerpo) ){
        //Setear valores pr efault a los parametros no obligatorios
        if(empty($con_copia)){
            $con_copia = array();
        }
        if(empty($reply_to)){
            $reply_to = "no-reply@system.sys";
        }
        if(empty($config_id)){
            $config_id = "1";
        }

        //proceso de envio del mail
        $mailer = new Mailer();        
        if($mailer->loadRemoteConfig($config_id)){
            if($mailer->sendMsj($destinatarios,$cuerpo,$asunto,$reply_to,$con_copia)){
                $response["status"] = "success";
                $response["desc"] = "El correo se ha enviado exitosamente";
            }else{
                $response["desc"] = "Fallo al enviar el correo, para mas informacion
                 vease el log de errores del Mailer en /Parametros";
            }
        }else{
            $response["desc"] = "Fallo al obtener los parametros de conexion al servidor 
            de correos desde la base de datos";
        }

    }else{
        $response["desc"] = "Faltan parametros obligatorios para el envio del correo";
    }

    echo json_encode($response,JSON_PRETTY_PRINT);

?>