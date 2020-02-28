<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Valurq S.R.L.</title>
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="CSS/popup.css">
	<script src="Js/jquery-3.4.1.js" charset="utf-8"></script>
	<script type="text/javascript" src="Js/funciones.js"> </script>

	<style>
		html, body{
			width: 100%;
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		body{
			margin: 0px;
			background-image: url("Imagenes/background_remax.jpg");
			background-repeat: no-repeat;
			background-size: cover;
			position: relative;
			z-index: 1;
		}

		body:after{
			content: "";
			background-color: rgba(0,0,0,.4);
			position: absolute;
			left: 0px;
			right: 0px;
			top: 0px;
			bottom: 0px;
		}

		#login_wrapper{
			position: relative;
			left: 5%;
			z-index: 3;
			width: 35%;
			height: 35%;
			display: flex;
			flex-flow: row wrap;
			justify-content: center;
		}

		#footer{
			position: relative;
			right: 55%;
			top: 40%;
			z-index: 2;
		}

		#footer p{
			color: rgba(255,255,255,0.9);
			font-size: 12px;
			font-weight: lighter;
			letter-spacing: 0.1em;
			font-family: 'Alata', sans-serif;
		}

		fieldset{
			width: 100%;
			height: 100%;
			padding: 0px;
			border-radius: 10px;
			border: none;
			background-color: rgba(255, 255, 255, 0.8);
		}

		legend{
			-moz-text-align: center;
			text-align: center;
			font-size: 24px;
			font-weight: bold;
			text-transform: uppercase;
			font-family: 'Alata', sans-serif;
			position: relative;
			top: -50px;
			color: rgb(249, 228, 231);
		}

		form{
			height: 80%;
			display: flex;
			flex-flow: column wrap;
			justify-content: space-around;
		}

		input{
			height: 23%;
			border-top: 0px;
			border-right: 0px;
			border-left: 0px;
			border-bottom: 1px solid black;
			font-size: 20px;
			font-family: 'Alata', sans-serif;
			color: rgba(0, 0, 0, 1);
			text-align: center;
			background-color: inherit;
		}

		input[type="text"]::placeholder, input[type="password"]::placeholder{
			font-size: 20px;
			font-family: 'Alata', sans-serif;
			color: rgba(0, 0, 0, .8);
			text-align: center;
		}

		input[type="text"]::placeholder{
			background-image: url("Imagenes/user_icon.png");
			background-size: 22px 22px;
			background-position: 30% 50%;
			background-repeat: no-repeat;
		}

		input[type="password"]::placeholder{
			background-image: url("Imagenes/pass_icon.jpg");
			background-size: 22px 22px;
			background-position: 27% 50%;
			background-repeat: no-repeat;
		}

		.boton{
			box-sizing: border-box;
			width: 40%;
			height: 40px;
			align-self: center;
			border-radius: 10px;
			-webkit-box-shadow: 2px 2px 2px black;
			-moz-box-shadow: 2px 2px 2px black;
			border: 0.5px solid black;
			font-size: 18px;
			font-family: 'Alata', sans-serif;
			font-weight: bold;
			letter-spacing: 0.15em;
			color: rgb(255, 255, 255);
			background-color: #3672D5;
			text-transform: uppercase;
			overflow: hidden;
		}
			
		.boton:hover{
			background-color: rgba(0, 0, 0, 0.2);
			color: rgba(0, 0, 0, .8);
		}
		.boton:focus{
			-webkit-box-shadow: inset 2px 2px 2px black;
			-moz-box-shadow: inset 2px 2px 2px black;
		}

		#popup{
			top: 45%;
			left: 45%;
		}

		#popup #btPopupAceptar{
			font-family: Arial;
			font-size: 12px;
		}
	</style>
</head>
<body>
	<div id="login_wrapper">
		<fieldset id="field_login">
			<legend>Inicio de sesión</legend>
			<form name="login" id="login" method="POST" action="autentica.php">
				<input type="text" name="user" id="user" placeholder="Usuario" autocomplete="off" /><br />
				<input type="password" name="pass" id="pass" placeholder="Contraseña" autocomplete="off"/><br />
				<input type="submit" name="enviar" id="enviar" value="INGRESAR" class="boton" />

			</form>
		</fieldset>

	</div>
	
	<div id="footer">
		<p>Desarrollado por Valurq S.R.L.</p>
	</div>

</body>

<script type="text/javascript">

		var error = <?php echo (isset($_GET['error'])) ? $_GET['error'] : '""';?>;
		mensajeError(error);

		document.getElementById('login').addEventListener('submit', e => {
			if(!valida())
				e.preventDefault();
		});

        function valida(){
           var vuser=document.getElementById('user').value;
           var vpass=document.getElementById('pass').value;
           var vretorno='' ;

           if((vuser=="")||(vpass=="")) {
               popup('Advertencia',"DEBE INGRESAR USUARIO y CONTRASEÑA");
               return false;
           }else{
           		return true;
           }
        }

        function mensajeError (error) {

           		if(error == '1'){
           			popup('Error', 'CONTRASEÑA INCORRECTA');
           		}
           		if(error == '2'){
           			popup('Error', 'USUARIO INCORRECTO');
           		}
        }

  </script>
</html>