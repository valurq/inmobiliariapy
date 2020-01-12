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
          $campos= array('referencia','idobjeto','categorias','fecha_vto','estado','adjuntos_categoria_id', 'dsc_objeto','refobjeto') ;
          $aux=array(" ");
          /*
              CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
          */
          $resultado=$inserta_Datos->consultarDatos($campos,'adjuntos',"","id",$id );
          $resultado=$resultado->fetch_array(MYSQLI_NUM);

          if ($resultado[7] == "personal") {
               $aux = $inserta_Datos->consultarDatos(array('nombrefull'),'personal',"","id",$resultado[1] );
               $aux=$aux->fetch_array(MYSQLI_NUM);
          }else if($resultado[7] == "vendedor"){
               $aux = $inserta_Datos->consultarDatos(array('dsc_vendedor'),'vendedor',"","id",$resultado[1] );     
               $aux=$aux->fetch_array(MYSQLI_NUM);
          }else if ($resultado[7] == "oficina") {
              $aux = $inserta_Datos->consultarDatos(array('dsc_oficina'),'oficina',"","id",$resultado[1] );     
              $aux=$aux->fetch_array(MYSQLI_NUM);  
          }else if ($resultado[7] == "manager") {
              $aux = $inserta_Datos->consultarDatos(array('nombrefull'),'manager',"","id",$resultado[1] );     
              $aux=$aux->fetch_array(MYSQLI_NUM);
          }
          /*
              CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
          */
          $robj=array_pop($resultado);
          array_push($resultado,$aux[0]);

          $archivo = $inserta_Datos->consultarDatos(array('nombre_archivo'),'adjuntos',"","id",$id );     
          $archivo=$archivo->fetch_array(MYSQLI_NUM);

          $carpeta = $inserta_Datos->consultarDatos(array('carpeta'),'adjuntos',"","id",$id );
          $carpeta=$carpeta->fetch_array(MYSQLI_NUM);

          $nombre_archivo = "." . $carpeta[0] . $archivo[0];


          $camposIdForm= array('referencia','idobjeto','categorias','fecha_vto','estado','idcategoria', 'id_categorias','refBuscador') ;
      }

      $extension = $inserta_Datos->consultarDatos(array('adjunto_ext'),'parametros',"","id", 1);
      $extension=$extension->fetch_array(MYSQLI_NUM);

      $tamanho = $inserta_Datos->consultarDatos(array('adjunto_tam'),'parametros',"","id", 1);
      $tamanho=$tamanho->fetch_array(MYSQLI_NUM);

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
      <?php 
        if(isset($_POST['seleccionado'])){

          echo "<iframe src='".$nombre_archivo."' height='400px' width='80%'>

          </iframe>";
        }else{
          echo "<input type='file' name='uploadedFile' id='uploadedFile' />";
        }
       ?>

    </div>

<!--
        DATOS BASICOS DEL DOCUMENTO INGRESADO
