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
            $campos=array('dsc_ciudad','dsc_inmueble','cate_propiedad','Finca_ccctral','propietario','totalm2','estado','fecha_alta','fecha_vto','mail_propietario','operacion','precio','precio_mon','captacion_com','id_remax','nom_agentecapta','direccion','fee_acuerdo');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'propiedades',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('dsc_ciudad','dsc_inmueble','cate_propiedad','Finca_ccctral','propietario','totalm2','estado','fecha_alta','fecha_vto','mail_propietario','operacion','precio','precio_mon','captacion_com','id_remax','nom_agentecapta','direccion','fee_acuerdo' );
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
  <h2>PROPIEDADES</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Cuidad</label></td>
        <td> <input type="text" name="dsc_ciudad" id="dsc_ciudad" value="" readonly class="campos-ingreso"></td>

        <td><label for="">Inmueble</label></td>
        <td> <input type="text" name="dsc_inmueble" id="dsc_inmueble" value="" readonly class="campos-ingreso"></td>
      </tr>
        <td><label for="">Categoría propiedad</label></td>
        <td> <input type="text" name="cate_propiedad" id="cate_propiedad" value="" readonly class="campos-ingreso"></td>

        <td><label for="">Cuenta catrastal de la finca</label></td>
        <td> <input type="text" name="Finca_ccctral" id="Finca_ccctral" value="" readonly class="campos-ingreso"></td>
      <tr>
        <td><label for="">Propietario</label></td>
        <td> <input type="text" name="propietario" id="propietario" value=""  readonly class="campos-ingreso"></td>

        <td><label for="">Total</label></td>
        <td> <input type="number" name="totalm2" id="totalm2" value="" readonly class="campos-ingreso"></td>
      </tr>
        <td><label for="">Estado</label></td>
        <td> <input type="text" name="estado" id="estado" readonly value="" class="campos-ingreso"> </td>

        <td><label for="">Fecha alta</label></td>
        <td> <input type="date" name="fecha_alta" id="fecha_alta" readonly value="" class="campos-ingreso"> </td>
      <tr>
        <td><label for="">Fecha vto</label></td>
        <td> <input type="date" name="fecha_vto" id="fecha_vto" readonly value="" class="campos-ingreso"> </td>

        <td><label for="">Email propietario</label></td>
        <td> <input type="email" name="mail_propietario" id="mail_propietario" readonly value="" class="campos-ingreso"> </td>
      </tr>
        <td><label for="">Operación</label></td>
        <td> <input type="text" name="operacion" id="operacion" readonly value="" class="campos-ingreso"> </td>

        <td><label for="">Precio</label></td>
        <td> <input type="text" name="precio" id="precio" readonly value="" class="campos-ingreso"> </td>
      <tr>
        <td><label for="">Moneda</label></td>
        <td> <input type="text" name="precio_mon" id="precio_mon" readonly value="" class="campos-ingreso"> </td>

        <td><label for="">Captación</label></td>
        <td> <input type="text" name="captacion_com" id="captacion_com" readonly value="" class="campos-ingreso"> </td>
      </tr>
        <td><label for="">RE/MAX</label></td>
        <td> <input type="text" name="id_remax" id="id_remax" readonly value="" class="campos-ingreso"> </td>


        <td><label for="">Nombre Agente</label></td>
        <td> <input type="text" name="nom_agentecapta" id="nom_agentecapta" readonly value="" class="campos-ingreso"> </td>
      <tr>
      </tr>
        <td><label for="">Dirección</label></td>
        <td> <input type="text" name="direccion" id="direccion" readonly value="" class="campos-ingreso"> </td>

        <td><label for="">Fee acuerdo</label></td>
        <td> <input type="text" name="fee_acuerdo" id="fee_acuerdo" readonly value="" class="campos-ingreso"> </td>
      <tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="volver" type="button" value="Volver" onclick = "location='propiedades_panel.php';"  class="boton-formulario">
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
