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
            $campos=array('moneda_id','importe','forma_pago','nro_comprob','ch_nro','ch_banco','nro_recibo','cotizacion','obs');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'cobros_agentes',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('moneda_p','importe','forma_pago','nro_comprob','ch_nro','ch_banco','nro_recibo','cotizacion');
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
        <style media="screen">
        </style>
</head>
<body style="background-color:white">
  <h2>CUENTAS AGENTES</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
  <form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Vendedor</label></td>
        <td><input type="text" name="vendedor_id" id="vendedor_id" value="" placeholder="Ingrese su nombre" class="campos-ingreso" readonly></td>

        <td> <label for="">Moneda</label> </td>
        <td> <input type="text" name="moneda_id" id="moneda_id" value="" readonly class="campos-ingreso"> </td>
      </tr>
      <tr>
        <td><label for="">Fecha vto</label></td>
        <td> <input type="date" name="fe_vto" id="fe_vto" value="" readonly class="campos-ingreso"></td>

        <td><label for="">Importe</label></td>
        <td> <input type="number" name="importe" id="importe" value="" step="any" readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Saldo</label></td>
        <td> <input type="number" name="saldo" id="saldo" value="" readonly class="campos-ingreso"></td>

        <td><label for="">Estado</label></td>
        <td> <input type="text" name="estado" id="estado" value="" readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha Pago</label></td>
        <td> <input type="date" name="fe_pago" id="fe_pago" value=""  readonly class="campos-ingreso"></td>

        <td><label for="">Numero comprobante</label></td>
        <td> <input type="text" name="nro_comprob" id="nro_comprob" value="" readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Concepto</label></td>
        <td> <textarea name="concepto" id="concepto" readonly class="campos-ingreso"> </textarea></td>
      </tr>
    <tbody>
  </table>
  <table>
    <tbody class="tabla-fomulario">
      <h2>DETALLE PAGO</h2>
      <tr>
        <td><label for="">Moneda</label></td>
        <td><?php
        if(!(count($resultado)>0)){
          $inserta_Datos->crearMenuDesplegable('moneda_p','id','dsc_moneda','moneda');
        }else{
          $inserta_Datos->DesplegableElegido(@$resultado[20],'moneda_p','id','dsc_moneda','moneda');
        }
        ?></td>

        <td> <label for="">Importe</label> </td>
        <td> <input type="number" name="importe" id="importe" step="any" value=""placeholder="Ingrese el importe" class="campos-ingreso"> </td>
        <tr>
          <td> <label for="">Forma de pago</label> </td>
          <td> <?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[2],'forma_pago',array('Efectivo','Tranferencia','Cheque','Compensacion'))?> </td>

          <td> <label for="">Numero de comprobante</label> </td>
          <td> <input type="text" name="nro_comprob" id="nro_comprob" placeholder="Ingrese el nro de comprobante" value="" class="campos-ingreso"> </td>
        </tr>
      </tr>
      <tr class='cheque'>
        <td> <label for="">Cheque numero</label> </td>
        <td> <input type="text" name="ch_nro" id="ch_nro" placeholder="Ingrese el numero del cheque" value="" class="campos-ingreso"> </td>
      </tr>
      <tr class='cheque'>
        <td> <label for="">Cheque Banco</label> </td>
        <td> <input type="text" name="ch_banco" id="ch_banco" placeholder="Ingrese el nombre del Banco" value="" class="campos-ingreso"> </td>
      </tr>
      <tr>
        <td> <label for="">Numero de recibo</label> </td>
        <td> <input type="text" name="nro_recibo" id="nro_recibo" placeholder="Ingrese el nro de recibo" value="" class="campos-ingreso"> </td>

        <td> <label for="">Cotizacion</label> </td>
        <td> <input type="text" name="cotizacion" id="cotizacion" placeholder="Ingrese la cotizacion" value="" class="campos-ingreso" value=""> </td>
      </tr>
      <tr>
        <td><label for="">Observación</label></td>
        <td><textarea name="obs" id="obs" class="campos-ingreso"></textarea></td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='afiliacion_agente_panel.php';"  class="boton-formulario">
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
          //echo '<script>cargarCampos("'.$camposIdForm.'","'.$valores.'")</script>';
      }


  if (isset($_POST['moneda_p'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['moneda_p'])){
        $moneda_id =trim($_POST['moneda_p']);
        $importe =trim($_POST['importe']);
        $forma_pago=trim($_POST['forma_pago']);
        $nro_comprob =trim($_POST['nro_comprob']);
        $ch_nro =trim($_POST['ch_nro']);
        $ch_banco =trim($_POST['ch_banco']);
        $nro_recibo =trim($_POST['nro_recibo']);
        $cotizacion =trim($_POST['cotizacion']);
        $obs =trim($_POST['obs']);
        //$idForm=$_POST['Idformulario'];
        //$creador    ="UsuarioLogin";
        $campos=array('moneda_id','importe','forma_pago','nro_comprob','ch_nro','ch_banco','nro_recibo','cotizacion','obs');//,'creador' );
        $valores="'".$moneda_id."','".$importe."','".$forma_pago."','".$nro_comprob."','".$ch_nro."','".$ch_banco."','".$cotizacion."','".$obs."'";
        //,'".$creador."'";
        //echo "$valores";
        //print_r($campos);

        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('cobros_agentes',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('cobros_agentes',$campos,$valores);
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
  function cambiarEstado(valor){
    if (valor=="Cheque") {
      document.getElementsByClassName('cheque')[0].style.display='';
      document.getElementsByClassName('cheque')[1].style.display='';
    }else{
      document.getElementsByClassName('cheque')[0].style.display='none';
      document.getElementsByClassName('cheque')[1].style.display='none';
    }
  }
  window.onload=function (){
    document.getElementById('moneda_p').addEventListener("change",function (){verificarCotizacion(this.value)});
    document.getElementById('forma_pago').addEventListener("change",function (){cambiarEstado(this.value)});
    document.getElementsByClassName('cheque')[0].style.display='none';
    document.getElementsByClassName('cheque')[1].style.display='none';
  }
  function verificarCotizacion(valor){
    console.log(valor);
    if(valor==4){
      document.getElementById("cotizacion").value='1';
      console.log("prueba");
    }else{
      console.log("test");
    }
  }
  </script>

</html>
