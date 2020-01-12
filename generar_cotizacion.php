<?php 
	include("Parametros/conexion.php");
	$inserta_Datos= new Consultas();

	/*$.get("https://dolar.melizeche.com/api/1.0/", {}, function(results){
		console.log(`Compra: ${results.dolarpy.cambioschaco.compra} Venta: ${results.dolarpy.cambioschaco.venta}`);
	});*/

	
	$campos = array('moneda_id', 'cotiz_compra', 'cotiz_venta', 'fecha', 'creador');
	
	$moneda_id = "3";

	$data = json_decode( file_get_contents('https://dolar.melizeche.com/api/1.0/'), true );
	$cotiz_compra = $data['dolarpy']['cambioschaco']['compra'];
	$cotiz_venta = $data['dolarpy']['cambioschaco']['venta'];
	
	$fecha = date("Y")."-".date("m")."-".date("d");
	$fecha = date("Y-m-d",strtotime($fecha));
	$creador = "SISTEMA";
	$valores="'".$moneda_id."','".$cotiz_compra."','".$cotiz_venta."','".$fecha."','".$creador."'";

	$inserta_Datos->insertarDato('cotizacion',$campos,$valores);
	
?>