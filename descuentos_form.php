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
            $campos=  array( 'fecha','importe','estado','fecha_uso','obs','vendedor_id','moneda_id','conceptos_id' );
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'descuentos',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('fecha','importe','estado','fecha_uso','obs','vendedor','moneda','conceptos');
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
  <h2>DESCUENTOS</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Fecha</label></td>
        <td><input type="date" name="fecha" id="fecha" value="" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Vendedor</label></td>
        <td><?php
         if(!(count($resultado)>0)){
             $inserta_Datos->crearMenuDesplegable('vendedor','id','dsc_vendedor','vendedor');
         }else{
             $inserta_Datos->DesplegableElegido(@$resultado[5],'vendedor','id','dsc_vendedor','vendedor');
         }
         ?></td>
      </tr>
      <tr>
        <td><label for="">Moneda</label></td>
        <td><?php
         if(!(count($resultado)>0)){
             $inserta_Datos->crearMenuDesplegable('moneda','id','dsc_moneda','moneda');
         }else{
             $inserta_Datos->DesplegableElegido(@$resultado[6],'moneda','id','dsc_moneda','moneda');
         }

         ?></td>
      </tr>
      <tr>
        <td><label for="">Conceptos</label></td>
        <td><?php
         if(!(count($resultado)>0)){
             $inserta_Datos->crearMenuDesplegable('conceptos','id','dsc_concepto','conceptos');
         }else{
             $inserta_Datos->DesplegableElegido(@$resultado[7],'conceptos','id','dsc_concepto','conceptos');
         }
         ?></td>
      </tr>
      <tr>
        <td><label for="">Importe</label></td>
        <td><input type="text" name="importe" id="importe" value=""  class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Estado</label></td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[2],'estado',array('Pendiente','Usado'))?></td>
      </tr>
      <tr>
        <td><label for="">Fecha de Uso</label></td>
        <td><input type="date" name="fecha_uso" id="fecha_uso" value="" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Observación</label></td>
        <td><textarea name="obs" id="obs" rows="8" cols="80" class="campos-ingreso"></textarea></td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='descuentos_panel.php';"  class="boton-formulario">
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


if (isset($_POST['fecha'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['fecha'])){
        $fecha =trim($_POST['fecha']);
        $vendedor   =$_POST['vendedor'];
        $moneda =$_POST['moneda'];
        $conceptos =$_POST['conceptos'];
        $importe =trim($_POST['importe']);
        $estado =trim($_POST['estado']);
        $fecha_uso =trim($_POST['fecha_uso']);
        $obs =trim($_POST['obs']);
        $idForm=$_POST['Idformulario'];
        $creador    =$_SESSION['usuario'];
        $campos = array( 'fecha','vendedor_id','moneda_id','conceptos_id','importe','estado','fecha_uso','obs','creador' );
        $valores="'".$fecha."','".$vendedor."','".$moneda."','".$conceptos."','".$importe."','".$estado."','".$fecha_uso."','".$obs."','".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('descuentos',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('descuentos',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if( (document.getElementById('moneda').value !='')&&(document.getElementById('simbolo').value !='')  ){
		    return true ;

		}else{
        // Error - Advertencia - Informacion
            popup('Advertencia','Es necesario ingresar el nombre moneda y simbolo') ;
            return false ;
		}
	}
  </script>

</html>
