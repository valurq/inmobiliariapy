<div class="container">
    <form method="POST" action="mailerTester.php">
        Destinatario:<input type="text" name="destinatario"><br>
        Contenido:<input type="text" name="contenido"><br>
        Asunto:<input type="text" name="asunto"><br>
        <input type="submit" value="Enviar" name="enviado">
    </form>
</div>
<?php 
    require "Mailer.php";
    if(isset($_POST['enviado'])){
        //Recibimiento y formateo de parametros
        $destinatario = array($_POST['destinatario']);
        $contenido = $_POST['contenido'];
        $asunto = $_POST['asunto'];
        //Uso de la clase mailer
        $mailer = new Mailer();
        $mailer->defaultSMTPConf();
        $estado = $mailer->sendMsj(
            $destinatario,
            $contenido,
            $asunto
        );
        //Control de errores
        if($estado){
            echo "<strong>Correo Enviado!</strong>";
        }else{
            echo "Falló: ".$mailer->getLastError();
        }
    }
?>
