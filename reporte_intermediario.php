<?php
session_start();
	include("Parametros/conexion.php");
	$inserta_Datos= new Consultas();
	include("Parametros/verificarConexion.php");

 $reporte = $_GET['reporte'] ;

$resultado=$inserta_Datos->consultarDatos(array('usuario','cargo'),'usuario',"","id",$_SESSION['idUsu'] );
$resultado=$resultado->fetch_array(MYSQLI_NUM);
$v_usuario="Usuario:".$resultado[0].", Cargo:".$resultado[1] ;
echo 'control -1' ;

$v_oficinaid =0 ;
//-- busca el usuario en VENDEDOR para obtener el id de la oficina.
$resultado=$inserta_Datos->consultarDatos(array('oficina_id'),'vendedor',"","usuario_id",$_SESSION['idUsu'] );
$resultado=$resultado->fetch_array(MYSQLI_NUM);

if (isset($resultado[0])) {
	$v_oficinaid = $resultado[0] ;
}

//-- busca el usuario en MANAGER para obtener el id de la oficina.
$resultado=$inserta_Datos->consultarDatos(array('oficina_id'),'manager',"","usuario_id",$_SESSION['idUsu'] );
$resultado=$resultado->fetch_array(MYSQLI_NUM);

if (isset($resultado[0])) {
	$v_oficinaid = $resultado[0] ;
}
echo 'control 0' ;
//-- busca el usuario en BROKER para obtener el id de la oficina.
$resultado=$inserta_Datos->consultarDatos(array('oficina_id'),'brokers',"","usuario_id",$_SESSION['idUsu'] );
$resultado=$resultado->fetch_array(MYSQLI_NUM);

if (isset($resultado[0])) {
	$v_oficinaid = $resultado[0] ;
}
echo 'control 1' ;
	if ($v_oficinaid > 0) {
				// con el ID de oficina traigo la descripcion de la oficina.
				$resultado=$inserta_Datos->consultarDatos(array('dsc_oficina'),'oficina',"","id",$v_oficinaid );
				$resultado=$resultado->fetch_array(MYSQLI_NUM);
				$v_oficina = $resultado[0] ;}
	else{
		$v_oficina = 'RE/MAX Regional Paraguay' ;
	}

$v_url = 'http://localhost:8080/birt/frameset?__report='.$reporte.'.rptdesign&oficina='.$v_oficina.'&usuario='.$v_usuario ;
//echo $v_url ;
echo "<script>window.location='".$v_url."'</script>";

?>
