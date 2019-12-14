<div class="container">
    <form method="POST" action="mailerTester.php">
        Destinatario:<input type="text" name="destinatario"><br>
        Contenido:<input type="text" name="contenido"><br>
        Asunto:<input type="text" name="asunto"><br>
        <input type="submit" value="Enviar" name="enviado">
    </form>
</div>
<?php 
    //Primero cargar conexion.php y luego el mailer
    require "Parametros/conexion.php";
    require "Parametros/Mailer.php";
    if(isset($_POST['enviado'])){
        //Recibimiento y formateo de parametros
        $destinatarios = explode(",",$_POST['destinatario']);
        $contenido = $_POST['contenido'];
        $asunto = $_POST['asunto'];
        if(!empty($destinatarios) and $destinatarios!=false and isset($contenido,$asunto)){
            //Uso de la clase mailer
            $mailer = new Mailer();
            if($mailer->loadRemoteConfig()){
                $estado = $mailer->sendMsj(
                    $destinatarios,
                    $contenido,
                    $asunto
                );
                //Control de errores
                if($estado){
                    echo "<strong>Correo Enviado!</strong>";
                }else{
                    echo "Fallo 2°: ".$mailer->getLastError();
                }
            }else{
                echo "Fallo 1°: ".$mailer->getLastError();
            }
        }else{
            echo "No se han recibido todos los parametros necesarios";
        }
    }
?>
