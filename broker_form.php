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
            $campos=array('dsc_broker','telefono1','telefono2','direccion','ci_nro','fe_nacim','mail','obs','apellido','profesion','usuario_id','(SELECT usuario FROM usuario WHERE id=usuario_id)','oficina_id','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)','ciudad_id','(SELECT dsc_ciudad FROM ciudad WHERE id=ciudad_id)');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'brokers',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('nombre','telefono1','telefono2','direccion','cedula','fecha_nac','mail','observacion','apellido','profesion','usuario','usuarioLista','oficina','oficinaLista','ciudad','ciudadLista');
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
        <style>
          span.warning{
            color: #C72F36;
            font-size: 16px;
            background-color: rgba(237,173,175, 0.3);
            padding: 3px;
            border-radius: 5px;
            border: 1px solid #C72F36;
          }
        </style>
</head>
<body style="background-color:white">
  <h2>BROKERS</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <?php
        if ($id == 0) {
          echo '<tr><td colspan="4"><span class="warning">Observación: para crear la ficha de broker, primero debe crear el usuario</span></td></tr>';
        }
       ?>
      <tr>
        <td><label for="">Usuario</label></td>
        <td><input list="usuLista" id="usuarioLista" name="usuarioNombre" autocomplete="off" placeholder="Ingrese el nombre de usuario" onkeyup="buscarListaQ(['usuario'], this.value,'usuario', 'usuario', 'usuLista', 'usuario', 'asignado', 'NO') " class="campos-ingreso">
        <datalist id="usuLista">
          <option value=""></option>
        </datalist>
        <input type="hidden" name="usuario" id="usuario"></td>
      </tr>
      <tr>
        <td><label for="">Nombre</label></td>
        <td><input type="text" name="nombre" id="nombre" value="" readonly="readonly" placeholder="Ingrese el nombre" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td> <label for="">Apellido</label> </td>
        <td> <input type="text" name="apellido" id='apellido' value="" readonly="readonly" placeholder="Ingrese el apellido" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Cédula</label></td>
        <td><input type="text" name="cedula" id="cedula" value="" placeholder="Ingrese el número de cedula" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Ciudad</label></td>
        <td><input list="ciuLista" id="ciudadLista" name="ciudad" autocomplete="off" placeholder="Ingrese la ciudad correspondiente" onkeyup="buscarLista(['dsc_ciudad'], this.value,'ciudad', 'dsc_ciudad', 'ciuLista', 'ciudad') " class="campos-ingreso">
        <datalist id="ciuLista">
          <option value=""></option>
        </datalist>
      <input type="hidden" name="ciudad" id="ciudad"></td>
      </tr>
      <tr>
        <td><label for="">Oficina</label></td>
        <td>
          <input list="ofiLista" id="oficinaLista" name="oficinaNombre" autocomplete="off" placeholder="Ingrese el nombre de la oficina" onkeyup="buscarListaQ(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'ofiLista', 'oficina', ['estado', 'tipo'], ['ACTIVO', 'RE/MAX']) " class="campos-ingreso">
        <datalist id="ofiLista">
          <option value=""></option>
        </datalist>
      <input type="hidden" name="oficina" id="oficina">
    </td>
      </tr>
      <tr>
        <td><label for="">Profesión</label></td>
        <td><input type="text" name="profesion" id="profesion" value="" placeholder="Ingrese la profesión"  class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Dirección</label></td>
        <td><input type="text" name="direccion" id="direccion" value="" placeholder="Ingrese la dirección" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Email</label></td>
        <td><input type="text" name="mail" id="mail" value="" readonly="readonly" placeholder="Ingrese el email" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Teléfono</label></td>
        <td><input type="text" name="telefono1" id="telefono1" value="" placeholder="Ingrese el número teléfono" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Celular</label></td>
        <td><input type="text" name="telefono2" id="telefono2" value="" placeholder="Ingrese el número celular" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha Nacimiento</label></td>
        <td><input type="date" name="fecha_nac" id="fecha_nac" value="" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Observación</label></td>
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
        $apellido =trim($_POST['apellido']);
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
        $creador    =$_SESSION['usuario'];
        $moneda = $inserta_Datos->consultarDatos(array('id'),'moneda'," LIMIT 1","tipo",'Local' );
        $moneda= $moneda->fetch_array(MYSQLI_NUM);
        $moneda=$moneda[0];
        $campos=array('usuario_id','ciudad_id','oficina_id','dsc_broker','telefono1','telefono2','direccion','ci_nro','fe_nacim','mail','obs','profesion','creador','apellido' );
        $valores="'".$usuario."','".$ciudad."','".$oficina."','".$nombre."','".$telefono1."','".$telefono2."','".$direccion."','".$cedula."','".$fecha_nac."','".$mail."','".$observacion."','".$profesion."','".$creador."','".$apellido."'";

        $camposV = array( 'dsc_vendedor','nro_doc', 'cod_denver', 'oficina_id', 'cod_iconnect', 'moneda_id', 'mail', 'telefono1', 'telefono2','fe_ingreso_py','categoria','fe_ingreso_int','tipo','fe_cumple','fee_mensual','fe_finprueba','obs','fee_afiliacion','curso_acm','curso_fireUP','curso_succeed','apellido','creador');
        $valoresV="'".$nombre."','".$cedula."','','".$oficina."','','".$moneda."','".$mail."','".$telefono1."','".$telefono2."','','50','','','','','','".$observacion."','','','','','".$apellido."','".$creador."'";
        //echo "$valoresV";
        //print_r($camposV);
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('brokers',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('brokers',$campos,$valores);
            $inserta_Datos->insertarDato('vendedor',$camposV,$valoresV);
            $inserta_Datos->modificarDatoQ('usuario', ['asignado'], ['SI'], 'id', $usuario);
        }
    }
}
?>
<script type="text/javascript">

    let idForm = '<?php echo $id ?>';
    if(idForm != 0){
      document.getElementById('usuarioLista').setAttribute('readonly', 'readonly');
      console.log(idForm);
    }

    document.getElementById('usuarioLista').addEventListener('focusout', (e) => {
    idUsuario = document.getElementById('usuario').value;
    obtenerDatosCallBackQuery(`SELECT nombre, apellido, mail FROM usuario WHERE id = ${idUsuario}`, resultado => {
      document.getElementById('nombre').value = resultado[0][0];
      document.getElementById('apellido').value = resultado[0][1];
      document.getElementById('mail').value = resultado[0][2];
    });
  });
