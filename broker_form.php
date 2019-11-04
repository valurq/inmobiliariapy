<!DOCTYPE HTML>
<html>
<head>
    <?php
        /*
        SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
        ========================================================================
        */
        session_start();
        include("Parametros/conexion.php");
        $inserta_Datos= new Consultas();
        include("Parametros/verificarConexion.php");
        $id=0;
        $resultado="";

        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos= array( 'dsc_broker','telefono1','telefono2','direccion','ci_nro','fe_nacim','mail','obs','profesion','oficina_id','ciudad_id','usuario_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'brokers',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('nombre','telefono1','telefono2','direccion','cedula','fecha_nac','mail','observacion','profesion');
        }
    ?>


    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>
</head>
<body style="background-color:white">
  <h2>BROKERS</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Nombre</label></td>
        <td><input type="text" name="nombre" id="nombre" value="" placeholder="Ingrese su nombre" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Usuario</label></td>
        <td><?php
        if(!(count($resultado)>0)){
            $inserta_Datos->crearMenuDesplegable('usuario','id','usuario','usuario');
        }else{
            $inserta_Datos->DesplegableElegido(@$resultado[11],'usuario','id','usuario','usuario');
        }?></td>
      </tr>
      <tr>
        <td><label for="">Ciudad</label></td>
        <td><?php
        if(!(count($resultado)>0)){
            $inserta_Datos->crearMenuDesplegable('ciudad','id','dsc_ciudad','ciudad');
        }else{
            $inserta_Datos->DesplegableElegido(@$resultado[10],'ciudad','id','dsc_ciudad','ciudad');
        }?></td>
      </tr>
      <tr>
        <td><label for="">Oficina</label></td>
        <td><?php
        if(!(count($resultado)>0)){
            $inserta_Datos->crearMenuDesplegable('oficina','id','dsc_oficina','oficina');
        }else{
            $inserta_Datos->DesplegableElegido(@$resultado[9],'oficina','id','dsc_oficina','oficina');
        }?></td>
      </tr>
      <tr>
        <td><label for="">Profesion</label></td>
        <td><input type="text" name="profesion" id="profesion" value="" placeholder="Ingrese su profesion"  class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Direccion</label></td>
        <td><input type="text" name="direccion" id="direccion" value="" placeholder="Ingrese su direccion" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Telefono 1</label></td>
        <td><input type="text" name="telefono1" id="telefono1" value="" placeholder="Ingrese su numero telefono" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Telefono 2</label></td>
        <td><input type="text" name="telefono2" id="telefono2" value="" placeholder="Ingrese su numero telefono" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Cedula</label></td>
        <td><input type="text" name="cedula" id="cedula" value="" placeholder="Ingrese su cedula" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Email</label></td>
        <td><input type="text" name="mail" id="mail" value="" placeholder="Ingrese su email" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha Nacimiento</label></td>
        <td><input type="date" name="fecha_nac" id="fecha_nac" value="" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Observacion</label></td>
        <td><textarea name="observacion" id="observacion" class="campos-ingreso"></textarea></td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='broker_panel.php';"  class="boton-formulario">
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


if (isset($_POST['nombre'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['nombre'])){
        $nombre =trim($_POST['nombre']);
        $usuario   =trim($_POST['usuario']);
        $ciudad =trim($_POST['ciudad']);
        $oficina =trim($_POST['oficina']);
        $profesion =trim($_POST['profesion']);
        $direccion =trim($_POST['direccion']);
        $telefono1 =trim($_POST['telefono1']);
        $telefono2 =trim($_POST['telefono2']);
        $cedula =trim($_POST['cedula']);
        $mail =trim($_POST['mail']);
        $fecha_nac =trim($_POST['fecha_nac']);
        $observacion =trim($_POST['observacion']);
        $idForm=$_POST['Idformulario'];
        $creador    ="UsuarioLogin";
        $campos = array( 'usuario_id','ciudad_id','oficina_id','dsc_broker','telefono1','telefono2','direccion','ci_nro','fe_nacim','mail','obs','profesion','creador' );
        $valores="'".$usuario."','".$ciudad."','".$oficina."','".$nombre."','".$telefono1."','".$telefono2."','".$direccion."','".$cedula."','".$fecha_nac."','".$mail."','".$observacion."','".$profesion."','".$creador."'";

        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('brokers',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('brokers',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if( (document.getElementById('nombre').value !='')&&(document.getElementById('cedula').value !='')  ){
		    return true ;

		}else{
        // Error - Advertencia - Informacion
            popup('Advertencia','Es necesario ingresar el nombre y la cedula') ;
            return false ;
		}
	}
  </script>

</html>
