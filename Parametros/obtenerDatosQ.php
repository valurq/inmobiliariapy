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
    for ($i=0; $i <count($fila) ; $i++) {
        $fila[$i]=utf8_encode($fila[$i]);
    }
    array_push($resultado,$fila);
}
array_shift($resultado);
//echo array_values($resultado);
//print_r($resultado);
echo json_encode(array_values($resultado),JSON_PRETTY_PRINT);
switch (json_last_error()) {
    case JSON_ERROR_NONE:
        //echo ' - No errors';
    break;
    case JSON_ERROR_DEPTH:
        echo ' - Maximum stack depth exceeded';
    break;
    case JSON_ERROR_STATE_MISMATCH:
        echo ' - Underflow or the modes mismatch';
    break;
    case JSON_ERROR_CTRL_CHAR:
        echo ' - Unexpected control character found';
    break;
    case JSON_ERROR_SYNTAX:
        echo ' - Syntax error, malformed JSON';
    break;
    case JSON_ERROR_UTF8:
        echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
    break;
    default:
        echo ' - Unknown error';
    break;
}

?>
