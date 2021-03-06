<!DOCTYPE HTML>
<html>
<head>
  <script src="http://momentjs.com/downloads/moment.min.js"></script>
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
        $fecha_inicial=$inserta_Datos->consultarDatos(array('cobro_fee_desde'),'oficina',"","id",$oficina );
        $fecha_inicial=$fecha_inicial->fetch_array(MYSQLI_NUM);
        
        $nombre_oficina=$inserta_Datos->consultarDatos(array('dsc_oficina'),'oficina',"","id",$oficina );
        $nombre_oficina=$nombre_oficina->fetch_array(MYSQLI_NUM);
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
  <h2>CONTRATO <?php echo "DE LA OFICINA $nombre_oficina[0]"; ?></h2>
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
            <td><input type="date" name="vigencia_hasta" id="vigencia_hasta" min="<?php echo $fecha_inicial[0] ?>" onchange ="agregarAnho(this.value);" placeholder="Ingrese la fecha de vigencia" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Duración (en años)</label></td>
            <td><input type="number" name="duracion" id="duracion" min="0" readonly step="any" readonly placeholder="Ingrese la duración del contrato" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Porcentaje a pagar sobre operaciones</label></td>
            <td><input type="number" name="fee_operaciones" id="fee_operaciones" min="0" step="any" placeholder="Ingrese el porcentaje" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Mora por día</label></td>
            <td><input type="text" name="mora_dia" id="mora_dia" step="any" data-type="currency" maxlength="12" placeholder="Ingrese el monto de la mora" class="campos-ingreso" onkeyup="formatoMoneda($(this))" onblur="formatoMoneda($(this), 'blur')"></td>
        </tr>
        <tr>
            <td><label for="">Interés</label></td>
            <td><input type="number" name="interes" id="interes" step="any" min="0" placeholder="Ingrese el porcentaje de interés" class="campos-ingreso"></td>
        </tr>
        <tr>
            <td><label for="">Estado</label></td>
            <td>
              <select name="estado" id="estado" class="campos-ingreso">
                  <option value="vigente">vigente</option>
                  <option value="inactivo">inactivo</option>
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
  <form action="" id="form2">
    <fieldset>
      <legend>COBROS POR CONTRATO</legend>
      <table>
        <tbody id="tableInput">
          <tr>
            <td><span><b>DESDE</b></span></td>
            <td><span><b>HASTA</b></span></td>
            <td><span><b>FEE ADM.</b></span></td>
            <td><span><b>FEE MK.</b></span></td>
            <td><span><b></b></span></td>
          </tr>
          <tr>
            <td><input type="date" name="desde" id="desde"  style="width: 130px;" /></td>
            <td><input type="date" name="hasta" id="hasta"  style="width: 130px;" /></td>
            <td><input type="text" data-type="currency" maxlength="12" name="fee_adm" id="fee_adm" placeholder="Ingrese el fee de administracioón" onkeyup="formatoMoneda($(this))" onblur="formatoMoneda($(this), 'blur')"/></td>
            <td><input type="text" data-type="currency" maxlength="12" name="fee_mk" id="fee_mk" placeholder="Ingrese el fee de marketing" onkeyup="formatoMoneda($(this))" onblur="formatoMoneda($(this), 'blur')"/></td>
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
    let table = document.getElementById('tableAux');
    $tableAux = $('#tableAux');
    let tabla = [];
    let fecha_inicial = moment("<?php echo $fecha_inicial[0] ?>");
    let fecha_actual = moment().format('YYYY-MM-DD');
    let bandera = undefined;

    function agregarAnho(fecha) {
      bandera = false;
      let fecha_vigencia = moment(document.getElementById('vigencia_hasta').value);
      document.getElementById('fee_adm').value = "";
      document.getElementById('fee_mk').value = "";
      document.getElementById('desde').value = "";
      document.getElementById('hasta').value = "";

      document.getElementById('desde').setAttribute('min', fecha_inicial.format('YYYY-MM-DD'));
      document.getElementById('desde').value = fecha_inicial.format('YYYY-MM-DD');
      document.getElementById('hasta').setAttribute('min', moment(document.getElementById('desde').value).format('YYYY-MM-DD'));
      document.getElementById('hasta').setAttribute('max', fecha_vigencia.format('YYYY-MM-DD'));
      let ano = [];
      for (let i = 0; i < 4; i++) {
        ano += fecha[i];
      }
      anhoAux = ano;
      document.getElementById('duracion').value = fecha_vigencia.diff(fecha_actual, 'years');

      $('#tableAux tr').remove();
      tabla = [];
    }

    function contarVeces(){
      let fecha_desde = moment(document.getElementById('desde').value);
      let fecha_hasta = moment(document.getElementById('hasta').value);

      if(!bandera){

        let fecha_vigencia = moment(document.getElementById('vigencia_hasta').value);

        if(fecha_hasta.diff(fecha_desde, 'days') >= 0){
          if ( (document.getElementById('fee_adm').value == "") && (document.getElementById('fee_mk').value == "") ) {
            popup('Advertencia','Es necesario ingresar al menos un valor!!') ;
          } else {
            if(document.getElementById('fee_adm').value == "")
              document.getElementById('fee_adm').value = 0;

            if(document.getElementById('fee_mk').value == "")
              document.getElementById('fee_mk').value = 0;

            ++contarVeces.numero;
            
            if(fecha_vigencia.diff(fecha_hasta, 'days') == 0)
              bandera = true;
            addRow();
          }
          
        }else {
          popup('Advertencia','La fecha desde no puede ser mayor a la fecha hasta!!') ;
        }
        
      }else{
        popup('Advertencia','Ya ha cargado todos los registros!!') ;
      }
    }

    function addRow(){
      let fecha = moment(document.getElementById('hasta').value);
      let row = document.createElement('tr');
      let data = document.createElement('td');
      let desde = document.getElementById('desde').value;
      let text = document.createTextNode(desde);
      data.appendChild(text);
      data.style.width = "25%";
      row.appendChild(data);
      table.appendChild(row);

      data = document.createElement('td');
      let hasta = document.getElementById('hasta').value;
      text = document.createTextNode(hasta);
      data.appendChild(text);
      data.style.width = "25%";
      row.appendChild(data);
      table.appendChild(row);

      data = document.createElement('td');
      let fee_adm = document.getElementById('fee_adm').value;
      text = document.createTextNode(fee_adm);
      data.appendChild(text);
      data.style.width = "25%";
      row.appendChild(data);
      table.appendChild(row);

      data = document.createElement('td');
      let fee_mk = document.getElementById('fee_mk').value;
      text = document.createTextNode(fee_mk);
      data.appendChild(text);
      data.style.width = "25%";
      row.appendChild(data);
      table.appendChild(row);

      tabla.push(new Array(document.getElementById('desde').value, document.getElementById('hasta').value, document.getElementById('fee_adm').value, document.getElementById('fee_mk').value));

      document.getElementById('fee_adm').value = "";
      document.getElementById('fee_mk').value = "";
      document.getElementById('desde').value = fecha.add(1, 'days').format('YYYY-MM-DD');
      document.getElementById('desde').setAttribute('min', fecha.format('YYYY-MM-DD'));
      document.getElementById('hasta').value = "";
      document.getElementById('hasta').setAttribute('min', fecha.add(0, 'days').format('YYYY-MM-DD'));
      //document.getElementById('ano').value = anho + contarVeces.numero;
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
      let fecha1 = moment("<?php echo $fecha_inicial[0] ?>");
      let fecha2 = moment(document.getElementById('vigencia_hasta').value);
	       if(document.getElementById('vigencia_hasta').value ==""){
             popup('Advertencia','Es necesario ingresar una fecha de vigencia!!') ;
             return false ;
         }else if ( fecha1.diff(fecha2, 'days') > 0 ){
            popup('Advertencia','La fecha de la vigencia es incorrecta!!') ;
             return false ;
         }else if($("#fee_operaciones").val() ==""){
             popup('Advertencia','Es necesario ingresar un valor entre 0 y 50 para el porcentaje de las operaciones!!') ;
             return false ;
         }else if($("#fee_operaciones").val() > 50){
             popup('Advertencia','El porcentaje no puede ser mayor a 50!!') ;
             return false ;
         }else if($("#fee_operaciones").val() < 0){
             popup('Advertencia','El porcentaje no puede ser un número negativo!!') ;
             return false ;
         }else if($("#interes").val() == ""){
             popup('Advertencia','Debe ingresar un valor entre 0 y 20 para el interés!!') ;
             return false ;
         }else if($("#interes").val() > 20){
             popup('Advertencia','Debe ingresar un valor entre 0 y 20 para el interés!!') ;
             return false ;
         }else if($("#interes").val()< 0){
             popup('Advertencia','Debe ingresar un valor entre 0 y 20 para el interés!!') ;
             return false ;
         }else if (!bandera) {
            popup('Advertencia','Es necesario ingresar todos los registros de Cobros por Contrato!!') ;
             return false ;
         }
         else{
             insertar();
         }
  }

  function insertar(){
    var campos = ['moneda_id','oficina_id', 'vigencia_hasta', 'fee_operaciones', 'obs', 'estado', 'mora_dia', 'interes','duracion', 'creador'];
    var mora = $('#mora_dia').val().replace(/\./gi, '');
    mora = mora.replace(/,/gi, '.');
    var valores = [$('#moneda').val(), $('#idOfi').val(), $('#vigencia_hasta').val(), $('#fee_operaciones').val(), $('#obs').val(), $('#estado').val(), mora, $('#interes').val(), $('#duracion').val(), "creador"];

    console.log(valores);

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
        var camposDetalle=['desde','hasta','fee_administrativo', 'fondo_marketing','contratos_id'];
        var id=$('#Idformulario').val();
        //alert(id);

        for (var filaReal of tabla) {
            var filas=filaReal.slice();
            filas[2] = filas[2].replace(/\./gi, '');
            filas[2] = filas[2].replace(/,/gi, '.');
            filas[3] = filas[3].replace(/\./gi, '');
            filas[3] = filas[3].replace(/,/gi, '.');
            filas.push(id);
            console.log(filas);
            insertarDatos(camposDetalle, 'variacion_anual', filas);
        }
    }
  </script>

</html>
