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
            $campos= array( 'texto','tipo','estado');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'texto_saludos',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm= array( 'texto','tipo','estado');
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
  <h2>SALUDOS</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Tipo</label></td>
        <td>
            <?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[1],'tipo',array('Cumpleaños','Aniversario'))?>
        </td>
      </tr>
      <tr>
        <td><label for="">Estado</label></td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[2],'estado',array('Activo','Inactivo'))?></td>
      </tr>
      <tr>
        <td><label for="">Texto</label></td>
        <td><textarea name="texto" id= "texto" rows="8" cols="80" class="campos-ingreso"></textarea></td>

      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='saludos_panel.php';"  class="boton-formulario">
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


if (isset($_POST['tipo'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['tipo'])){
        $tipo =trim($_POST['tipo']);
        $estado   =trim($_POST['estado']);
        $texto =trim($_POST['texto']);
        $idForm=$_POST['Idformulario'];
        $creador    ="UsuarioLogin";
        $campos = array( 'texto','tipo','estado','creador');
        $valores="'".$texto."','".$tipo."','".$estado."','".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('texto_saludos',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('texto_saludos',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if( (document.getElementById('tipo').value !='')&&(document.getElementById('estado').value !='')  ){
		    return true ;

		}else{
        // Error - Advertencia - Informacion
            popup('Advertencia','Es necesario el tipo y el estado') ;
            return false ;
		}
	}
  </script>

</html>
