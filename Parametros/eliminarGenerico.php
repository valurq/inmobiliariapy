<?php
    include('conexion.php');
    $consultas= new Consultas();
    $id=$_POST['id'];
    $campo=$_POST['campoIdentificador'];
    $tabla=$_POST['tabla'];
    $error="";
    if((isset($id))&&(isset($tabla))){
        $consultas->eliminarDato($tabla,$campo,$id);
    }
    echo "1";
 ?>
