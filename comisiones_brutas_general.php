<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		session_start();

	?>


	<script src="http://momentjs.com/downloads/moment.min.js"></script>
	<script type="text/javascript" src="Js/funciones.js"></script>
	<link rel="stylesheet" href="CSS/popup.css">
	<script src="https://code.jquery.com/jquery-3.4.0.js"
			integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			crossorigin="anonymous"></script>
	<meta charset="UTF-8">
	<title>VALURQ_SRL</title>
	<style>
		html, body{
			width: 100%;
			height: 100%;
		}

		body{
			display: flex;
			justify-content: center;
			align-items: center;
		}

		#container{
			width: 80%;
			display: flex;
			justify-content: center;

		}

		form{
			width: 50%;
		}

		#wrapper{
			display: flex;
			flex-flow: column;
			justify-content: center;
			align-items: left;
			border: 2px solid #072D58;
			border-radius: 10px;
			padding: 10px;
			font-family: arial;
		}


				h2{
					/*letter-spacing: 0.15em;*/
					font-size: 24px;
					align-self: center;
				}

				label{
					align-self: flex-start;
					/*letter-spacing: 0.15em;*/
					font-size: 16px;
					align-self: center;
				}

		input{
			width: 100%;
			font-family: inherit;
			letter-spacing: 0.15em;
			font-size: 14px;
			align-self: center;

		}

		input[type="button"]{
			width: 50%;
			background-color: #072D58;
			height: 40px;
			color: #DFC7C7;
			border: none;
			letter-spacing: 0.15em;
			font-size: 16px;
			align-self: center;

		}

		input[type="button"]:hover{
			background-color: #1F4A7B;
			color: #DFC7C7;

		}

		#popup{
			position: absolute;
			top: 50%;
			left: 50%;
		}

	</style>


</head>
<body>
	<div id="container">
		<form action="">

			<div id="wrapper">
				<h2>Comision bruta por oficina</h2>

				<label for="desde">Seleccione mes</label><select style="width:160px; align-self:center" name="mes" id="mes">
					<option value="0" selected>--seleccione un mes--</option>
				  <option value="1">ENERO</option>
				  <option value="2">FEBRERO</option>
				  <option value="3">MARZO</option>
					<option value="4">ABRIL</option>
				  <option value="5">MAYO</option>
				  <option value="6">JUNIO</option>
					<option value="7">JULIO</option>
				  <option value="8">AGOSTO</option>
				  <option value="9">SETIEMBRE</option>
					<option value="10">OCTUBRE</option>
				  <option value="11">NOVIEMBRE</option>
				  <option value="12">DICIEMBRE</option>
				</select>
<br>
				<label for="desde">Ingrese un año</label>
				<input type="text" name="vaa" id="vaa" style="width:100px">
<br>
				<input type="button" id="aceptar" name="aceptar" value="Aceptar" />
			</div>
		</form>
	</div>

</body>

<script>



	document.getElementById("aceptar").addEventListener("click", (e) => {
		var mes = document.getElementById('mes').value;
		var vaa = document.getElementById('vaa').value;

		if( (mes == "") || (vaa == "")  ){
			popup('Advertencia','Por favor, seleccione un mes e ingrese un año') ;
			e.preventDefault();
		}
		else{
				
			var par_mes = '&mes='+mes;
			var par_aa = '&aa='+vaa;

			var direccion = "http://localhost/remax/reporte_intermediario.php?reporte=remax_com_bruta_oficina"+par_mes+par_aa ;

			window.location=direccion;
		}

	});

</script>
</html>
