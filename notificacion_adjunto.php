<?php
  include("Parametros/conexion.php");
  $inserta_Datos= new Consultas();
  require "Parametros/Mailer.php";
  $mailer = new Mailer();


  $campos = array( 'referencia','categorias', 'fecha_vto');
  $mail_ti=$inserta_Datos->consultarDatos(array("mail_ti"),"parametros","","","");
  $mail_ti=$mail_ti->fetch_array(MYSQLI_NUM);
  $mail_ti=$mail_ti[0];
  //CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
      $resultado=$inserta_Datos->consultarDatos($campos,'adjuntos',"","" );
      $hoy = date('Y/m/d ', time());
      $lista='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'Referencia'.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'Categorias'.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'Fecha Vencimiento'.'<br>'.'-------------------------------------------------------------------------------------------'."<ul>";
      while ($datos=$resultado->fetch_row()){
        $diferencia = date_diff( date_create($datos[2]),date_create($hoy));
        $diferencia=$diferencia->format('%R%a');
        //echo  "\t".$diferencia;
        //echo  "\t".$datos[2]."<br>";
          if ($diferencia >= 0) {
            $lista.='<li>'.$datos[0].'&nbsp;&nbsp;&nbsp;&nbsp;'.$datos[1].'&nbsp;&nbsp;&nbsp;&nbsp;'.$datos[2]."</li>";
            //echo $hoy." - ".$datos[3]."  ->".$diferencia." - ".$datos[0].'<br>';
          }
        //$lista .='-/ Nombre: '.$datos[0].'<br>'.'Tipo Doc: '.$datos[5].'<br>'.'Numero Doc: '.$datos[1].'<br>'.'Fecha de ingreso: '.$datos[3].'<br>'.'Estado: '.$datos[4]."\n";

      }
      //echo "\t".$lista;

          $destinatarios = array($mail_ti);
          $contenido = 'Estos documentos requieren su atencion por vencimiento cumplido'.'<br>'.'<br>'.$lista;
          $asunto = 'Notificacion de vencimiento de documento';
          if (!empty($destinatarios) and $destinatarios != false and isset($contenido, $asunto,$destinatarios)) {
            if ($mailer->loadRemoteConfig()) {
              $estado = $mailer->sendMsj(
                $destinatarios,
                $contenido,
                $asunto
              );
            }
          }
        // si $diferencia >= $datos[2] {
        //    enviar el maill
        // }

      //$datetime2 = date_create('2009-10-13');
      //    $interval = date_diff($datetime1, $datetime2);
 ?>
