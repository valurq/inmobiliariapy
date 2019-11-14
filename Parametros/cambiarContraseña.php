<?php
include('conexion.php');
$consultas=new Consultas();
$id=$_POST['idUsuario'];
$pass=md5($_POST['contra']);
    $retorno=$consultas->modificarDatoQ('usuario',array('pass'),array($pass),array('id'),array($id));
    if($retorno>0){
        echo "0";
    }else{
        echo "1";
    }
?>
