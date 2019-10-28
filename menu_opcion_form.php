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
        $consulta= new Consultas();
        include("Parametros/verificarConexion.php");
        $id=0;
        $resultado="";

        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos=array('titulo_menu','link_acceso','icono','posicion','obs' );
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$consulta->consultarDatos($campos,'menu_opcion',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('menu','link','icono','pos','observacion');
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
  <h2>OPCIONES DE MENU</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="menuopcion" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Titulo</label></td>
        <td><input type="text" name="menu" id="menu" value="" placeholder="Ingrese nombre de menu" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Grupo</label></td>
        <td><?php $consulta->crearMenuDesplegable('grupo','id','descripcion','grupo_menu') ?><br></td>
      </tr>
      <tr>
        <td><label for="">Direccion</label></td>
        <td><input type="text" name="link" id="link" value="" placeholder="Ingrese la direccion del archivo a apuntar" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Icono</label></td>
        <td><input type="text" name="icono" id="icono" value="" placeholder="Ingrese la direccion del icono a utilizar" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Posicion</label></td>
        <td><input type="text" name="pos" id="pos" value="" placeholder="Ingrese la posicion de orden" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Observacion</label></td>
        <td><textarea name="observacion" id="observacion" class="campos-ingreso"></textarea></td>
      </tr>
    </tbody>
  </table>
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='menu_opcion_panel.php';"  class="boton-formulario">
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


    if (isset($_POST['menu'])) {
        //======================================================================================
        // NUEVO REGISTRO
        //======================================================================================
        if(isset($_POST['menu'])){
            $menu=trim($_POST['menu']);
            $grupo =trim($_POST['grupo']);
            $link =trim($_POST['link']);
            $icono =trim($_POST['icono']);
            $pos =trim($_POST['pos']);
            $obs = trim($_POST['observacion']);
            $idForm=$_POST['Idformulario'];
            $creador    ="UsuarioLogin";
            $campos = array( 'titulo_menu','grupo_menu_id','link_acceso','icono','posicion','obs' );
            $valores="'".$menu."','".$grupo."','".$link."','".$icono."','".$pos."','".$obs."'";
            /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
            */
            if(isset($idForm)&&($idForm!=0)){
                $consulta->modificarDato('menu_opcion',$campos,$valores,'id',$idForm);
            }else{
                $consulta->insertarDato('menu_opcion',$campos,$valores);
            }
        }
    }
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if( (document.getElementById('grupo').value !='')  ){
		    return true ;

		}else{
        // Error - Advertencia - Informacion
            popup('Advertencia','Es necesario ingresar el nombre del grupo') ;
            return false ;
		}
	}
  </script>

</html>
