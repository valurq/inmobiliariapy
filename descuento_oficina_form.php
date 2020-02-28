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
            $campos=array( 'conceptos_id','moneda_id', '(SELECT dsc_oficina FROM oficina WHERE id = oficina_id)' , 'oficina_id', 'importe', 'fecha', 'estado', 'obs');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'descuentos_oficinas',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('concepto','moneda', 'refBuscador', 'oficina_id','importe', 'fecha', 'estado', 'obs');
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
  <h2>DESCUENTOS A OFICINAS</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form id="form" name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
        <tr>
          <td><label for="">Concepto</label></td>
          <td>
            <?php
            //name, campoId, campoDescripcion, tabla
              if(!(count($resultado)>0)){
               $inserta_Datos->crearMenuDesplegable('concepto', 'id', 'dsc_concepto', 'conceptos');
              }else{
                  $inserta_Datos->DesplegableElegido(@$resultado[0],'concepto','id','dsc_concepto','conceptos');
              }
            ?>
          </td>
        </tr>
        <tr>
          <td><label for="">Moneda</label></td>
          <td>
            <?php
            //name, campoId, campoDescripcion, tabla
              if(!(count($resultado)>0)){
               $inserta_Datos->crearMenuDesplegable('moneda','id','dsc_moneda','moneda');
              }else{
                  $inserta_Datos->DesplegableElegido(@$resultado[1],'moneda','id','dsc_moneda','moneda');
              }
            ?>
          </td>
        </tr>
        <tr>
          <td width="20%">Oficina</td>
          <td>
            <input list="nombreOfi" id="refBuscador" name="refBuscador" class="campos-ingreso" autocomplete="off" placeholder="Ingrese el nombre de la oficina" onkeyup="buscarListaQ(['dsc_oficina'], this.value, 'oficina', 'dsc_oficina', 'nombreOfi', 'oficina_id', 'estado', 'ACTIVO')">
            <datalist id="nombreOfi">
              <option value=""></option>
            </datalist>

            <input type="hidden" name="oficina_id" id="oficina_id" />
          </td>
        </tr>
        <tr>
            <td><label for="">Importe</label></td>
            <td><input type="text" data-type="currency" name="importe" id="importe" maxlength="12" placeholder="Ingrese un monto" class="campos-ingreso" onkeyup="formatoMoneda($(this))" onblur="formatoMoneda($(this), 'blur')" /></td>
        </tr>
        <tr>
            <td><label for="">Fecha</label></td>
            <td><input id="fecha" name="fecha" type="date" class="campos-ingreso" /></td>
        </tr>
        <tr>
            <td><label for="">Estado</label></td>
            <td>
              <?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[5],'estado',array('PENDIENTE','USADO'))?>
            </td>
        </tr>
        <tr>
          <td><label for="">Observación</label></td>
          <td><textarea name="obs" id="obs" placeholder="Observaciones" class="campos-ingreso"></textarea></td>
        </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='descuento_oficina_panel.php';"  class="boton-formulario">
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


if (isset($_POST['concepto'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['concepto'])){
        $concepto =trim($_POST['concepto']);
        $moneda =trim($_POST['moneda']);
        $oficina = trim($_POST['oficina_id']);
        $importe =$inserta_Datos->transformarMonto(trim($_POST['importe']));
        $fecha = trim($_POST['fecha']);
        $estado = 'PENDIENTE';
        $obs = trim($_POST['obs']);
        $idForm=$_POST['Idformulario'];
        $creador    ="UsuarioLogin";
        $campos = array( 'conceptos_id','moneda_id', 'oficina_id', 'importe', 'fecha', 'estado', 'obs', 'creador');
        $valores= "'".$concepto."', '".$moneda."', '".$oficina."', '".$importe."', '".$fecha."', '".$estado."', '".$obs."', '".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('descuentos_oficinas',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('descuentos_oficinas',$campos,$valores);
        }
    }
}
?>

<script type="text/javascript">

    document.getElementsByTagName('select')[2].setAttribute('disabled', true);

    $( () => {
     let inputs = document.querySelectorAll("input[data-type='currency']");
     for (index of inputs) {
        index.value = new Intl.NumberFormat('es-PY', {style: 'decimal'}).format(index.value);
     }
    });

    
//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
        /*if ($("#importe_desde").val()=="") {
          popup('Advertencia','Es necesario ingresar el Importe Desde!!') ;
          return false ;
        }else if($("#importe_hasta").val()==""){
          popup('Advertencia','Es necesario ingresar el Importe Hasta!!') ;
          return false ;
        }else if(hasta <= desde){
          popup('Advertencia','El Importe Hasta no puede ser menor o igual a Importe Desde!!') ;
          return false ;
        }else if($("#comision").val()==""){
          popup('Advertencia','Es necesario ingresar la Comisión!!') ;
          return false ;
        }*/
        return true;
	}
</script>

</html>
