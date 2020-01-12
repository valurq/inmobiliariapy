<?php

$consulta= new Consultas();
$campos=array('id','perfil_id','usuario','pass');
const TIEMPO_MAXIMO = 60;


//define("TIEMPO_MAXIMO",60);

// echo "*id ".$_SESSION['idUsu']."*<br>" ;
// echo "*perfil ".$_SESSION['perfil']."*<br>" ;
// echo "*usu ".$_SESSION['usuario']."*<br>" ;
// echo "*pass ".$_SESSION['contra']."*<br>" ;

$resultado=$consulta->consultarDatos($campos,'usuario',"","id",$_SESSION['idUsu'] );
$resultado=$resultado->fetch_array(MYSQLI_NUM);
//echo $resultado[1]."/".$_SESSION['perfil']."--".$_SESSION['usuario']."/".$resultado[2]."--".$_SESSION['contra']."/".$resultado[3] ;


if((($_SESSION['perfil']!=$resultado[1]) || ($_SESSION['usuario']!=$resultado[2]) || ($_SESSION['contra']!=$resultado[3]))){
    session_unset();
    session_write_close();
    echo "<script>window.location='index.html'</script>";
}else{
    /*
    //obtenemos cuanto tiempo ha pasado desde la ultima accion
    $inactivity = time() - $_SESSION["uAccion"];
    if( $inactivity > MAX_INACTIVITY ){
        $controller = "usuarios";
        $action = "tryLogOut";
    }else{
        //si todavia puede estar activo, renovamos su permanencia
        $_SESSION["uAccion"] = time();
    }
    */
}
/*
if(isset($_SESSION["id"]) and !empty($_SESSION["id"])){
    //obtenemos cuanto tiempo ha pasado desde la ultima accion
    $inactivity = time() - $_SESSION["last_action"];
    if( $inactivity > MAX_INACTIVITY ){
        $controller = "usuarios";
        $action = "tryLogOut";
    }else{
        //si todavia puede estar activo, renovamos su permanencia
        $_SESSION["last_action"] = time();
    }
}
*/
?>
