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
            $campos=array( 'dsc_oficina', 'ruc', 'direccion', 'mail', 'telefono1', 'telefono2', 'tel_movil', 'razon','obs', 'pais_id','ciudad_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'oficina',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            //print_r($resultado);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array( 'oficina', 'ruc', 'direccion', 'email', 'tel1', 'tel2', 'celular',  'razon','obs');
            //print_r($camposIdForm);

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
  <h2>DEFINICIÓN DE INMOBILIARIA EXTERNA</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->

<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Oficina</label></td>
        <td><input type="text" name="oficina" id="oficina" value="" placeholder="Ingrese el nombre de la oficina" class="campos-ingreso"></td>

        <td><label for="">Ruc</label></td>
        <td><input type="text" name="ruc" id="ruc" value="" placeholder="Ingrese el RUC" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">País</label></td>
        <td>
          <?php
          //name, campoId, campoDescripcion, tabla
            $inserta_Datos->crearMenuDesplegable('pais', 'id', 'dsc_pais', 'pais');
          ?>
        </td>

        <td><label for="">Razón Social</label></td>
        <td>
          <input type="text" name="razon" id="razon" value="" placeholder="Ingrese la razón social" class="campos-ingreso">
        </td>
      </tr>
      <tr>
        <td><label for="">Ciudad</label></td>
        <td>
          <?php
          //name, campoId, campoDescripcion, tabla
            $inserta_Datos->crearMenuDesplegable('ciudad', 'id', 'dsc_ciudad', 'ciudad');
          ?>
          <td><label for="">Dirección</label></td>
          <td><input type="text" name="direccion" id="direccion" value="" placeholder="Ingrese la direccion de la oficina" class="campos-ingreso"></td>
        </td>
      </tr>
      <tr>
        <td><label for="">Email</label></td>
        <td><input type="email" name="email" id="email" value="" placeholder="Ingrese el email" class="campos-ingreso"></td>

        <td><label for="">Num. Celular</label></td>
        <td><input type="text" name="celular" id="celular" value="" placeholder="Ingrese numero del celular" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Teléfono 1</label></td>
        <td><input type="text" name="tel1" id="tel1" value="" placeholder="Ingrese numero del teléfono" class="campos-ingreso"></td>
        <td><label for="">Teléfono 2</label></td>
        <td><input type="text" name="tel2" id="tel2" value="" placeholder="Ingrese numero del teléfono" class="campos-ingreso"></td>

      </tr>
      <tr>
        <td><label for="">Observación</label></td>
        <td><textarea name="obs" id="obs" class="campos-ingreso"></textarea></td>
      </tr>
      <tr>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='inmobiliaria_externa_panel.php';"  class="boton-formulario">
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


if (isset($_POST['oficina'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['oficina'])){
        $oficina =trim($_POST['oficina']);
        $ruc =trim($_POST['ruc']);
        $pais =trim($_POST['pais']);
        $ciudad =trim($_POST['ciudad']);
        $direccion =trim($_POST['direccion']);
        $email =trim($_POST['email']);
        $tel1 =trim($_POST['tel1']);
        $tel2 =trim($_POST['tel2']);
        $celular =trim($_POST['celular']);
        $obs =trim($_POST['obs']);
        $razon = trim($_POST['razon']);
        //$estado = trim($_POST['estado']);
        $idForm=$_POST['Idformulario'];
        $creador =$_SESSION['usuario'];
        $campos = array( 'dsc_oficina','pais_id', 'ciudad_id', 'ruc', 'direccion', 'mail', 'telefono1', 'telefono2', 'tel_movil', 'obs', 'tipo',  'razon','estado', 'creador');
        $valores="'".$oficina."', '".$pais."', '".$ciudad."', '".$ruc."', '".$direccion."', '".$email."',  '".$tel1."', '".$tel2."', '".$celular."', '".$obs."', 'OTROS', '".$razon."','ACTIVO', '".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SO1N PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('oficina',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('oficina',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if($("#oficina").val()==""){
      popup('Advertencia','Es necesario ingresar el nombre de la oficina!!') ;
      return false ;
    }else if($("#direccion").val()==""){
      popup('Advertencia','Es necesario ingresar la direccion!!') ;
      return false ;
    }else if($("#email").val()==""){
      popup('Advertencia','Es necesario ingresar el correo electronico!!') ;
      return false ;
    }
  }
  </script>

</html>
