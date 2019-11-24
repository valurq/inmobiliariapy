<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
          <script src="Js/jquery-3.4.1.js" charset="utf-8"></script>
          <link rel="stylesheet" href="CSS/popup.css">
          <script type="text/javascript" src="Js/funciones.js"> </script>

          <style>
          	html, body{
          		height: 100%;
          	}

          	body{
          		margin: 0px;
          		background-color: #EBE7E7;
          		display: flex;
          		justify-content: center;
          		align-items: center;
          	}

      			div{
      				width: 30%;
      				height: 30%;
      			}

      			fieldset{
      				width: 100%;
      				height: 100%;
      			}
          </style>
    </head>
<body>
	<div id="login_wrapper">
	    <fieldset>
		    <legend>ACCOUNT LOGIN</legend>
		        <form name="login" method="POST" >
		            <input name="user" id="user" type="text" />
		            <input name="pass" id="pass" type="password" />
		            <input name="INGRESAR" type="button" value="INGRESAR" onclick="valida()" />
		        </form>
		</fieldset>
	</div>
</body>
    <script type="text/javascript">

        function valida(){
           var vuser=document.getElementById('user').value;
           var vpass=document.getElementById('pass').value;
           var vretorno='' ;

           if((vuser=="")||(vpass=="")) {
               popup('Advertencia',"DEBE INGRESAR USUARIO y CONTRASEÑA");
           }else {
                   //metodo,url destino, nombre parametros y valores a enviar, nombre con el que recibe la consulta
                   $.post("autentica.php", {user: vuser, pass: vpass }, function(retorno) {
                      vretorno=retorno.trim() ;

                       if(vretorno=="correcto"){
                         window.location='menu_principal.php';
                         //docuent.body.innerHTML=
                       } ;

                       if(vretorno=="errorUser"){
                           popup('Error',"USUARIO INCORRECTO");

                       } ;

                       if(vretorno=="errorPass"){
                           popup('Error',"CONTRASEÑA INCORRECTA");
                       } ;


                    });
           }
        }

  </script>
</html>
