<?php
include("conexion.php");
@$consultas=new Consultas();
@$campos=$_POST['campos'];
@$tabla=$_POST['tabla'];
@$campoC=$_POST['campoCondicion'];
@$valor=$_POST['valores'];
@$orden=((isset($_POST['orden']))?$_POST['orden']:"");
$resultado=array(array($campos));
//print_r($campoC);
//print_r($valor);

$datos=$consultas->consultarDatosQ($campos,$tabla,$orden,$campoC,$valor);
while ($fila=$datos->fetch_row()) {
    array_push($resultado,$fila);
}
array_shift($resultado);
echo json_encode(array_values($resultado),JSON_PRETTY_PRINT);

?>
