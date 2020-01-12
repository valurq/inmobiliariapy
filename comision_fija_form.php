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
            $campos=array( 'moneda_id','importe_desde', 'importe_hasta', 'comision');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'comision_fija',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('moneda','importe_desde', 'importe_hasta', 'comision');
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
  <h2>RANGO DE PRECIO PARA COMISION FIJA</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form id="form" name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
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
                  $inserta_Datos->DesplegableElegido(@$resultado[0],'moneda','id','dsc_moneda','moneda');
              }
            ?>
          </td>
        </tr>
        <tr>
        <tr>
            <td><label for="">Importe desde</label></td>
            <td><input type="text" data-type="currency" id="importe_desde" name="importe_desde" maxlength="12" placeholder="Ingrese un monto" class="campos-ingreso" /></td>
        </tr>
        <tr>
            <td><label for="">Importe hasta</label></td>
            <td><input type="text" data-type="currency" id="importe_hasta" name="importe_hasta" maxlength="12" placeholder="Ingrese un monto" class="campos-ingreso" /></td>
        </tr>
        <tr>
            <td><label for="">Comisión</label></td>
            <td><input type="text" data-type="currency" id="comision" name="comision" maxlength="12" placeholder="Ingrese un monto" class="campos-ingreso" /></td>
        </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='comision_fija_panel.php';"  class="boton-formulario">
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
        $importe_desde =implode("",explode(",",trim($_POST['importe_desde'])));
        //echo $importe_desde;
        $importe_hasta =implode("",explode(",",trim($_POST['importe_hasta'])));
        //echo $importe_hasta;
        $comision =implode("",explode(",",trim($_POST['comision'])));
        $idForm=$_POST['Idformulario'];
        $creador    ="UsuarioLogin";
        $campos = array( 'moneda_id','importe_desde', 'importe_hasta', 'comision', 'creador');
        $valores= "'".$moneda."', '".$importe_desde."', '".$importe_hasta."', '".$comision."', '".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('comision_fija',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('comision_fija',$campos,$valores);
        }
    }
}
?>

<script type="text/javascript">

    

    var desde = "<?php echo (empty($resultado)) ? 0 : $resultado[1]  ?>";
    var hasta = "<?php echo (empty($resultado)) ? 0 : $resultado[2]  ?>";
    desde = parseInt(desde, 10);
    hasta = parseInt(hasta, 10);
    
    $(function() 
      {
        formatCurrency($('#importe_desde'));
        formatCurrency($('#importe_hasta'));
        formatCurrency($('#comision'));
      });

    $("input[data-type='currency']").on({
        keyup: function() {
          formatCurrency($(this));
        },
        blur: function() { 
          formatCurrency($(this), "blur");
        }
    });


    function formatNumber(n) {
      // formatear numero a 1000000 to 1,234,567
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
      // añade $ al valor, valida el lado decimal
      // y pone el cursor de nuevo en la posición correcta.
      
      // obtener el valor del input
      var input_val = input.val();
      
      // no validar un input vacio
      if (input_val === "") { return; }
      // tamaño original
      var original_len = input_val.length;

      // posicion original del cursor 
      var caret_pos = input.prop("selectionStart");
        
      // comprobar si hay decimales
      if (input_val.indexOf(".") >= 0) {

        // obtener la posición del primer decimal
        // esto evita que los múltiples decimales de
        // siendo introducido
        var decimal_pos = input_val.indexOf(".");

        // dividir el número por el punto decimal
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // añadir comas a la izquierda del número
        left_side = formatNumber(left_side);

        // validar el lado derecho
        right_side = formatNumber(right_side);
        
        // En el blur se asegura de que hay 2 números después del decimal
        if (blur === "blur") {
          right_side += "00";
        }
        
        // Limitar a solo 2 decimales
        right_side = right_side.substring(0, 2);

        // unir el número por .
        input_val = left_side + "." + right_side;

      } else {
        // no se ha introducido ningún decimal
        // añadir comas al número
        // eliminar todos los no dígitos
        input_val = formatNumber(input_val);
        input_val = input_val;
        
        // formato final
        if (blur === "blur") {
          input_val += ".00";
        }
      }
      
      // enviar el string actualizado al input
      input.val(input_val);

      // poner el cursor de nuevo en la posición correcta
      var updated_len = input_val.length;
      caret_pos = updated_len - original_len + caret_pos;
      input[0].setSelectionRange(caret_pos, caret_pos);
    }

//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
        desde = document.getElementById('importe_desde').value;
        desde = desde.split(',').join('');
        hasta = document.getElementById('importe_hasta').value;
        hasta = hasta.split(',').join('');
        desde = parseFloat(desde);
        hasta = parseFloat(hasta);

        if ($("#importe_desde").val()=="") {
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
        }
        return true;
	}
</script>

</html>
