<?php
include("conexion.php");
$consultas=new Consultas();
$query=$_POST['query'];
$resultado=array(array());
$datos=$consultas->conexion->query($query);
if(!(is_bool($datos))){
    while ($fila=$datos->fetch_row()) {
        for ($i=0; $i <count($fila) ; $i++) {
            $fila[$i]=utf8_encode($fila[$i]);
        }
        array_push($resultado,$fila);
    }
    array_shift($resultado);
    echo json_encode(array_values($resultado),JSON_PRETTY_PRINT);
}else{
    $resultado=[FALSE];
    echo json_encode(array_values($resultado),JSON_PRETTY_PRINT);
}
?>
