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
        @$oficina=$_POST['idOfi'];
        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos=array('vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes', 'duracion', 'oficina_id', 'moneda_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */

            $resultado=$inserta_Datos->consultarDatos($campos,'contratos',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            $oficina=$resultado[7];

            $test=$inserta_Datos->consultarDatos(array('dsc_oficina'),'oficina',"","id",$oficina );
            $test=$test->fetch_array(MYSQLI_NUM);

            $campos2 = array('anho','fee_administrativo', 'fondo_marketing');
            $test2=$inserta_Datos->consultarDatos($campos2,'variacion_anual',"","contratos_id", $id);
            $cobros=[];
            while($aux=$test2->fetch_row()){
              array_push($cobros, $aux);
            }
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes', 'duracion');
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

        <style>
          div{
            float: left;
          }

          #section2{
            margin-left: 3%;
          }

          #section2:after{
            clear: left;
            content: "";
          }

          #tableAux{
            border-collapse: collapse;
          }
          
          #tableAux td{
            border: 1px solid black;          
          }

          #tableInput{
            width: 100%;
            background-color: white;
            border-radius: 10px;
            border: 1px solid lightgrey;
            margin-top: 10px;
            margin-left: auto;
            font-weight: normal;
            font-family: arial;
            padding: 5px 15px;
          }

          #tableInput tr:nth-child(odd) {
            background-color:#d3d6da;
          }
          #tableInput tr:nth-child(even) {
            background-color:#ffffff;
          }
          #tableInput tr:hover {
            /*Color de fondo al pasar el mouse sobre cada linea
            de la tabla en panels*/
            background-color: #4b85ba;
          }

          fieldset{
            border-radius: 10px;
            border: 1px solid black;
            box-shadow: 2px 2px 2px black;
          }

        </style>

        
</head>
<body style="background-color:white">
  <h2 id="titulo">CONTRATO</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->

<form action="contrato_panel.php" method="POST" id='form_contrato'>
  <input type="hidden" name='idOfi' >
</form>

<div>
  <form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
    <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
    <input type="hidden" name="idOfi" id='idOfi' value=<?php echo $oficina;?>>
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
                  $inserta_Datos->DesplegableElegido(@$resultado[8],'moneda','id','dsc_moneda','moneda');
              }
            ?>
          </td>
        </tr>
        <tr>
            <td><label for="">Vigencia hasta</label></td>
            <td><input type="date" name="vigencia_hasta" id="vigencia_hasta" readonly placeholder="Ingrese la fecha de vigencia" class="campos-ingreso"></td>
        </tr>
        <tr>
              <td><label for="">Duración</label></td>
              <td><input type="number" name="duracion" id="duracion" step="any" readonly placeholder="Ingrese la duración del contrato" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Porcentaje a pagar sobre operaciones</label></td>
            <td><input type="number" name="fee_operaciones" id="fee_operaciones" readonly step="any" placeholder="Ingrese el porcentaje" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Mora por día</label></td>
            <td><input type="number" name="mora_dia" id="mora_dia" step="any" readonly placeholder="Ingrese el monto de la mora" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Interés</label></td>
            <td><input type="number" name="interes" id="interes" step="any" readonly placeholder="Ingrese el porcentaje de interés" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Estado</label></td>
            <td>
              <?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[3],'estado',array('inactivo','vigente'))?>
            </td>
        </tr>
        <tr>
          <td><label for="">Observación</label></td>
          <td><textarea name="obs" id="obs" placeholder="Observaciones" readonly class="campos-ingreso"></textarea></td>
        </tr>
      </tbody>
    </table>
  <!-- moneda,tipo,simbolo -->
    <!-- BOTONES -->
    <!-- <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar"> -->
    <input name="volver" type="button" value="Volver" onclick="document.getElementById('form_contrato').submit();"  class="boton-formulario">
  </form>
</div>

<div id="section2">
  <form action="" id="form2">
    <fieldset>
      <legend>COBROS POR CONTRATO</legend>
      <table id="tableAux">
        <tbody id="tableInput">
          <tr>
            <td><span><b>AÑO</b></span></td>
            <td><span><b>FEE ADM.</b></span></td>
            <td><span><b>FEE MK.</b></span></td>
          </tr>
        </tbody>
      </table>
    </fieldset>
  </form>
</div>


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
        echo '<script>cargarCampos("'.$camposIdForm.'","'.$valores.'");</script>';
    }

?>
<script type="text/javascript">

  $nombreOfi = "<?php echo $test[0] ?>";
  document.getElementById('titulo').innerHTML += '<br />Oficina: ' + $nombreOfi;

  var cobros = JSON.parse('<?php  echo json_encode($cobros) ?>');
  let tabla = document.getElementById('tableInput');
  
  for (var i = 0; i < cobros.length; i++) {
    let row = document.createElement('tr');
    for (var j = 0; j < cobros[i].length; j++) {
      let data = document.createElement('td');
      let text = document.createTextNode(cobros[i][j]);
      data.appendChild(text);
      row.appendChild(data);
      tabla.appendChild(row);
    }
  }

  </script>

</html>