<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <?php
        /*
        SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
        ========================================================================
        */
        session_start();
        include("Parametros/conexion.php");
        $consulta=new Consultas();
        include("Parametros/verificarConexion.php");
        $id=0;
        $resultado="" ;
        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos=array('perfil','obs','tipo');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */

            $resultado=$consulta->consultarDatos($campos,'perfil',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('perfil','observacion');
        }
    ?>
    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">

      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>

</head>
<body style="background-color:white" >
<h2 class="titulo-formulario">PERFIL</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="perfilForm" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="idformulario" id="idformulario" value=<?php echo $id;?> >
    <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
    <table class="tabla-fomulario">
      <tbody>
        <tr>
          <td><label for="">Perfil</label></td>
          <td><input type="text" name="perfil" id="perfil" value="" placeholder="Ingrese nombre de perfil" class="campos-ingreso"></td>
        </tr>
        <tr>
          <td><label for="">Tipo</label></td>
          <!-- <td><select name="tipo" id='tipo' class="campos-ingreso" >
            <option value="Regional">Regional</option>
            <option value="Broker">Broker</option>
            <option value="Agente">Agente</option>
          </select></td> -->
          <td><?php $consulta->DesplegableElegidoFijo(@$resultado[2],'tipo',array('Regional','Broker','Agente','TI'))?></td>
        </tr>
        <tr>
          <td><label for="">Observación</label></td>
          <td><textarea name="observacion" id="observacion" value=""  class="campos-ingreso"></textarea><br></td>
        </tr>
      </tbody>
    </table>


  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar" >
  <input name="volver" type="button" value="Volver" class="boton-formulario" onclick = "location='perfil_panel.php';" >
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

if(isset( $_POST['perfil'] )) {

    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    $perfil =trim($_POST['perfil']);
    $tipo=$_POST['tipo'];
    $obs=trim($_POST['observacion']);
    $creador=$_SESSION['usuario'];
    $idForm= $_POST['Idformulario'];

    $campos = array( 'perfil','tipo','obs','creador' );
    $valores="'".$perfil."','".$tipo."','".$obs."','".$creador."'";
  /*
    VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
  */
  if(isset($idForm)&&($idForm!=0)){
      $consulta->modificarDato('perfil',$campos,$valores,'id',$idForm);
  }else{
      $consulta->insertarDato('perfil',$campos,$valores);
  }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar()
	{

		if((document.getElementById('perfil').value !='')){
		      return true ;

		}	else{
       popup('Advertencia','Es necesario ingresar el datos requeridos..!') ;
       return false ;

		}

	}
  </script>

</html>
