<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <?php
        /*
        SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
        ========================================================================
        */
        session_start();
        include("Parametros/conexion.php");
        $consulta=new Consultas();
        include("Parametros/verificarConexion.php");
        $id=0;
        $resultado="" ;
        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_SESSION['idUsu'])){
            $id=$_SESSION['idUsu'];
            $campos=array('pass');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$consulta->consultarDatos($campos,'usuario',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
        }
    ?>
    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">

      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>

</head>
<body style="background-color:white" >
<h2 class="titulo-formulario">Cambiar Contraseña</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="usuarioForm" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="idformulario" id="idformulario" value=<?php echo $id;?> >
    <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
    <table class="tabla-fomulario">
      <tbody>
        <tr>
          <td><label for="">Contraseña anterior</label></td>
          <td><input type="password" name="aPass" id="aPass" value="" placeholder="Ingrese su contraseña anterior" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Nueva contraseña</label></td>
          <td><input type="password" name="nPass" id="nPass" value="" placeholder="Ingrese su nueva contraseña" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Confirmacion contraseña</label></td>
          <td><input type="password" name="nPassC" id="nPassC" value="" placeholder="Confirme su nueva contraseña" class="campos-ingreso"></td>
        </tr>
      </tbody>
    </table>


  <!-- BOTONES -->
  <input name="guardar" type="button" value="Guardar" class="boton-formulario guardar" onclick="verificar()" >
  <input name="volver" type="button" value="Volver" class="boton-formulario" onclick = "location='about:blank';" >
</form>


</body>

<?php
    if(isset( $_POST['nPass'] )) {

        //======================================================================================
        // NUEVO REGISTRO
        //======================================================================================
        $pass=$_POST['nPass'];
        $creador="UsuarioLogin" ;
        $idForm= $_POST['Idformulario'];
        $campos = array( 'pass' );
        $valores="'".$usuario."',4'".$perfil."','".$nombre."','".$apellido."','".$cargo."','".$obs."','".$mail."','".$creador."'";
        /*
        VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        // if(isset($idForm)&&($idForm!=0)){
        //     $consulta->modificarDato('usuario',$campos,$valores,'id',$idForm);
        // }else{
        //     $consulta->insertarDato('usuario',$campos,$valores);
        // }
    }
?>
<script type="text/javascript">
//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
        if($("#aPass").val()==""){
            popup('Advertencia','Es necesario ingresar la contraseña anterior!!') ;
            return false ;
        }else if($("#nPass").val()==""){
            popup('Advertencia','Es necesario ingresar la contraseña nueva!!') ;
            return false ;
        }else if($("#nPAssC").val()==""){
            popup('Advertencia','Es necesario confirmar la contraseña!!') ;
            return false ;
        }else if(($("#nPass").val()!=$("#nPassC").val())) {
            popup('Error','La nueva contraseña no coincide con la confirmacion!!') ;
            return false ;
        }else if(obtenerContraseña()==0){
            popup('Error','La contraseña anterior no es correcta!!') ;
            return false ;
        }else {
            insertarContraseña();
            return true
        }

	}
    function obtenerContraseña(){
        //console.log($("#aPass").val());
        $.ajaxSetup({async:false});
         var res="";
        $.post("Parametros/comprobarContraseña.php", {id:$("#idformulario").val(),contra:$("#aPass").val()}, function(resultado) {
            console.log(resultado);
            res=resultado;
        });
         $.ajaxSetup({async:true});
         pausa(1000);
         return res;
    }
    function insertarContraseña(){
        var campos=['pass'];
        var valores=[$("#nPass").val()]
        $.post("Parametros/cambiarContraseña.php", {idUsuario:$("#idformulario").val(),contra:$("#nPass").val()}, function(resultado) {
            if(resultado==1){
                popup("Informacion","Cambio realizado con éxito");
            }else{
                popup("Error","Error al actualizar la contraseña")
            }
        });
    }

  </script>

</html>
