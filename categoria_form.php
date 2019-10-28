<!DOCTYPE HTML>
<html>
<head>
    <?php
        /*
        SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
        ========================================================================
        */
        include("Parametros/conexion.php");
        $inserta_Datos=new Consultas();
        $id=0;
        $resultado="";

        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos=array('categoria','obs');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'categoria',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('categoria,obs');
        }
    ?>


    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker">
<style type="text/css">
      /*----------Text Styles----------*/
      .ws6 {font-size: 8px;}
      .ws7 {font-size: 9.3px;}
      .ws8 {font-size: 11px;}
      .ws9 {font-size: 12px;}
      .ws10 {font-size: 13px;}
      .ws11 {font-size: 15px;}
      .ws12 {font-size: 16px;}
      .ws14 {font-size: 19px;}
      .ws16 {font-size: 21px;}
      .ws18 {font-size: 24px;}
      .ws20 {font-size: 27px;}
      .ws22 {font-size: 29px;}
      .ws24 {font-size: 32px;}
      .ws26 {font-size: 35px;}
      .ws28 {font-size: 37px;}
      .ws36 {font-size: 48px;}
      .ws48 {font-size: 64px;}
      .ws72 {font-size: 96px;}
      .wpmd {font-size: 13px;font-family: Arial,Helvetica,Sans-Serif;font-style: normal;font-weight: normal;}
      /*----------Para Styles----------*/
      DIV,UL,OL /* Left */
      {
       margin-top: 0px;
       margin-bottom: 0px;
      }
</style>
      <link rel="stylesheet" href="CSS/popup.css">
      <script
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>
</head>
<body style="background-color:white">
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <input name="categoria" id ="categoria" type="text"   maxlength=80 style="position:absolute;width:200px;left:133px;top:97px;z-index:2" >
  <textarea name="obs" id="obs" style="position:absolute;left:134px;top:137px;width:379px;height:97px;z-index:3"></textarea>

  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" style="position:absolute;left:439px;top:275px;z-index:6">
  <input name="volver" type="button" value="Volver" onclick = "location='categoria_panel.php';" style="position:absolute;left:131px;top:273px;z-index:7">
</form>

  <!-- Titulos y etiquetas -->
<div id="text1" style="position:absolute; overflow:hidden; left:20px; top:21px; width:224px; height:22px; z-index:1">
<div class="wpmd">
<div><font color="#808080" class="ws12"><B>Categoria de documentos</B></font></div>
</div></div>

<div id="text2" style="position:absolute; overflow:hidden; left:24px; top:97px; width:100px;; height:23px; z-index:4">
<div class="wpmd">
<div><font color="#333333" class="ws11">Descripcion :</font></div>
</div></div>

<div id="text3" style="position:absolute; overflow:hidden; left:23px; top:135px; width:100px;; height:23px; z-index:5">
<div class="wpmd">
<div><font color="#333333" class="ws11">Comentarios:</font></div>
</div></div>

  <!-- Fin titulos y etiquetas -->

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


if (isset($_POST['categoria'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['categoria'])){
        $categoria =trim($_POST['categoria']);
        $obs       =trim($_POST['obs']);
        $idForm=$_POST['Idformulario'];
        $creador    ="UsuarioLogin";
        $campos = array( 'categoria','creador','obs' );
        $valores="'".$categoria."','".$creador."','".$obs."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('categoria',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('categoria',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if( (document.getElementById('categoria').value !='')  ){
		    return true ;

		}else{
        // Error - Advertencia - Informacion
            popup('Advertencia','Es necesario ingresar la descripcion de la categoria') ;
            return false ;
		}
	}
  </script>

</html>
