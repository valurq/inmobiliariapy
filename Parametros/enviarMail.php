<?php

  include("conexion.php");
  $consultas= new Consultas();
  require "Mailer.php";
  $mailer = new Mailer();

  $asunto=$_POST['asunto'];
  $contenido =$_POST['cuerpo'];
  $idAgente=$_POST['idAgente'];
  //traer mail del broker/s  de la oficina desde el usuario
  $mailDestinatario=$consultas->conexion->query("SELECT mail FROM brokers WHERE oficina_id = (SELECT oficina_id FROM vendedor WHERE id = $idAgente)");
  $mailDestinatario=$mailDestinatario->fetch_array(MYSQLI_NUM);
  $mailDestinatario=$mailDestinatario[0];
  $destinatarios = array($mailDestinatario);

  $datosUsuario=$consultas->consultarDatosQ(['dsc_vendedor','apellido','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)','nro_doc'],'vendedor','','id',$idAgente);
    $destinatarios = array($mailDestinatario);
    //echo $mailDestinatario."\n ".$asunto."\n\n".$contenido;
if ($mailer->loadRemoteConfig()) {
    $estado = $mailer->sendMsj($destinatarios,$contenido,$asunto);
    if($estado){
        echo "1";
    }else{
        echo "Falló: ".$mailer->getLastError();
    }
}
?>
