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
            $campos=array('por_feeregional','candias_vto','fee_adm','fee_marketing','afiliacion','alq_residencial','alq_comercial','alq_temporal','mail_ti','mail_host','mail_puerto','mail_usuario','mail_pass','mail_desde','mail_from','mail_autentica','adjunto_ext','adjunto_tam');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'parametros',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('por_feeregional','candias_vto','fee_adm','fee_marketing','afiliacion','alq_residencial','alq_comercial','alq_temporal','mail_ti','mail_host','mail_puerto','mail_usuario','mail_pass','mail_desde','mail_from','mail_autentica','adjunto_ext','adjunto_tam');
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
  <h2>PARAMETROS</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">% fee regional</label></td>
        <td><input type="number" name="por_feeregional" id="por_feeregional" value="" step="any" placeholder="Ingrese el fee" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Cant. Dias antes del Vencimiento</label></td>
        <td><input type="number" name="candias_vto" id="candias_vto" value="" placeholder="Ingrese la cantidad de dias" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fee Adm</label></td>
        <td><input type="number" name="fee_adm" id="fee_adm" value="" step="any" placeholder="Ingrese el fee" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Fee marketing</label></td>
        <td><input type="number" name="fee_marketing" id="fee_marketing" value="" step="any" placeholder="Ingrese el fee" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Afiliacion</label></td>
        <td><input type="number" name="afiliacion" id="afiliacion" value="" step="any" placeholder="Ingrese el monto a pagar" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Alquiler Residencial</label></td>
        <td><input type="number" name="alq_residencial" id="alq_residencial" value="" step="any"  placeholder="Ingrese el porcentaje" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Alquiler Comercial</label></td>
        <td><input type="number" name="alq_comercial" id="alq_comercial" value="" step="any" placeholder="Ingrese el porcentaje"class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Alquiler Temporal</label></td>
        <td><input type="number" name="alq_temporal" id="alq_temporal" value="" step="any" placeholder="Ingrese el porcentaje" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Email</label></td>
        <td><input type="email" name="mail_ti" id="mail_ti" value="" placeholder="Ingrese el email" placeholder="Ingrese el email de TI" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Email Host</label></td>
        <td><input type="text" name="mail_host" id="mail_host" value="" placeholder="Ingrese el email" placeholder="Ingrese el email de TI" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Email Puerto</label></td>
        <td><input type="text" name="mail_puerto" id="mail_puerto" value="" placeholder="Ingrese el email" placeholder="Ingrese el email de TI" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Email Usuario</label></td>
        <td><input type="text" name="mail_usuario" id="mail_usuario" value="" placeholder="Ingrese el email" placeholder="Ingrese el email de TI" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Email Password</label></td>
        <td><input type="password" name="mail_pass" id="mail_pass" value="" placeholder="Ingrese el email" placeholder="Ingrese el email de TI" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Email Desde </label></td>
        <td><input type="text" name="mail_desde" id="mail_desde" value="" placeholder="Ingrese el email" placeholder="Ingrese el email de TI" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Email From</label></td>
        <td><input type="text" name="mail_from" id="mail_from" value="" placeholder="Ingrese el email" placeholder="Ingrese el email de TI" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td><label for="">Email Autentica</label></td>
        <td><input type="text" name="mail_autentica" id="mail_autentica" value="" placeholder="Ingrese el email" placeholder="Ingrese el email de TI" class="campos-ingreso"><br></td>
      </tr>
      <tr>
        <td> <label>Extensiones permitidas</label> </td>
        <td> <input type="text" name="adjunto_ext" id="adujunto_ext" value="" placeholder="Valores separados por coma"> </td>
      </tr>
      <tr>
        <td> <label>Tamaño permitidas (MB)</label> </td>
        <td> <input type="text" name="adjunto_tam" id="adujunto_tam" value=""> </td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='parametros_panel.php';"  class="boton-formulario">
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


if (isset($_POST['por_feeregional'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['por_feeregional'])){
        $por_feeregional =trim($_POST['por_feeregional']);
        $candias_vto   =trim($_POST['candias_vto']);
        $fee_adm =trim($_POST['fee_adm']);
        $fee_marketing =trim($_POST['fee_marketing']);
        $afiliacion =trim($_POST['afiliacion']);
        $alq_residencial =trim($_POST['alq_residencial']);
        $alq_comercial =trim($_POST['alq_comercial']);
        $alq_temporal =trim($_POST['alq_temporal']);
        $mail_ti =trim($_POST['mail_ti']);
        $mail_host =trim($_POST['mail_host']);
        $mail_puerto =trim($_POST['mail_puerto']);
        $mail_usuario =trim($_POST['mail_usuario']);
        $mail_pass =trim($_POST['mail_pass']);
        $mail_desde =trim($_POST['mail_desde']);
        $mail_from =trim($_POST['mail_from']);
        $mail_autentica =trim($_POST['mail_autentica']);
        $adjunto_ext =trim($_POST['adjunto_ext']);
        $adjunto_tam =trim($_POST['adjunto_tam'])*1000000;
        $idForm=$_POST['Idformulario'];
        $creador    ="UsuarioLogin";
        $campos = array('por_feeregional','candias_vto','fee_adm','fee_marketing','afiliacion','alq_residencial','alq_comercial','alq_temporal','mail_ti','mail_host','mail_puerto','mail_usuario','mail_pass','mail_desde','mail_from','mail_autentica','adjunto_ext','adjunto_tam','creador' );
        $valores="'".$por_feeregional."','".$candias_vto."','".$fee_adm."','".$fee_marketing."','".$afiliacion."','".$alq_residencial."','".$alq_comercial."','".$alq_temporal."','".$mail_ti."','".$mail_host."','".$mail_puerto."','".$mail_usuario."','".$mail_pass."','".$mail_desde."','".$mail_from."','".$mail_autentica."','".$adjunto_ext."','".$adjunto_ext."','".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('parametros',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('parametros',$campos,$valores);
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
