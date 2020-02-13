<?php
include('conexion.php');
$consultas=new Consultas();
$vec=json_decode($_POST['cabecera']);
$tabla=$_POST['tabla'];
$valores="";
$campos=array();
$valorConsulta=array();
$resultado=array();
foreach ($vec as $key => $value) {
    $valores.="'".strtoupper($value)."',";
    array_push($campos,$key);
    array_push($valorConsulta,$value);
}
$valores = substr($valores,0,-1);

if(count($vec)>0){
    $retorno=$consultas->insertarDato($tabla,$campos,$valores);
    //echo $retorno."error";
    if($retorno!=1){
        array_push($resultado,1);
    }else{
        array_push($resultado,0);
        if($tabla=="dco"){
            $idDco=$consultas->consultarDatosQ(array('id'),$tabla,'ORDER BY  fecreacion DESC limit 1',$campos,$valorConsulta);
            $idDco=$idDco->fetch_array();
            $idDco=$idDco[0];
            array_push($resultado,$idDco);
        }
    }
    echo json_encode(array_values($resultado),JSON_PRETTY_PRINT);
}
 ?>
