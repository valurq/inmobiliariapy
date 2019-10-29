<?php
    include('conexion.php');
    $consultas= new Consultas();
    $camposRes=$_POST['camposResultado']; //los campos a seleccionar de la tabla
    $tabla=$_POST['tabla']; //el o los datos que se usaran en la clausula where

    /*NOTA --> :{
        si no se valida que estos datos esten definidos, el mensaje de que no estan definidos va junto al json y causa error
        se puede usar error_reporting(0) tambien para paliar esto
        }*/
    $valor=(isset($_POST["dato"]))?$_POST['dato']:""; //la tabla sobre la cual se opera
    $campo=(isset($_POST["campoBusqueda"]))?$_POST['campoBusqueda']:""; //el o los campos que se utilizaran en la clausula where
    $where=(isset($_POST["where"]))?$_POST['where']:""; //la clausula where
    
    array_unshift($camposRes,'id');
    $resultado=array(array($camposRes));

    if(isset($where) and !empty($where)){
        //esto quiere decir que no se esta filtrando
        if($where=="WHERE"){
            $where = "";
        }
        $datos=$consultas->buscarDatoCustom($camposRes,$tabla,$where);
        while ($fila=$datos->fetch_row()) {
            array_push($resultado,$fila);
        }
    }else{
        $datos=$consultas->buscarDato($camposRes,$tabla,$campo,$valor);
        while ($fila=$datos->fetch_row()) {
            array_push($resultado,$fila);
        }
    }
    //$resultado=$resultado->fetch_assoc();
    //$resultado=array_shift($resultado);
    echo json_encode(array_values($resultado),JSON_PRETTY_PRINT);

    /*switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
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
    }*/

 ?>