-->
    <br>
    <font color="#000000" class="ws12"><B>Datos del documento</B></font>
    <table width="65%" border="0" cellpadding="0" cellspacing="0" style="font-family:arial;font-Size=20px">
        <tr>
              <td width="20%"> Referencia *:</td>
              <td><input type="text" id="referencia" name="referencia" size="100%" placeholder="Ingrese la referencia" /></td>
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
          <td width="20%"> Relaciones *: </td>
          <td>
            <input list="id_refBuscador" id="refBuscador" name="refBuscador" autocomplete="off" placeholder="Ingrese la relación" >
            <datalist id="id_refBuscador">
              <option value=""></option>
            </datalist>

            <input type="hidden" name="idobjeto" id="idobjeto" />
          </td>
        </tr>
        <tr>
          <td width="20%"> Categoria: </td>
          <td>
            <input list="id_categorias" id="categorias" name="categorias" autocomplete="off" placeholder="Ingrese la relación" 
            onkeyup="buscarLista(['dsc_categoria'], this.value, 'adjuntos_categoria', 'dsc_categoria', 'id_categorias', 'idcategoria')">
            <datalist id="id_categorias">
              <option value=""></option>
            </datalist>

            <input type="hidden" name="idcategoria" id="idcategoria" />
          <!-- </td>
              <td width="20%">Categoria : </td>
              <td width="60%"><input type="text" name="categorias" id="categorias" style="width:160px;z-index:2" placeholder="Introduzca la categoria" /></td> -->
        </tr>
        <tr>
              <td width="20%">Fecha Vencimiento: </td>
              <td><input name="fecha_vto" id="fecha_vto" type="date" style="width:160px;z-index:2"></td>
        </tr>
        <tr>
          <td width="20%">Estado: </td>
          <td>
              <?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[4],'estado',array('inactivo','vigente'))?>
            </td>
        </tr>
        
        <tr>
            <?php
              if(!isset($_POST['seleccionado'])){
                  echo "<td width='20%' align='right'><input type='submit' name='uploadBtn'  class='botones' value='Confirmar' /> </td>";
              }else{
                  echo "<td width='20%' align='right'> </td>";
              }
            ?>
              <td align="right"><input name="volver" type="button"  class="botones" value="Volver" onclick = "location='adjunto_panel.php';" ></td>
        </tr>
    </table>

  </form>

</body>

<script>
  function verificarSelect(valor){
    document.getElementById(valor).checked = true;
    if (valor != "otros") {
      document.getElementById("rowBuscador").style.visibility = "";
    }
  }

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
    if ($("#uploadedFile").val()=="") {
      popup('Advertencia','Es necesario adjuntar un archivo!!') ;
      return false ;
    }else if($("#referencia").val()==""){
      popup('Advertencia','Es necesario ingresar el campo Referencia!!') ;
      return false ;
    }else if( ($('input[name=refobjeto]:checked').val()!="otros") && ($("#refBuscador").val()=="") ){
      popup('Advertencia','Es necesario ingresar una relación!!') ;
      return false ;
    }else if($("#categorias").val()==""){
      popup('Advertencia','Es necesario ingresar una categoria!!') ;
      return false ;
    }
    return true;
  }

  //Validar la extension y peso del archivo
  var auxExtension = <?php  echo"'". $extension[0] . "'" ?>;
  let extension = "";

  for(let caracter of auxExtension){
    if(caracter != " ")
      extension += caracter;
  }

  extension = extension.split('-');
  

  var tamanho = <?php  echo"'". $tamanho[0] . "'" ?>;

  $(document).on('change','input[type="file"]',function(){
    var fileName = this.files[0].name;
    var fileSize = this.files[0].size;

    if(fileSize > parseInt(tamanho, 10)){
      //popup('Advertencia','El archivo no debe superar los 3MB');
      alert(`Error, cargar solo archivos de hasta ${tamanho/1000000}MB`);
      this.value = '';
      //this.files[0].name = '';
    }else{
      var ext = fileName.split('.').pop();
      //console.log(ext);
      
      for(let j = 0; j <= extension.length; j++){
          //console.log(extension[j]);
        if(extension[j] == ext){
          break;
         }
         else if(j == extension.length){
          alert('Error, extension no permitida');
          this.value = ''; // reset del valor
          //this.files[0].name = '';
         }
      }
    }
  });

</script>

<?php
  if(($id!=0 )){
        /*
            CONVERTIR LOS ARRAY A UN STRING PARA PODER ENVIAR POR PARAMETRO A LA FUNCION JS
        */
        $valores=implode(",",$resultado);
        $camposIdForm=implode(",",$camposIdForm);
        //LLAMADA A LA FUNCION JS
        echo '<script>
                cargarCampos("'.$camposIdForm.'","'.$valores.'");
                verificarSelect("'.$robj.'");
              </script>';
    }
?>

</html>
