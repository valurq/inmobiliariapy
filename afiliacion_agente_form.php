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
            $campos=array('(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id)','(SELECT dsc_moneda FROM moneda WHERE id=moneda_id)','fe_vto','importe','saldo','estado','fe_pago','nro_comprob','concepto');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'afiliacion_agente',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('vendedor_id','moneda_id','fe_vto','importe','saldo','estado','fe_pago','nro_comprob','concepto' );
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
      </tr>
      <tr>
        <td> <label for="">Moneda</label> </td>
        <td> <input type="text" name="moneda_id" id="moneda_id" value="" readonly class="campos-ingreso"> </td>
      </tr>
      <tr>
        <td><label for="">Fecha vto</label></td>
        <td> <input type="date" name="fe_vto" id="fe_vto" value="" readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Importe</label></td>
        <td> <input type="number" name="importe" id="importe" value="" step="any" readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Saldo</label></td>
        <td> <input type="number" name="saldo" id="saldo" value="" readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Estado</label></td>
        <td> <input type="text" name="estado" id="estado" value="" readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha Pago</label></td>
        <td> <input type="date" name="fe_pago" id="fe_pago" value=""  readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Numero comprobante</label></td>
        <td> <input type="text" name="nro_comprob" id="nro_comprob" value="" readonly class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Concepto</label></td>
        <td> <textarea name="concepto" id="concepto" readonly class="campos-ingreso"> ></textarea></td>

      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
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


  if (isset($_POST['vendedor_id'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['vendedor_id'])){
        $vendedor_id =trim($_POST['vendedor_id']);
        $moneda_id =trim($_POST['moneda_id']);
        $fe_vto=trim($_POST['fe_vto']);
        $importe =trim($_POST['importe']);
        $saldo =trim($_POST['saldo']);
        $estado =trim($_POST['estado']);
        $fe_pago =trim($_POST['fe_pago']);
        $nro_comprob =trim($_POST['nro_comprob']);
        $concepto =trim($_POST['concepto']);
        $idForm=$_POST['Idformulario'];
      $creador    ="UsuarioLogin";
        $campos=array('vendedor_id','moneda_id','fe_vto','importe','saldo','estado','fe_pago','nro_comprob','concepto','creador' );
        $valores="'".$vendedor_id."','".$moneda_id."','".$fe_vto."','".$importe."','".$saldo."','".$estado."','".$fe_pago."','".$nro_comprob."','".$concepto."','".$creador."'";
        //echo "$valores";
        //print_r($campos);

        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('afiliacion_agente',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('afiliacion_agente',$campos,$valores);
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
