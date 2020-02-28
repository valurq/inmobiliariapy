<?php
include('conexion.php');
$consultas=new Consultas();
$campos=$_POST['campos'];
$tabla=$_POST['tabla'];
$vec=json_decode($_POST['valores']);
$valores="";
$valorConsulta=array();
$resultado=array();
foreach ($vec as $key => $valor) {
    $valores.="(";
    foreach ($valor as $key => $value) {
        $valores.="'".strtoupper($value)."',";
    }
    $valores = substr($valores,0,-1);
    $valores.="),";
}
$valores = substr($valores,0,-1);
echo "INSERT INTO $tabla ( ".(implode(",", $campos))." ) VALUES $valores ";
if(count($vec)>0){

    $retorno=$consultas->conexion->query("INSERT INTO $tabla ( ".(implode(",", $campos))." ) VALUES $valores");
    if($retorno>0){
        echo "0";
    }else{
        echo "-1";
    }
}


?>
