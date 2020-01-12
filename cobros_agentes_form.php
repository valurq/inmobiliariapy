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
            $campos=array('(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id)','(SELECT dsc_moneda FROM moneda WHERE id=moneda_id)','fe_vto','importe','saldo','estado','fe_pago','nro_comprob','concepto','moneda_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'afiliacion_agente',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('vendedor_id','moneda_id','fe_vto','importe2','saldoO','estado','fe_pago','nro_comprob','concepto');
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
        <input type="hidden" name="cotizMoneda" id='cotizMoneda' >

      </tr>
      <tr>
        <td><label for="">Fecha vto</label></td>
        <td> <input type="date" name="fe_vto" id="fe_vto" value="" readonly class="campos-ingreso"></td>

        <td><label for="">Importe</label></td>
        <td> <input type="number" name="importe2" id="importe2" value="" step="any" readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Saldo</label></td>
        <td> <input type="number" name="saldo" id="saldo" value="" readonly class="campos-ingreso">
          <input type="hidden" name="saldoO" id="saldoO" value="" readonly class="campos-ingreso"></td>

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
          echo '<script>cargarCampos("'.$camposIdForm.'","'.$valores.'")</script>';
      }


  if (isset($_POST['moneda_p'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['moneda_p'])){
        $id=$_POST['Idformulario'];
        $moneda_id =trim($_POST['moneda_p']);
        $importe =trim($_POST['importe']);
        $forma_pago=trim($_POST['forma_pago']);
        $nro_comprob =trim($_POST['nro_comprob']);
        $ch_nro =trim($_POST['ch_nro']);
        $ch_banco =trim($_POST['ch_banco']);
        $nro_recibo =trim($_POST['nro_recibo']);
        $cotizacion =trim($_POST['cotizacion']);
        $saldo=trim($_POST['saldo']);
        $obs =trim($_POST['obs']);

        //$idForm=$_POST['Idformulario'];
        //$creador    ="UsuarioLogin";
        $campos=array('moneda_id','importe','forma_pago','nro_comprob','ch_nro','ch_banco','nro_recibo','cotizacion','obs');//,'creador' );
        $valores="'".$moneda_id."','".$importe."','".$forma_pago."','".$nro_comprob."','".$ch_nro."','".$ch_banco."','".$cotizacion."','".$obs."'";
        $camposSal=array('saldo');
        $valoresSal="'".$saldo."'";
        $camposEst=array('estado');
        $valoresEst="'pagado'";
        //,'".$creador."'";
        //echo "$valores";
        //print_r($campos);

        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if ($saldo == 0) {
          $inserta_Datos->modificarDato('afiliacion_agente',$camposEst,$valoresEst,'id',$id);
        }
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('cobros_agentes',$campos,$valores,'id',$idForm);
            $inserta_Datos->modificarDato('afiliacion_agente',$camposSal,$valoresSal,'id',$id);
        }else{
            $inserta_Datos->insertarDato('cobros_agentes',$campos,$valores);
            $inserta_Datos->modificarDato('afiliacion_agente',$camposSal,$valoresSal,'id',$id);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if( (document.getElementById('cotizacion').value =='')&&(document.getElementById('importe').value =='')  ){
        popup('Advertencia','Es necesario ingresar el importe y la cotizacion') ;
        return false ;

		}else if(parseInt($("#saldo").val(),10)<0){
      popup('Error','No puede cargar un importe mayor al Saldo') ;
      return false ;

    }else{
            return true ;
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
    $("#moneda_p").val($("#moneda_id").val());
    document.getElementById('forma_pago').addEventListener("change",function (){cambiarEstado(this.value)});
    document.getElementsByClassName('cheque')[0].style.display='none';
    document.getElementsByClassName('cheque')[1].style.display='none';
    $("#importe").on("keyup",function(){actualizarSaldo()});
    $("#saldo").val($("#saldoO").val());
  }

  function verificarCotizacion(valor){
    //console.log(valor);
    var cotizacion=obtenerDatos(['cotiz_compra'],'cotizacion','moneda_id',valor,'ORDER BY fecha DESC LIMIT 1');//Detalle
    var cotizacionO=obtenerDatos(['cotiz_venta'],'cotizacion','(SELECT dsc_moneda FROM moneda WHERE id=moneda_id)',$("#moneda_id").val(),'ORDER BY fecha DESC LIMIT 1');//cabecera
    //Cotizacion=1;
    var cotizacionD=obtenerDatos(['dsc_moneda'],'moneda','id',valor,'');//cabecera
    console.log(cotizacion+"compra");
    console.log(cotizacionO+"venta");
    //console.log('test'+cotizacionD+'ttest'+$("#moneda_id").val());
    if($("#moneda_id").val() == cotizacionD) {
      document.getElementById("cotizacion").value=1;//det
      document.getElementById("cotizMoneda").value=1;//cab

      //document.getElementById("cotizMoneda").value=1;//cab
    }else {
      document.getElementById("cotizacion").value=cotizacion;//det
      document.getElementById("cotizMoneda").value=cotizacionO;//cab

    }$("#importe").val(0);
    actualizarSaldo();
  }

  function actualizarSaldo(){
    var importe= parseFloat($("#importe").val());//DETALLE
    var importeT=$("#saldoO").val();//cabecera
    var cotiz=$("#cotizacion").val();//DET
    var cotizC=$("#cotizMoneda").val();//cab
    console.log(cotiz+"Cotiz");
    console.log(cotizC+"cotizC");
    console.log(importeT+'- '+(importe)+"*"+cotiz+"/"+cotizC );
    var resultado = importeT-(((importe*cotiz)/cotizC));
    if (resultado < 0.05 && resultado>0) {
      $("#saldo").val(0);//calculo
    }else if(resultado<0){
      popup("Error","El valor ingresado supera a la deuda");
      $("#importe").val(0)
    }else{
      $("#saldo").val(resultado);//calculo
    }

  }
  </script>

</html>
