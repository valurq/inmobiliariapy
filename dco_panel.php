<!DOCTYPE html>
<?php
    session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
    include("Parametros/verificarConexion.php");
    $res=$consultas->consultarDatos(['id'],'vendedor',"",'usuario_id',$_SESSION['idUsu']);
    $res=$res->fetch_array();
    $vendedorId=$res[0];
    $cabecera=['ID','Fecha','Oficina','Operacion','T. Operacion','Precio','Moneda'];
    $campos=['id','fecha','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)','operacion','tipo_operacion','precio_final','(SELECT dsc_moneda FROM moneda WHERE id=moneda_id )'];
?>
<html lang="en" dir="ltr">

    <head>
          <link rel="stylesheet" href="CSS/popup.css">
          <link rel="stylesheet" href="CSS/paneles.css">
        <script
  			  src="https://code.jquery.com/jquery-3.4.0.js"
  			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  			  crossorigin="anonymous">
      </script>
        <script type="text/javascript" src="Js/funciones.js"></script>



        <meta charset="utf-8">
        <style media="screen">
            .menu-panel{
                width: 100%
            }
            .mostrar-tabla{
                width: 100%;
            }
            .button-group{
                float:right;

            }
            a {
              background: #FFF;
              cursor: pointer;
              border-top: solid 2px #eaeaea;
              border-left: solid 2px #eaeaea;
              border-bottom: solid 2px #777;
              border-right: solid 2px #777;
              padding: 5px 5px;
            }

            a.down {
              color:white;
              background-color:#16156f;
              border-top: solid 2px #777;
              border-left: solid 2px #777;
              border-bottom: solid 2px #eaeaea;
              border-right: solid 2px #eaeaea;
            }
            .popupLocal{
                background-color: white;
                width: 360px;
                height: 370px;
                position: absolute;
                left: 45%;
                top:25%;
                margin-top:-75px;
                margin-left: -200px;
                box-sizing: border-box;
                border:1px solid black;
                border-radius: 20px;
                z-index: 10;
                padding: 15px;
                padding-top: 30px;
            }
            .contenedores{
                display:flex;
                flex-direction:column;
                justify-content:space-around;
                flex-wrap:wrap;
            }
            .contenedores>select{
                margin-top:5px;
            }
            .contenedores>input{
                margin-top: 30px;
            }
            .contenedores>label{
                margin-top: 20px;
            }
            #button1{
                margin-top: 20px;
                padding-left: 10px;
                padding-right: 10px;
                border-radius: 20px 0px 0px 20px;
                border:1px solid black;
                cursor:pointer;
            }
            #button2{
                margin-top: 20px;
                padding-left: 10px;
                padding-right: 10px;
                border:1px solid black;
                cursor:pointer;
            }
            #button3{
                margin-top: 20px;
                padding-left: 10px;
                padding-right: 10px;
                border:1px solid black;
                cursor:pointer;
            }
            #button4{
                margin-top: 20px;
                padding-left: 10px;
                padding-right: 10px;
                border-radius: 0px 20px 20px 0px;
                border:1px solid black;
                cursor:pointer;
            }
        </style>
        <title>VALURQ_SRL</title>
        <script type="text/javascript">
            var campos=['id','fecha','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)','operacion','tipo_operacion','precio_final','(SELECT dsc_moneda FROM moneda WHERE id=moneda_id )'];
        </script>
    </head>

    <body style="background-color:white">
        <!--============================================================================= -->
              <!--CAMPO OCULTO UTILIZADO PARA LA EDICION -->
        <!--============================================================================= -->
        <form id="formularioMultiuso" action="" method="post">
            <input type="hidden" name="seleccionado" id="seleccionado" value="0">
            <input type="hidden" name="operacion" id="operacion" value="">
        </form>
        <!--============================================================================= -->

        <div class="menu-panel" >

            <br><br>
            <!--campo buscador en el panel -->

            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:800px; height:60px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE Documentos de Cierres de Operaciones - D.C.O.</B></font>
            </div>
            <input type="text" name="buscador" id="buscador" onkeyup="buscarTablaPaneles(campos, this.value ,'dco','buscador')" placeholder="Buscar D.C.O.">
            <input type="button" class="boton_panel" name="Nuevo" onclick ="abrirPopupDCO()" value="Nuevo D.C.O.">
            <!-- <input type="button" class="boton_panel" name="Nuevo" onclick = "location='dco_form.php';" value="Nuevo Alq.">
            <input type="button" class="boton_panel" name="Agregar Seccion" onclick = "location='dco_form.php';" value="Nuevo Alq. Adm."> -->
            <input type="button" class="boton_panel" name="Agregar Seccion" onclick = "abrirAnexoDCO();" value="DCO anexo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('ciudad_form.php')">
            <input type="button" class="boton_panel" name="Caida operacion" value="Caida operacion" onclick="" >
            <input type="button" class="boton_panel" name="PDF" value='PDF' onclick="" >
            <input type="button" class="boton_panel" name="Liquidar" value="Liquidar" onclick="">
            <div class='button-group' >
                <input type="button" class="boton_panel" name="Filtro" onclick = "abrirFiltro();" value="Filtro">
                <a id="button1" title="Mostrar los DCO de alquileres">Alquiler</a><a id="button2" title="Mostrar los DCO de ventas">Alquiler Adm.</a><a id="button3" title="Mostrar todos los DCO">Venta</a><a id="button4" class='down' title="Mostrar todos los DCO">Todos</a>
            </div>
        </div>

        <div class="mostrar-tabla">
            <table id='tablaPanel' cellspacing='0' style='width:100%'>

            <?php
             //crearTabla($cabecera,$campos,'dco',"id","(SELECT dco_id FROM dco_detalle)");
             crearCabeceraTabla($cabecera);
             crearContenidoTabla();
            function crearCabeceraTabla($titulos,$tamanhos=['*']){
                 /*
                     METODO PARA PODER CREAR LOS TITULOS DE UNA TABLA
                     $objetoConsultas->crearCabeceraTabla(<Array de nombres de cabecera>,<array de tamaños para las columnas>)
                 */
                 echo"<thead style='width:100%'>";
                 echo "<tr>";
                 for($i=0;$i<count($titulos);$i++){
                     if(count($tamanhos)<$i+1){
                         echo"<td class='titulo-tabla'>".$titulos[$i]."</td>";
                     }else{
                         echo"<td style='width:".$tamanhos[$i]."' class='titulo-tabla'>".$titulos[$i]."</td>";
                     }
                 }
                 echo "</tr>";
                 echo"</thead>";
             }
            function crearContenidoTabla(){
                global $vendedorId;
                global $consultas;
                 /*
                     METODO PARA PODER CREAR LOS DATOS DENTRO DE UNA TABLA
                     $objetoConsultas->crearContenidoTabla(<Resultado de consulta a la base de datos>);
                 */
                $query="SELECT id,fecha,(SELECT dsc_oficina FROM oficina WHERE id=(SELECT oficina_id FROM dco_detalle WHERE dco_id = dco.id AND vendedor_id=6)),operacion,tipo_operacion,precio_final,(SELECT dsc_moneda FROM moneda WHERE id=moneda_id ) from dco WHERE id in (select dco_id from dco_detalle where vendedor_id=".$vendedorId." )";
                $resultadoConsulta=$consultas->conexion->query($query);
                echo "<tbody id='datosPanel'>";
                if(!(is_bool($resultadoConsulta))){
                    while($datos=$resultadoConsulta->fetch_array(MYSQLI_NUM)){
                        echo "<tr class='datos-tabla' onclick='seleccionarFilaDCO($datos[0],".'"'.$datos[3].'"'.")' id='".$datos[0]."'>";
                        //array_shift($datos);
                        foreach( $datos as $valor ){
                            echo "<td>".$valor." </td>";
                        }
                        echo "</tr>";
                    }
                 }
                echo"</tbody>";
             }
            ?>
            </table>
        </div>
    </body>
    <script type="text/javascript">

        $(document).ready(function() {
              $button1 = $('a#button1');
              $button2 = $('a#button2');
              $button3 = $('a#button3');
              $button4 = $('a#button4');
              $buscador = $('#buscador');
              $anho = $("#anho");

              //falta hacer el nombreOfi

              $button1.click(function() {
                if ( $(this).attr('class') != "down" ){
                    desmarcar();
                    $(this).toggleClass("down");
                    buscarTablaPanelesQ(campos,"","dco","buscador", "operacion", "ALQUILER",'ORDER BY fecha DESC');
                    $buscador.on("click", function (){"buscarTablaPanelesQ(campos, this.value, "+'"dco"'+","+'"buscador"'+", "+'new Array("operacion")'+", "+'new Array("ALQUILER")'+")"});
                    cargarBuscador('operacion',"ALQUILER")
                    document.getElementById('buscador').value="";
                }
              });

              $button2.click(function() {
                if ( $(this).attr('class') != "down" ){
                    desmarcar();
                    $(this).toggleClass("down");
                    buscarTablaPanelesQ(campos,"","dco","buscador", "operacion", "ALQUILER ADM.",'ORDER BY fecha DESC');
                    $buscador.on("click", function (){buscarTablaPanelesQ(campos, this.value, 'dco','buscador',"operacion","ALQUILER ADM.",'ORDER BY fecha DESC')});
                    document.getElementById('buscador').value="";
                }
              });

              $button3.click(function() {
                if ( $(this).attr('class') != "down" ){
                    desmarcar();
                    $(this).toggleClass("down");
                    buscarTablaPanelesQ(campos,"","dco","buscador", "operacion", "VENTA",'ORDER BY fecha DESC');
                    $buscador.on("click", function (){buscarTablaPanelesQ(campos, this.value, "dco","buscador","operacion", "VENTA")});
                    cargarBuscador('operacion','VENTA');
                    document.getElementById('buscador').value="";
                }
              });
              $button4.click(function() {
                  if ( $(this).attr('class') != "down" ){
                      desmarcar();
                      $(this).toggleClass("down");
                      buscarTablaPanelesQ(campos,"","dco","buscador");
                      $buscador.on("click", function (){buscarTablaPanelesQ(campos, this.value, "dco","buscador",'ORDER BY fecha DESC')});
                     cargarBuscador("","");
                      document.getElementById('buscador').value="";
                    }
              });
            function desmarcar(){
                    if($button1.attr('class') == "down"){
                        $button1.toggleClass("down");
                    }
                    if($button2.attr('class') == "down"){
                        $button2.toggleClass("down");
                    }
                    if($button3.attr('class') == "down"){
                         $button3.toggleClass("down");
                    }
                    if($button4.attr('class') == "down"){
                         $button4.toggleClass("down");
                    }
                    //$anho.val("");
                }
            function cargarBuscador(campoCondicion, valorCondicion){

            }
         });
        function seleccionarFilaDCO(id,tOperacion){
            seleccionarFila(id);
            document.getElementById('operacion').value=tOperacion;
            console.log(id+" - "+tOperacion);
        }
        function abrirPopupDCO(){
            if(!(document.getElementById("popupDCO"))){
                crearPopupDCO();
            }else{
                $("#popupDCO").show();
            }
        }
        function crearPopupDCO(){
            var pop=document.createElement('div');
                pop.id="popupDCO";
                pop.className="popupLocal";
            var contenedor=document.createElement('div');
                contenedor.className='contenedores';
                contenedor.id='cont';
            var label1=document.createElement("label");
                label1.innerHTML="Operacion del D.C.O.";
            var operacionDCO=document.createElement("select");
                operacionDCO.id='operacionDCO';
                operacionDCO.innerHTML="<option value=0></option><option value='Venta' >1-Venta</option><option value='Alquiler'>2-Alquiler</option><option value='Alquiler Aadmin'>3-Alquiler Administrado</option>";
            var label2=document.createElement("label");
                label2.innerHTML="Tipo de Operacion";
            var tipoOperacion=document.createElement("select");
                tipoOperacion.id='tipoOperacion';
                tipoOperacion.innerHTML="<option value=0></option><option value='Individual' >1-Individual</option><option value='Compartida misma oficina RE/MAX'>2-Compartida misma oficina RE/MAX</option><option value='Compartida Otra Oficina RE/MAX'>3-Compartida Otra Oficina RE/MAX</option><option value='Compartida Oficina Externa'>4-Compartida Oficina Externa</option>";
            var boton=document.createElement('input');
                boton.type='button';
                boton.id='abrirDCO';
                boton.value='Crear';
                boton.style="background-color:#16156f;color:white;border-radius: 20px;border:1px solid black;cursor:pointer;height:30px";
                boton.addEventListener("click",function (){abrirDCO()})
            var botonC=document.createElement('input');
                botonC.type='button';
                botonC.id='cerrarDco';
                botonC.style="background-color: white;border-radius: 20px;border:1px solid black;cursor:pointer;height:30px";
                botonC.value='Cerrar';
                botonC.addEventListener("click",function (){cerrarPopupDCO()})
            contenedor.appendChild(label1);
            contenedor.appendChild(operacionDCO);
            contenedor.appendChild(label2);
            contenedor.appendChild(tipoOperacion);
            contenedor.appendChild(boton);
            contenedor.appendChild(botonC);
            pop.appendChild(contenedor);
            document.body.appendChild(pop);
        }
        function abrirDCO(){
            var tipoOp=$("#tipoOperacion").val();
            if(true){
                window.location='dco_form1-1.php?tOp='+tipoOp;
            }
        }
        function abrirAnexoDCO(){
            let operacion=document.getElementById('operacion').value;
            switch (operacion) {
                case 'VENTA':
                    document.getElementById('formularioMultiuso').action='dco_anexo_venta.php';
                    document.getElementById('formularioMultiuso').submit();
                    break;
                default:

            }
        }
        function venta(tipoOp){
            switch (tipoOp) {
                case '1':
                console.log('prueba de abrir DCO'+tipoOp);
                    window.location='dco_form1-1.php';
                    break;
                case '2':
                    window.location='dco_form1-N.php?cant='+2+'&ref=N';
                    break;
                case '3':
                    window.location='dco_form1-N.php?cant='+3+'&ref=C';
                    break;
                case '4':
                    window.location='dco_form1-N.php?cant='+3+'&ref=V';
                    break;
                case '5':
                    window.location='dco_form1-N.php?cant='+4+'&ref=D';
                    break;
                case '6':
                    window.location='dco_formN-N.php?cant='+2+'&ref=N';
                    break;
                case '7':
                    window.location='dco_formN-N.php?cant='+3+'&ref=C';
                    break;
                case '8':
                    window.location='dco_formN-N.php?cant='+3+'&ref=V';
                    break;
                case '9':
                    window.location='dco_formN-N.php?cant='+4+'&ref=D';
                    break;
                default:
                    console.log("testing"+tipoOp);
            }

        }
        function alquilado(){

        }
        function alquilerAdmi(){

        }
        function cerrarPopupDCO(){
            $("#popupDCO").hide();
        }
        function abrirFiltro(){
            if(!(document.getElementById("popupFiltro"))){
                crearPopupFiltro();
            }else{
                $("#popupFiltro").show();
            }
        }
        function crearPopupFiltro(){
            var pop=document.createElement('div');
                pop.id="popupFiltro";
                pop.className="popupLocal";
            var contenedor=document.createElement('div');
                contenedor.id='contFiltro';
                contenedor.className='contenedores';
            var label1=document.createElement("label");
                label1.innerHTML="Fecha Desde:";
            var nDco=document.createElement("input");
                nDco.id='fDesde';
                nDco.type='date';
            var label2=document.createElement("label");
                label2.innerHTML="Fecha Hasta:";
            var idPropiedad=document.createElement("input");
                idPropiedad.id='fHasta';
                idPropiedad.type='date';
            var boton=document.createElement('input');
                boton.type='button';
                boton.id='aplicarFiltro';
                boton.value='Filtrar';
                boton.className='boton-formulario'
                boton.style="background-color:#16156f;color:white;border-radius: 20px;border:1px solid black;cursor:pointer;height:30px";
                boton.addEventListener("click",function (){filtrar()})
            var botonC=document.createElement('input');
                botonC.type='button';
                botonC.id='cerrarFiltro';
                botonC.style="background-color: white;border-radius: 20px;border:1px solid black;cursor:pointer;height:30px";
                botonC.value='Cerrar';
                botonC.addEventListener("click",function (){cerrarFiltro()})

            contenedor.appendChild(label1);
            contenedor.appendChild(nDco);
            contenedor.appendChild(label2);
            contenedor.appendChild(idPropiedad);
            contenedor.appendChild(boton);
            contenedor.appendChild(botonC);
            pop.appendChild(contenedor);
            document.body.appendChild(pop);
        }
        function cerrarFiltro(){
            $("#popupFiltro").hide();
        }
        function filtrar(){
            buscarTablaPanelesQ(campos,"","dco","buscador", "", "",' AND DATE(fecha) BETWEEN DATE("'+$("#fDesde").val()+'") AND DATE("'+$("#fHasta").val()+'") ORDER BY fecha DESC');
            cerrarFiltro();
        }
    </script>
</html>
