<?php
include("conexion.php");
@$consultas=new Consultas();
@$idUsuario=$_POST['id'];
@$oldContra=$_POST['contra'];
$datos=$consultas->consultarDatos(['pass'],'usuario',"",'id',$idUsuario);
$contra=$datos->fetch_array(MYSQL_NUM);
$contra=$contra[0];
if($contra==md5($oldContra)){
    echo "1";
}else{
    echo "0";
}
?>
