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
            $campos=array('nombrefull','porcentaje_opera','fe_ingreso','obs','oficina_id','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'manager',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('nombrefull','porcentaje_opera','fe_ingreso','obs','oficina','oficinaLista');
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
  <h2>MANAGER</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Nombre full</label></td>
        <td><input type="text" name="nombrefull" id="nombrefull" value="" placeholder="Ingrese su nombre" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Oficina</label></td>
         <td>
        <input list="ofiLista" id="oficinaLista" name="propiedades" autocomplete="off" onkeyup="buscarLista(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'ofiLista', 'oficina') " class="campos-ingreso">
        <datalist id="ofiLista">
          <option value=""></option>
        </datalist>
      <input type="hidden" name="oficina" id="oficina">
    </td>
      </tr>
      <tr>
        <td><label for="">Comision sobre operaciones</label></td>
        <td><input type="number" name="porcentaje_opera" id="porcentaje_opera" step="any" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha Ingreso</label></td>
        <td><input type="date" name="fe_ingreso" id="fe_ingreso" value="" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Observacion</label></td>
        <td><textarea name="obs" id="obs" class="campos-ingreso"></textarea></td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='manager_panel.php';"  class="boton-formulario">
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


  if (isset($_POST['nombrefull'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['nombrefull'])){
        $nombrefull =trim($_POST['nombrefull']);
        $oficina =trim($_POST['oficina']);
        $porcentaje_opera =trim($_POST['porcentaje_opera']);
        $fe_ingreso =trim($_POST['fe_ingreso']);
        $obs =trim($_POST['obs']);
        $idForm=$_POST['Idformulario'];
        //$creador    ="UsuarioLogin";
        $campos = array('nombrefull','oficina_id','porcentaje_opera','fe_ingreso','obs');//,'creador' );
        $camposOfi = array('nombrefull');
        $valores="'".$nombrefull."','".$oficina."','".$porcentaje_opera."','".$fe_ingreso."','".$obs."'";
        $valoresOfi="'".$nombrefull."'";
        //echo "$valores";
        //print_r($campos);

        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('manager',$campos,$valores,'id',$idForm);
            $inserta_Datos->modificarDato('oficina',$camposOfi,$valoresOfi,'id',$oficina);

        }else{
            $inserta_Datos->insertarDato('manager',$campos,$valores);
            $inserta_Datos->modificarDato('oficina',$camposOfi,$valoresOfi,'id',$oficina);
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
