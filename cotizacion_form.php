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
            $campos=array( 'moneda_id','fecha','cotiz_compra','cotiz_venta');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'cotizacion',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('moneda','fecha','compra','venta');
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
  <h2>COTIZACION</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Moneda</label></td>
        <td><?php $inserta_Datos->crearMenuDesplegable('moneda','id','dsc_moneda','moneda') ?></td>
      </tr>
      <tr>
        <td><label for="">Fecha</label></td>
        <td><input type="date" name="fecha" id="fecha" value="" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Compra</label></td>
        <td><input type="text" name="compra" id="compra" value="" placeholder="Ingrese la cotizacion compra" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Venta</label></td>
        <td><input type="text" name="venta" id="venta" value="" placeholder="Ingrese la cotizacion venta" class="campos-ingreso"><br></td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='cotizacion_panel.php';"  class="boton-formulario">
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


if (isset($_POST['moneda'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['moneda'])){
        $moneda =trim($_POST['moneda']);
        $fecha   =trim($_POST['fecha']);
        $compra =trim($_POST['compra']);
        $venta =trim($_POST['venta']);
        $idForm=$_POST['Idformulario'];
        $creador    ="UsuarioLogin";
        $campos = array( 'moneda_id','fecha','cotiz_compra','cotiz_venta','creador' );
        $valores="'".$moneda."','".$fecha."','".$compra."','".$venta."','".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('cotizacion',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('cotizacion',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if( (document.getElementById('moneda').value !='') && (document.getElementById('fecha').value !='')&&(document.getElementById('compra').value !='')&&(document.getElementById('venta').value !='')  ){
		    return true ;

		}else{
        // Error - Advertencia - Informacion
            popup('Advertencia','Es necesario ingresar la descripcion de la categoria') ;
            return false ;
		}
	}
    document.getElementById('fecha').valueAsDate=new Date();
  </script>

</html>
