<?php
    include('conexion.php');
    $consultas= new Consultas();
    $id=$_POST['id'];
    $tabla=$_POST['tabla'];
    $error="";
    if((isset($id))&&(isset($tabla))){
        $error=$consultas->eliminarDato($tabla,'id',$id);
    }
    echo "1";
 ?>
