<?php 
    //mediante este fichero se permite llamar de forma aislada a la funcion 
    //"modificarDato" del la clase Consultas. 
    include("conexion.php");
    $consultas = new Consultas();

    $tabla = $_POST["tabla"]; //el nombre de la tabla que se modificara

    $tmp_campos = $_POST["campos"]; //campos implicados (deben pasarse en formato JSON)
    $campos = json_decode($tmp_campos,true);

    $tmp_valores = $_POST["valores"]; //los valores de los campos actualizados (en formato JSON)
    $valores = implode(",",json_decode($tmp_valores,true));
    
    //el nombre del identificador y el valor del identificador que distingan al registro
    $identificador = $_POST["identificador"];
    $valorIdentificador = $_POST["valorIdentificador"];

    //se realiza la modificacion
    $res = $consultas->modificarDato($tabla,$campos,$valores,$identificador,$valorIdentificador);

    //en teoria esto imprime la cantidad de filas afectadas, si da 0 debe considerarse un error
    echo $res;
?>