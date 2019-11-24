<!DOCTYPE html>
<?php
    session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
    include("Parametros/verificarConexion.php");

    $cabecera=['ID','Fecha','Oficina','Operacion','T. Operacion','Precio','Moneda','Vendedor'];
    $campos=['id','fecha','dsc_oficina','operacion','tipo_operacion','precio_final','(SELECT dsc_moneda FROM moneda WHERE id=moneda_id )','(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id)'];
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
              background: #ccc;
              cursor: pointer;
              border-top: solid 2px #eaeaea;
              border-left: solid 2px #eaeaea;
              border-bottom: solid 2px #777;
              border-right: solid 2px #777;
              padding: 5px 5px;
            }

            a.down {
              background: #bbb;
              border-top: solid 2px #777;
              border-left: solid 2px #777;
              border-bottom: solid 2px #eaeaea;
              border-right: solid 2px #eaeaea;
            }
        </style>
        <title>VALURQ_SRL</title>
        <script type="text/javascript">
            var campos=['id','fecha','dsc_oficina','operacion','tipo_operacion','precio_final','(SELECT dsc_moneda FROM moneda WHERE id=moneda_id )','(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id)']
        </script>
    </head>

    <body style="background-color:white">
<!--============================================================================= -->
      <!--CAMPO OCULTO UTILIZADO PARA LA EDICION -->
<!--============================================================================= -->
        <form id="formularioMultiuso" action="" method="post">
            <input type="hidden" name="seleccionado" id="seleccionado" value="0">
        </form>
<!--============================================================================= -->

        <div class="menu-panel" >

            <br><br>
            <!--campo buscador en el panel -->

            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:224px; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE CIUDADES</B></font>
            </div>
            <input type="text" name="buscador" id="buscador" onkeyup="buscarTablaPaneles(campos, this.value ,'dco','buscador')">
            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='dco_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('ciudad_form.php')">
            <input type="button" class="boton_panel" name="Caida operacion" value="Caida operacion" onclick="" >
            <input type="button" class="boton_panel" name="PDF" value='PDF' onclick="" >
            <input type="button" class="boton_panel" name="Liquidar" value="Liquidar" onclick="">
            <div class='button-group' >
                <input type="text" name="anho" id='anho' value="" style="width:100px" placeholder="Año a buscar">
                <a id="button1" title="Mostrar los DCO de alquileres">Alquiler</a>
                <a id="button2" title="Mostrar los DCO de ventas">Alquiler Adm.</a>
                <a id="button3" title="Mostrar todos los DCO">Venta</a>
                <a id="button4" class='down' title="Mostrar todos los DCO">Todos</a>
            </div>
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'dco');

            ?>
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
            //    $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"dco"'+","+'"buscador"'+", "+'new Array("operacion")'+", "+'new Array("ALQUILER")'+")");
            cargarBuscador('operacion',"ALQUILER")
                document.getElementById('buscador').value="";
            }
          });

          $button2.click(function() {
            if ( $(this).attr('class') != "down" ){
                desmarcar();
                $(this).toggleClass("down");
                buscarTablaPanelesQ(campos,"","dco","buscador", "operacion", "ALQUILER ADM.");
                $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"dco"'+","+'"buscador"'+", "+'"operacion"'+", "+'"ALQUILER ADM."'+")");
                document.getElementById('buscador').value="";
            }
          });

          $button3.click(function() {
            if ( $(this).attr('class') != "down" ){
                desmarcar();
                $(this).toggleClass("down");
                buscarTablaPanelesQ(campos,"","dco","buscador", "operacion", "VENTA");
                //$buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"dco"'+","+'"buscador"'+", "+'"operacion"'+", "+'"VENTA"'+")");
                cargarBuscador('operacion','VENTA');
                document.getElementById('buscador').value="";
            }
        });
        $button4.click(function() {
          if ( $(this).attr('class') != "down" ){
              desmarcar();
              $(this).toggleClass("down");
              buscarTablaPanelesQ(campos,"","dco","buscador");
             // $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"dco"'+","+'"buscador"'+")");
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
            if($anho.val()!=""){
                if(campoCondicion!=''){
                buscarTablaPanelesQ(campos,"","dco","buscador", new Array( campoCondicion,"YEAR(fecha)"),new Array(valorCondicion,$anho.val()));
                $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value,'dco', 'buscador,'',"+'new Array("'+campoCondicion+'","YEAR(fecha)"),'+'new Array("'+valorCondicion+'","'+$anho.val()+'")');
                }else{
                    buscarTablaPanelesQ(campos,"","dco","buscador", new Array( "YEAR(fecha)") ,new Array($anho.val()) );
                    $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value,'dco', 'buscador,'',"+'new Array("'+YEAR(fecha)+'"),'+'new Array("'+$anho.val()+'")');
                }
            }else {
                if(campoCondicion!=''){
                    buscarTablaPanelesQ(campos,"","dco","buscador", new Array(campoCondicion), new Array(valorCondicion));
                    $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value,'dco', 'buscador,'',"+'new Array("'+campoCondicion+'"),'+'new Array("'+valorCondicion+'")');
                }else{
                    buscarTablaPanelesQ(campos,"","dco","buscador");
                    $buscador.attr("onkeyup", 'buscarTablaPanelesQ(campos,"","dco","buscador")');
                }
            }
        }
    });

    </script>

</html>
