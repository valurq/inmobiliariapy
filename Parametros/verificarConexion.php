<?php
$consulta= new Consultas();
 $campos=array('id','perfil_id','usuario','pass');

// echo "*id ".$_SESSION['idUsu']."*<br>" ;
// echo "*perfil ".$_SESSION['perfil']."*<br>" ;
// echo "*usu ".$_SESSION['usuario']."*<br>" ;
// echo "*pass ".$_SESSION['contra']."*<br>" ;

// $resultado=$consulta->consultarDatos($campos,'usuario',"","usuario",$_SESSION['usuario'] );
// $resultado=$resultado->fetch_array(MYSQLI_NUM);
//echo $resultado[1]."/".$_SESSION['perfil']."--".$_SESSION['usuario']."/".$resultado[2]."--".$_SESSION['contra']."/".$resultado[3] ;


// if((($_SESSION['perfil']!=$resultado[1]) || ($_SESSION['usuario']!=$resultado[2]) || ($_SESSION['contra']!=$resultado[3]))){
//     session_unset();
//     session_write_close();
//     //echo "<script>window.location='login.php'</script>";
// }
?>
