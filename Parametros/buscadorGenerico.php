<?php
    include('conexion.php');
    $consultas= new Consultas();
    @$camposRes=$_POST['camposResultado'];
    @$valor=$_POST['dato'];
    @$tabla=$_POST['tabla'];
    @$campo=$_POST['campoBusqueda'];
    @$campoC=$_POST['campoCondicion'];
    @$valorC=$_POST['valorCondicion'];
    //print_r($valorC);
    array_unshift($camposRes,'id');
    $resultado=array(array($camposRes));
    $datos=$consultas->buscarDatoQ($camposRes,$tabla,$campo,$valor,$campoC,$valorC);
    if(!(is_bool($datos))){
        while ($fila=$datos->fetch_row()) {
            array_push($resultado,$fila);
        }
        //$resultado=$resultado->fetch_assoc();
        //$resultado=array_shift($resultado);
    }else{
        //$resultado=array('');
    }
    echo json_encode(array_values($resultado),JSON_PRETTY_PRINT);
 ?>
