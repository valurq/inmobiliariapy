<?php
include('conexion.php');
$consultas=new Consultas();
$campos=$_POST['campos'];
$tabla=$_POST['tabla'];
$valores=$_POST['valores'];
$campoCondicion=$_POST['campoCondicion'];
$valorCondicion=$_POST['valorCondicion'];
$val="";
// echo "campos =";
// print_r($campos);
// echo "\nvalores ";
// print_r($valores);
// foreach ($valores as $key => $value) {
//     $val.="'".$value."',";
// }
//$val = substr($val,0,-1);

if(isset($_POST['campos']) && isset($_POST['tabla'])&& isset($_POST['valores'])){
    $retorno=$consultas->modificarDatoQ($tabla,$campos,$valores,$campoCondicion,$valorCondicion);
    if($retorno>0){
        echo "0";
    }else{
        echo "1";
    }
}
 ?>
