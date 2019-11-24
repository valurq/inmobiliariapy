<?php
?>
<!DOCTYPE html>
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

          $campos= array('referencia', 'fecha_vto', 'categorias', 'estado') ;
          /*
              CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
          */
          $resultado=$inserta_Datos->consultarDatos($campos,'adjuntos',"","id",$id );
          $resultado=$resultado->fetch_array(MYSQLI_NUM);

          /*
              CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
          */
          $camposIdForm= array('titulo','fecha','numero','referencia','vto','idcategoria',
          'etiqueta','obs','dias_antes') ;
      }
  ?>

  <title>VALURQ SRL</title>
  <link rel="stylesheet" type="text/css" href="CSS/estilos.css">
  <link rel="stylesheet" href="CSS/popup.css">
  <script type="text/javascript" src="Js/funciones.js"></script>
  <script
          src="https://code.jquery.com/jquery-3.4.0.js"
          integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
          crossorigin="anonymous">
      </script>

</head>

<body style="background-color:white">
  <h2>ADJUNTOS</h2>

  <form name="CATEGORIA" method="POST" action="adjunta_graba.php" onsubmit="return validacion() " enctype="multipart/form-data">

    <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>

    <div><font color="#808080" class="ws12"><B>INGRESO DE DOCUMENTOS INDIVIDUALES</B></font></div>
    <br>
    <div id="upload" style="visibility:visible">
      <!--EVENTO QUE AYUDA A ADJUNTAR ARCHIVO AL SISTEMA, UNO POR UNO -->
      <input type="file" name="uploadedFile" />
    </div>

    <div id="vinculo" style="visibility:hidden;position: absolute;left:200px;top:40px;font-family:arial">
      <!--LINK DE ACCESO A VISUALIZAR EL ARCHIVO YA ADJUNTO O CARGADO AL SISTEMA. -->
      <a id="vinculo_doc" href="#" target="_blank">Ver adjunto</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      Archivo:<input id="nombredoc" name="nombredoc" readonly type="text" style="font-family:arial;font-size:12px;font-weight:bold;border:none">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID :<?php echo $id;?>
    </div>

<div id="nota" style="visibility:hidden;position: absolute;left:220px;top:75px">
  <font color="red" style="font-family:arial; font-size:11px"><B>Solo datos del documento son editables</B></font>
</div>
<!--
        DATOS BASICOS DEL DOCUMENTO INGRESADO
-->
    <br>
    <font color="#000000" class="ws12"><B>Datos del documento</B></font>
    <table width="70%" border="0" cellpadding="0" cellspacing="0" style="font-family:arial;font-Size=20px">
        <tr>
              <td width="20%"> Referencia *:</td>
              <td><input type="text" id="referencia" name="referencia" size="100%" /></td>
        </tr>
        <tr>
              <td width="20%"> Relaciones *:</td>
              <td width="60%">
                <label for="otros">Otros</label><input type="radio" id="otros" name="refobjeto" value="otros">
                <label for="personal">Personal</label><input type="radio" id="personal" name="refobjeto" value="personal">
                <label for="oficina">Oficina</label><input type="radio" id="oficina" name="refobjeto" value="oficina">
                <label for="vendedor">Vendedor</label><input type="radio" id="vendedor" name="refobjeto" value="vendedor">
                <label for="manager">Manager</label><input type="radio" id="manager" name="refobjeto" value="manager">
              </td>
        </tr>
        <tr id="rowBuscador" style="visibility: hidden;">
          <td width="20%"> Relaciones: </td>
          <td>
            <input list="id_refBuscador" id="refBuscador" name="refBuscador" autocomplete="off"  >
            <datalist id="id_refBuscador">
              <option value=""></option>
            </datalist>

            <input type="hidden" name="idobjeto" id="idobjeto" />
          </td>
        </tr>
        <tr>
              <td width="20%">Categoria : </td>
              <td width="60%"><input type="text" name="categorias" id="categorias" style="width:160px;z-index:2" /></td>
        </tr>
        <tr>
              <td width="20%">Fecha Vencimiento: </td>
              <td><input name="fecha_vto" id="fecha_vto" type="date" style="width:160px;z-index:2"></td>
        </tr>
        <tr>
          <td width="20%">Estado: </td>
          <td>
            <select name="estado" id="estado">
              <option value="vigente">vigente</option>
              <option value="inactivo">inactivo</option>
            </select>
          </td>
        </tr>
        
        <tr>
              <td width="20%" align="right"><input type="submit" name="uploadBtn"  class="botones" value="Confirmar" /> </td>
              <td align="right"><input name="volver" type="button"  class="botones" value="Volver" onclick = "location='doc_panel.php';" ></td>
        </tr>
    </table>

  </form>

</body>


<?php
/*
    LLAMADA A FUNCION JS CORRESPONDIENTE A CARGAR DATOS EN LOS CAMPOS DEL FORMULARIO HTML
*/
    //if(($id!=0 )){
        /*
            CONVERTIR LOS ARRAY A UN STRING PARA PODER ENVIAR POR PARAMETRO A LA FUNCION JS
        */
