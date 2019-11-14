<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
          <script src="Js/jquery-3.4.1.js" charset="utf-8"></script>
          <link rel="stylesheet" href="CSS/popup.css">
          <script type="text/javascript" src="Js/funciones.js"> </script>
    </head>
    <body>
        <form name="login" method="POST"  style="margin:0px" >
            <input name="user" id="user" type="text" style="position:absolute;width:200px;left:518px;top:267px;z-index:6">
            <input name="pass" id="pass" type="password" style="position:absolute;width:200px;left:518px;top:322px;z-index:7">
            <input name="INGRESAR" type="button" value="INGRESAR" onclick="valida()"   style="position:absolute;left:568px;top:357px;z-index:10">
        </form>
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
