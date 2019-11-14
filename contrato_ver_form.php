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
        @$oficina=$_POST['idOfi'];
        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos=array('vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes', 'duracion', 'oficina_id', 'moneda_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */

            $resultado=$inserta_Datos->consultarDatos($campos,'contratos',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            $oficina=$resultado[7];
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes', 'duracion');
        }
    ?>


    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script>
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>
</head>
<body style="background-color:white">
  <h2>CONTRATO</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->

<form action="contrato_panel.php" method="POST" id='form_contrato'>
  <input type="hidden" name='idOfi' >
</form>

<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <input type="hidden" name="idOfi" id='idOfi' value=<?php echo $oficina;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Moneda</label></td>
        <td>
            <?php
          //name, campoId, campoDescripcion, tabla
            if(!(count($resultado)>0)){
             $inserta_Datos->crearMenuDesplegable('moneda','id','dsc_moneda','moneda');
            }else{
                $inserta_Datos->DesplegableElegido(@$resultado[8],'moneda','id','dsc_moneda','moneda');
            }
          ?>
        </td>
      </tr>
      <tr>
          <td><label for="">Vigencia hasta</label></td>
          <td><input type="date" name="vigencia_hasta" id="vigencia_hasta" readonly placeholder="Ingrese la fecha de vigencia" class="campos-ingreso"></td>
      </tr>
      <tr>
            <td><label for="">Duración</label></td>
            <td><input type="number" name="duracion" id="duracion" step="any" placeholder="Ingrese la duración del contrato" class="campos-ingreso"></td>
      </tr>
      <tr>
          <td><label for="">Porcentaje a pagar sobre operaciones</label></td>
          <td><input type="number" name="fee_operaciones" id="fee_operaciones" readonly step="any" placeholder="Ingrese el porcentaje" class="campos-ingreso"></td>
      </tr>
      <tr>
          <td><label for="">Mora por día</label></td>
          <td><input type="number" name="mora_dia" id="mora_dia" step="any" readonly placeholder="Ingrese el monto de la mora" class="campos-ingreso"></td>
      </tr>
      <tr>
          <td><label for="">Interés</label></td>
          <td><input type="number" name="interes" id="interes" step="any" readonly placeholder="Ingrese el porcentaje de interés" class="campos-ingreso"></td>
      </tr>
      <tr>
          <td><label for="">Estado</label></td>
          <td>
            <?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[3],'estado',array('inactivo','vigente'))?>
          </td>
      </tr>
      <tr>
        <td><label for="">Observación</label></td>
        <td><textarea name="obs" id="obs" placeholder="Observaciones" readonly class="campos-ingreso"></textarea></td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <!-- <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar"> -->
  <input name="volver" type="button" value="Volver" onclick="document.getElementById('form_contrato').submit();"  class="boton-formulario">
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
        $vigencia_hasta =trim($_POST['vigencia_hasta']);
        $fee_operaciones =trim($_POST['fee_operaciones']);
        $obs =trim($_POST['obs']);
        $estado =trim($_POST['estado']);
        $mora_dia= trim($_POST['mora_dia']);
        $interes = trim($_POST['interes']);
        $duracion = trim($_POST['duracion']);
        $idForm=$_POST['Idformulario'];
        $idOfi=$_POST['idOfi'];
        $creador    ="UsuarioLogin";
        $campos=array( 'moneda_id','oficina_id', 'vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes', 'duracion', 'creador');
        $valores="'".$moneda."', '".$idOfi."', '".$vigencia_hasta."', '".$fee_operaciones."', '".$obs."', '".$estado."', '".$mora_dia."', '".$interes."', '".$duracion."', '".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('contratos',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->modificarDato('contratos',array('estado'), "'inactivo'", 'oficina_id', $idOfi);
            $inserta_Datos->insertarDato('contratos',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">

//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if($("#vigencia_hasta").val()==""){
      alert('dffds');
      popup('Advertencia','Es necesario ingresar una fecha de vigencia!!') ;
      return false ;
    }else if($("#fee_adm").val()==""){
      popup('Advertencia','Es necesario ingresar un pago mensual!!') ;
      return false ;
    }else if($("#fee_operaciones").val()==""){
      popup('Advertencia','Es necesario ingresar un porcentaje sobre operaciones!!') ;
      return false ;
    }else if($("#fee_marketing").val()==""){
      popup('Advertencia','Es necesario ingresar un pago mensual de marketing!!') ;
      return false ;
    }
	}
  </script>

</html>