//         $valores=implode(",",$resultado);
//         $camposIdForm=implode(",",$camposIdForm);

//         //LLAMADA A LA FUNCION JS
//         echo '<script>cargarCampos("'.$camposIdForm.'","'.$valores.'")</script>';

// // carga adicionalmente los demas datos que solo se tiene el ID
//         $resultado_cate=$inserta_Datos->consultarDatos(array('categoria'),'categoria',"","id",$resultado['5'] );
//         $resultado_cate=$resultado_cate->fetch_array(MYSQLI_NUM);
//         echo '<script>cargarCampos("'."categoria".'","'.$resultado_cate[0].'")</script>';

// //      Gaveta descripcion y ID
//         $resultado_gaveta=$inserta_Datos->consultarDatos(array('etiqueta','ubi_mueble_id','id'),'ubi_gabetas',"","id",$resultado['6'] );
//         $resu_gaveta=$resultado_gaveta->fetch_array(MYSQLI_NUM);
//         echo '<script>cargarCampos("'."etiqueta".'","'.$resu_gaveta[0].'")</script>';
//         echo '<script>cargarCampos("'."ubi_gavetas_id".'","'.$resu_gaveta[2].'")</script>';
//         echo '<script>cargarCampos("'."HistoricoGabetaid".'","'.$resu_gaveta[2].'")</script>';

// //      mueble descripcion y ID
//         $resultado_mueble=$inserta_Datos->consultarDatos(array('mueble','id'),'ubi_mueble',"","id",$resu_gaveta['1'] );
//         $resu_mueble=$resultado_mueble->fetch_array(MYSQLI_NUM);
//         echo '<script>cargarCampos("'."ubicacion".'","'.$resu_mueble[0].'")</script>';
//         echo '<script>cargarCampos("'."idubicacion".'","'.$resu_mueble[1].'")</script>';

// // datos de documento para el link de acceso
//         $consultaDocumento=$inserta_Datos->consultarDatos(array('path_server','nombre_final'),'documento',"","id",$id );
//         $datoDocumento=$consultaDocumento->fetch_array(MYSQLI_NUM);
//         $link = ".".$datoDocumento[0]."/".$datoDocumento[1] ;

//         echo '<script>document.getElementById("upload").style.visibility="hidden";
//                        document.getElementById("vinculo").style.visibility="visible";
//                        document.getElementById("nota").style.visibility="visible";
//                        document.getElementById("vinculo_doc").href="'.$link.'" ;
//                        document.getElementById("nombredoc").value="'.$link.'" ;
//             </script>';

//     }
?>

<script>

  $(document).ready(function() {
    $otros = $('#otros');
    $personal = $('#personal');
    $oficina = $('#oficina');
    $vendedor = $('#vendedor');
    $manager = $('#manager');
    $referencia = $('#refBuscador');
    $idObjeto = $('#idobjeto');

    $oficina.click(function(){
      $idObjeto.attr("value","");
      $referencia.val("");
      document.getElementById("rowBuscador").style.visibility = "";
      $referencia.attr("onkeyup", "buscarListaQ(["+'"dsc_oficina"'+"], this.value, "+'"oficina"'+", "+'"dsc_oficina"'+", "+'"id_refBuscador"'+", "+'"idobjeto"'+", "+'"estado"'+", "+'"ACTIVO"'+")");
    });

    $personal.click(function(){
      $idObjeto.attr("value","");
      $referencia.val("");
      document.getElementById("rowBuscador").style.visibility = "";
      $referencia.attr("onkeyup", "buscarLista(["+'"nombrefull"'+"], this.value, "+'"personal"'+", "+'"nombrefull"'+", "+'"id_refBuscador"'+", "+'"idobjeto"'+")");

    });

    $vendedor.click(function(){
      $idObjeto.attr("value","");
      $referencia.val("");
      document.getElementById("rowBuscador").style.visibility = "";
      $referencia.attr("onkeyup", "buscarLista(["+'"dsc_vendedor"'+"], this.value, "+'"vendedor"'+", "+'"dsc_vendedor"'+", "+'"id_refBuscador"'+", "+'"idobjeto"'+")");
    });

    $manager.click(function(){
      $idObjeto.attr("value","");
      $referencia.val("");
      document.getElementById("rowBuscador").style.visibility = "";
      $referencia.attr("onkeyup", "buscarLista(["+'"nombrefull"'+"], this.value, "+'"manager"'+", "+'"nombrefull"'+", "+'"id_refBuscador"'+", "+'"idobjeto"'+")");
    });

    $otros.click(function(){
      $idObjeto.attr("value","");
      $referencia.val("");
      $referencia.attr("onkeyup", "");
      document.getElementById("rowBuscador").style.visibility = "hidden";
    });

  });

function validacion() {
  
  return true;
}

</script>



</html>