//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if($('#nombre').val() == ""){
      popup('Advertencia','Es necesario ingresar el nombre del broker!!') ;
      return false ;
    }else if($("#apellido").val()==""){
      popup('Advertencia','Es necesario ingresar el apellido del broker!!') ;
      return false ;
    }else if($("#usuario").val()==""){
      popup('Advertencia','Es necesario ingresar el usuario del broker!!') ;
      return false ;
    }else if($("#cedula").val()==""){
      popup('Advertencia','Es necesario ingresar el número de documento del broker!!') ;
      return false ;
    }else if($("#ciudad").val()==""){
      popup('Advertencia','Es necesario ingresar una ciudad!!') ;
      return false ;
    }else if($("#ciudadLista").val()==""){
      popup('Advertencia','Es necesario ingresar una ciudad!!') ;
      return false ;
    }else if($("#oficina").val()==""){
      popup('Advertencia','Es necesario ingresar la oficina correspondiente!!') ;
      return false ;
    }else if($("#oficinaLista").val()==""){
      popup('Advertencia','Es necesario ingresar la oficina correspondiente!!') ;
      return false ;
    }else if($("#profesion").val()==""){
      popup('Advertencia','Es necesario ingresar la profesión del broker!!') ;
      return false ;
    }else if($("#direccion").val()==""){
      popup('Advertencia','Es necesario ingresar una dirección!!') ;
      return false ;
    }else if($("#mail").val()==""){
      popup('Advertencia','Es necesario ingresar un correo electrónico!!') ;
      return false ;
    }else if($("#telefono2").val()==""){
      popup('Advertencia','Es necesario ingresar un número de celular!!') ;
      return false ;
    }else if($("#fecha_nac").val()==""){
      popup('Advertencia','Es necesario ingresar la fecha de nacimiento!!') ;
      return false ;
    }else {
      // popup('Informacion','Realizado con éxito') ;
      return true ;
    }
	}
  </script>

</html>
