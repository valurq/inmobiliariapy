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
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos=array('usuario','nombre','apellido','mail','cargo','obs','pass');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$consulta->consultarDatos($campos,'usuario',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('usuario','nombre','apellido','correo','cargo','observacion');
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
<h2 class="titulo-formulario">USUARIO</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="usuarioForm" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="idformulario" id="idformulario" value=<?php echo $id;?> >
    <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
    <table class="tabla-fomulario">
      <tbody>
        <tr>
          <td><label for="">Usuario</label></td>
          <td><input type="text" name="usuario" id="usuario" value="" placeholder="Ingrese su usuario" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Perfil</label></td>
          <td><?php $consulta->crearMenuDesplegable('perfil','id','perfil','perfil'); ?></td>
        </tr>
        <tr>
          <td><label for="">Nombre</label></td>
          <td><input type="text" name="nombre" id="nombre" value="" placeholder="Ingrese su nombre" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Apellido</label></td>
          <td><input type="text" name="apellido" id="apellido" value="" placeholder="Ingrese su apellido" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Cargo</label></td>
          <td><input type="text" name="cargo" id="cargo" value="" placeholder="Ingrese el cargo al que corresponde" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Correo</label></td>
          <td><input type="email" name="correo" id="correo" value="" placeholder="Ingrese su usuario de correo" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Contraseña</label></td>
          <td><input type="password" name="pass" id="pass" value="" placeholder="Ingrese su contraseña" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Confirmacion de contraseña</label></td>
          <td><input type="password" name="passC" id="passC" value="" placeholder="Ingrese su contraseña de nuevo" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Observacion</label></td>
          <td><textarea name="observacion" id='observacion' class='campos-ingreso'></textarea> </td>
        </tr>
      </tbody>
    </table>


  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar" >
  <input name="volver" type="button" value="Volver" class="boton-formulario" onclick = "location='usuario_panel.php';" >
</form>


</body>

<?php
    /*
    LLAMADA A FUNCION JS CORRESPONDIENTE A CARGAR DATOS EN LOS CAMPOS DEL FORMULARIO HTML
    */
    if(($id!=0 )){
        /*
        CONVERTIR LOS ARRAY A UN STRING PARA PODER ENVIAR POR PARAMETRO A LA FUNCION JS
        */
        $valores=implode(",",$resultado);
        $camposIdForm=implode(",",$camposIdForm);
        //LLAMADA A LA FUNCION JS
        echo '<script>cargarCampos("'.$camposIdForm.'","'.$valores.'")</script>';
    }
    if(isset( $_POST['usuario'] )) {

        //======================================================================================
        // NUEVO REGISTRO
        //======================================================================================
        $usuario=$_POST['usuario'];
        $perfil=$_POST['perfil'];
        $nombre=$_POST['nombre'];
        $apellido=$_POST['apellido'];
        $cargo=$_POST['cargo'];
        $mail=$_POST['correo'];
        $pass=$_POST['pass'];
        $pass=$_POST['pass'];
        $obs=$_POST['observacion'];
        $creador="UsuarioLogin" ;
        $idForm= $_POST['Idformulario'];
        $campos = array( 'usuario','perfil_id','nombre','apellido','cargo','obs','mail','creador' );
        $valores="'".$usuario."','".$perfil."','".$nombre."','".$apellido."','".$cargo."','".$obs."','".$mail."','".$creador."'";
        if(!(isset($pass))){
            array_push($campos,'pass');
            $valores.=",'".md5($pass)."'";
        }
        /*
        VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $consulta->modificarDato('usuario',$campos,$valores,'id',$idForm);
        }else{
            $consulta->insertarDato('usuario',$campos,$valores);
        }
    }
?>
<script type="text/javascript">
//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
        if($("#usuario").val()==""){
            popup('Advertencia','Es necesario ingresar el usuario!!') ;
            return false ;
        }else if($("#nombre").val()==""){
            popup('Advertencia','Es necesario ingresar el nombre!!') ;
            return false ;
        }else if($("#apellido").val()==""){
            popup('Advertencia','Es necesario ingresar el apellido!!') ;
            return false ;
        }else if(($("#correo").val()=="")||((($("#correo").val()).indexOf("@"))==-1)){
            popup('Advertencia','Es necesario ingresar el correo!!') ;
            return false ;
        }else {
            return true
        }

	}
  </script>

</html>
