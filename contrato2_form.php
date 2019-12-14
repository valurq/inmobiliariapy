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

          #table{
            width: 100%;
            border-collapse: collapse;
          }

          #tableAux{
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

          #tableAux tr:nth-child(odd) {
            background-color:#d3d6da;
          }
          #tableAux tr:nth-child(even) {
            background-color:#ffffff;
          }
          #tableAux tr:hover {
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
  <h2>CONTRATO</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->

<div>
  <form action="contrato_panel.php" method="POST" id='form_contrato'>
    <input type="hidden" name='idOfi'  value=<?php echo $oficina;?>>
  </form>

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
            <td><input type="date" name="vigencia_hasta" id="vigencia_hasta" onchange ="agregarAnho(this.value);" placeholder="Ingrese la fecha de vigencia" class="campos-ingreso"></td>
        </tr>
        <tr>
              <td><label for="">Duración</label></td>
              <td><input type="number" name="duracion" id="duracion" step="any" readonly placeholder="Ingrese la duración del contrato" class="campos-ingreso"></td>
          </tr>

        <tr>
            <td><label for="">Porcentaje a pagar sobre operaciones</label></td>
            <td><input type="number" name="fee_operaciones" id="fee_operaciones" step="any" placeholder="Ingrese el porcentaje" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Mora por día</label></td>
            <td><input type="number" name="mora_dia" id="mora_dia" step="any" placeholder="Ingrese el monto de la mora" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Interés</label></td>
            <td><input type="number" name="interes" id="interes" step="any" placeholder="Ingrese el porcentaje de interés" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Estado</label></td>
            <td>
              <?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[3],'estado',array('inactivo','vigente'))?>
            </td>
        </tr>
        <tr>
          <td><label for="">Observación</label></td>
          <td><textarea name="obs" id="obs" placeholder="Observaciones" class="campos-ingreso"></textarea></td>
        </tr>
      </tbody>
    </table>
  <!-- moneda,tipo,simbolo -->
    <!-- BOTONES -->
    <input name="guardar" type="button" value="Guardar" class="boton-formulario guardar" onclick="verificar();">
    <input name="volver" type="button" value="Volver" onclick="document.getElementById('form_contrato').submit();"  class="boton-formulario">
  </form>
</div>

<div id="section2">
  <form action="" id="form2">
    <fieldset>
      <legend>COBROS POR CONTRATO</legend>
      <table>
        <tbody id="tableInput">
          <tr>
            <td><span><b>AÑO</b></span></td>
            <td><span><b>FEE ADM.</b></span></td>
            <td><span><b>FEE MK.</b></span></td>
            <td><span><b></b></span></td>
          </tr>
          <tr>
            <td><input type="number" name="ano" id="ano" readonly style="width: 80px;" /></td>
            <td><input type="number" name="fee_adm" id="fee_adm" placeholder="Ingrese el fee de administracioón" /></td>
            <td><input type="number" name="fee_mk" id="fee_mk" placeholder="Ingrese el fee de marketing" /></td>
            <td><img src="Imagenes/addIcon.jpg" width='25px' height='25px' alt="Añadir" title="Añadir" onclick="contarVeces();"/></td>
          </tr>
        </tbody>
      </table>

      <table id="table">
        <tbody id="tableAux"></tbody>
      </table>
    </fieldset>
  </form>
</div>

<script>
    let date = new Date();
    let anho = date.getFullYear();
    let anhoAux = 0;
    let vigencia = 0;
    let table = document.getElementById('tableAux');
    $tableAux = $('#tableAux');
    let tabla = [];

    function agregarAnho(fecha) {
      document.getElementById('ano').value = anho;
      let ano = [];
      for (let i = 0; i < 4; i++) {
        ano += fecha[i];
      }
      anhoAux = ano;
      vigencia = document.getElementById('duracion').value = ((anhoAux - anho) < 0) ? 0 : (anhoAux - anho);
      contarVeces.numero = 0;

      $('#tableAux tr').remove();
      tabla = [];
    }

    function contarVeces(){
      if(contarVeces.numero <= vigencia){
        ++contarVeces.numero;
        addRow();
      }
    }

    function addRow(){
      let row = document.createElement('tr');
      let data = document.createElement('td');
      let ano = document.getElementById('ano').value;
      let text = document.createTextNode(ano);
      data.appendChild(text);
      row.appendChild(data);
      table.appendChild(row);

      data = document.createElement('td');
      let fee_adm = document.getElementById('fee_adm').value;
      text = document.createTextNode(fee_adm);
      data.appendChild(text);
      row.appendChild(data);
      table.appendChild(row);

      data = document.createElement('td');
      let fee_mk = document.getElementById('fee_mk').value;
      text = document.createTextNode(fee_mk);
      data.appendChild(text);
      row.appendChild(data);
      table.appendChild(row);

      tabla.push(new Array(document.getElementById('ano').value, document.getElementById('fee_adm').value, document.getElementById('fee_mk').value));

      document.getElementById('fee_adm').value = "";
      document.getElementById('fee_mk').value = "";
      document.getElementById('ano').value = anho + contarVeces.numero;
    }
</script>

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
        echo 
        '<script>
          cargarCampos("'.$camposIdForm.'","'.$valores.'");
        </script>';
    }

?>
<script type="text/javascript">

//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
    if(document.getElementById('vigencia_hasta').value ==""){
         popup('Advertencia','Es necesario ingresar una fecha de vigencia!!') ;
         return false ;
     }else if($("#fee_operaciones").value ==""){
         popup('Advertencia','Es necesario ingresar un porcentaje sobre operaciones!!') ;
         return false ;
     }else{
         insertar();
     }
  }

  function insertar(){
    var ofi = "<?php echo $oficina ?>";
    console.log(ofi);

    $.post("Parametros/modificarDatosQ.php",{campos: new Array('estado'),tabla:'contratos',valores: new Array('inactivo'),campoCondicion: 'oficina_id', valorCondicion: ofi}, function(res) {
      console.log(res);
    });

    var campos = ['moneda_id','oficina_id', 'vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes','duracion', 'creador'];
    var valores = [$('#moneda').val(), $('#idOfi').val(), $('#vigencia_hasta').val(), $('#fee_operaciones').val(), $('#obs').val(), $('#estado').val(), $('#mora_dia').val(), $('#interes').val(), $('#duracion').val(), "creador"];

    //console.log(valores);
    insertarDatos(campos, 'contratos', valores);

    $.post("Parametros/obtenerDatosQ.php",{campos:['id'],tabla:'contratos',campoCondicion:campos,valores:valores}, function(resultado) {
                console.log(resultado+" prueba");
                var res=JSON.parse(resultado);
                $('#Idformulario').val(res[0]);
                pausa(1000);
                detalleCarga();
             });
    //console.log("testing");

  }

   function detalleCarga(){
        var camposDetalle=['anho','fee_administrativo', 'fondo_marketing','contratos_id'];
        var id=$('#Idformulario').val();
        //alert(id);

        for (var filaReal of tabla) {
            var filas=filaReal.slice();
            filas.push(id);
            console.log(filas);
            insertarDatos(camposDetalle, 'variacion_anual', filas);
        }
    }

  </script>

</html>