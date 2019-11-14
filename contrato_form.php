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
            $campos=array( 'moneda_id','oficina_id', 'vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes', 'duracion');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */

            $resultado=$inserta_Datos->consultarDatos($campos,'contratos',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            $oficina=$resultado[1];
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('moneda', 'vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes', 'duracion');
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
        margin-left: 10%;
      }

      #section2:after{
        clear: left;
        content: "";
      }
    </style>
</head>
<body style="background-color:white">
  <h2>CONTRATO</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->

<div id="section1">
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
              $inserta_Datos->crearMenuDesplegable('moneda', 'id', 'dsc_moneda', 'moneda');
            ?>
          </td>
        </tr>
        <tr>
            <td><label for="">Vigencia hasta</label></td>
            <td><input type="date" name="vigencia_hasta" id="vigencia_hasta" onchange="agregarAnho(this.value);" placeholder="Ingrese la fecha de vigencia" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Duración (en años)</label></td>
            <td><input type="number" name="duracion" id="duracion" readonly step="any" placeholder="Ingrese la duración del contrato" class="campos-ingreso"></td>
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
              <select name="estado" id="estado" class="campos-ingreso">
                  <option value="inactivo">inactivo</option>
                  <option value="vigente">vigente</option>
              </select>
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
    <input name="volver" type="button" value="Volver" onclick = "window.close();"  class="boton-formulario">
  </form>
</div>  

<div id="section2">
  <form action="">
    <table>
      <tbody id="tableAux">
        <tr>
          <td><input type="number" name="ano" id="ano" readonly style="width: 80px;" /></td>
          <td><input type="number" name="fee_adm" id="fee_adm" placeholder="Ingrese el fee de administracioón" /></td>
          <td><input type="number" name="fee_mk" id="fee_mk" placeholder="Ingrese el fee de marketing" /></td>
          <td><input type="button" name="add" id="save" value="Añadir" onclick="contarVeces();"></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>

<script>
    let date = new Date();
    let anho = date.getFullYear();
    let anhoAux = 0;
    let vigencia = 0;
    let tabla = [][];
    document.getElementById('ano').value = anho;

    function agregarAnho(fecha) {
      let ano = [];
      for (let i = 0; i < 4; i++) {
        ano += fecha[i];
      }
      anhoAux = ano;
      vigencia = document.getElementById('duracion').value = anhoAux - anho;
      contarVeces.numero = 0;
    }

    function contarVeces(){
      if(contarVeces.numero <= vigencia){
        ++contarVeces.numero;
        addRow();
      }
    }

    function addRow(){
      let table = document.getElementById('tableAux');
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
        echo '<script>cargarCampos("'.$camposIdForm.'","'.$valores.'")</script>';
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
    console.log('fadsf');
    var campos = ['moneda_id','oficina_id', 'vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes', 'creador'];
    var valores = [$('#moneda').val(), $('#idOfi').val(), $('#vigencia_hasta').val(), $('#fee_operaciones').val(), $('#obs').val(), $('#estado').val(), $('#mora_dia').val(), $('#interes').val(), $('#duracion'), ""];

    insertarDatos(campos, 'contratos', valores);

    $.post("Parametros/obtenerDatos.php",{campos:['id'],tabla:'contratos',campoCondicion:campos,valores:valores}, function(resultado) {
                console.log(resultado+" prueba");
                var res=JSON.parse(resultado);
                $('#idFormulario').val(res[0]);
             });
    pausa(1000);
  }

   function detalleCarga(){
        var camposDetalle=['contratos_id','año','fee_administrativo', 'fondo_marketing'];
        for (var filaReal of tabla) {
            var filas=filaReal.slice();
            console.log(filas);
            if(filas[0]==""){
                filas.shift();
                datosDetalle=[$('#idFormulario').val(),...filas]
                console.log('variacion_anual  \ncampos :'+camposDetalle+"\n datos :"+datosDetalle);
                insertar('ubi_gabetas',camposDetalle,datosDetalle);
            }else{
                var id=filas[0];
                filas.shift();
                datosDetalle=[$('#idFormulario').val(),...filas]
                modificar('variacion_anual',camposDetalle,datosDetalle,'id',filaReal[0]);
            }
        }
    }
  </script>

</html>
