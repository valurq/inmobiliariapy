<!DOCTYPE html>
<?php
session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
    include("Parametros/verificarConexion.php");

// DATOS
$cabecera=['Moneda','Oficina', 'Vigencia', '% de operación', 'Estado'];
$campos=['(SELECT dsc_moneda FROM moneda WHERE id = moneda_id)','(SELECT dsc_oficina FROM oficina WHERE id = oficina_id)', 'vigencia_hasta', 'fee_operaciones', 'estado'];

@$oficina=$_POST['idOfi'];
$nombreOfi = $consultas->consultarDatos(["dsc_oficina"], "oficina", "", "id", @$oficina);
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
        <script type="text/javascript" src="Js/funciones.js">
        </script>
        <script type="text/javascript">
            var campos=['(SELECT dsc_moneda FROM moneda WHERE id = moneda_id)','(SELECT dsc_oficina FROM oficina WHERE id = oficina_id)', 'vigencia_hasta', 'fee_operaciones', 'estado'];
        </script>



        <meta charset="utf-8">
        <style media="screen">
            .menu-panel{
                width: 100%
            }
            .mostrar-tabla{
                width: 100%;
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
    </head>

    <body style="background-color:white">
<!--============================================================================= -->
      <!--CAMPO OCULTO UTILIZADO PARA LA EDICION -->
<!--============================================================================= -->
        <form id="formularioMultiuso" action="" method="post">
            <input type="hidden" name="seleccionado" id="seleccionado" value="0">
        </form>

        <form action="contrato2_form.php" method="POST" id='form_contrato'>
            <input type="hidden" name='idOfi'  value=<?php echo $oficina;?>>
        </form>
<!--============================================================================= -->

        <div class="menu-panel" >

            <br><br>
            <!--campo buscador en el panel -->

            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:224px; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE CONTRATO</B></font>
            </div>
            
            <?php
                if ($oficina != ""){
                    echo "<input type='button' class='boton_panel' name='Nuevo' value='Nuevo' onclick='document.getElementById(".'"form_contrato"'.").submit();'>";
                }else{
                    echo "<input type='button' class='boton_panel' name='Editar' value='Ver' onclick='editar(".'"contrato_ver_form.php"'.")' >";
                }
             ?>
            

            <?php
                if ($oficina == "") {
                    echo "<input type='text' name='buscador' id='buscador' onkeyup='buscarTablaPanelesQ(campos, this.value ,".'"contratos"'.",".'"(SELECT dsc_oficina FROM oficina WHERE id = oficina_id)"'.", ".'"(SELECT estado FROM oficina WHERE id = oficina_id)"'.", ".'"ACTIVO"'.")'>";
                }
            ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <a id="button1" title="Mostrar contratos vigentes">Vigente</a>
            <a id="button2" title="Mostrar contratos inactivos">Inactivo</a>
            <a id="button3" title="Mostrar todos los contratos">Todos</a>
            <!-- <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('contrato2_form.php')"> -->
           <!--  <input type="button" class="boton_panel" name="Eliminar" value="Eliminar"
            id="eliminarTest" onclick="popupC('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles',function (){eliminar('ciudad')},'ciudad')"> -->
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
            <?php
            if ($oficina == ""){
             $consultas->crearTabla($cabecera,$campos,'contratos', '(SELECT estado FROM oficina WHERE id = oficina_id)', 'ACTIVO');
            }else{
             $consultas->crearTabla($cabecera,$campos,'contratos', 'oficina_id', @$oficina);
            }

            ?>
        </div>

        <script>
            $(document).ready(function() {
              $button1 = $('a#button1');
              $button2 = $('a#button2');
              $button3 = $('a#button3');
              $buscador = $('#buscador');
              $oficina = "<?php echo $oficina ?>"

              //falta hacer el nombreOfi

              $button1.click(function() {
                if ( $(this).attr('class') != "down" ){
                    $(this).toggleClass("down");
                    buscarTablaPanelesQ(campos,"","contratos","(SELECT dsc_oficina FROM oficina WHERE id = oficina_id AND estado = 'ACTIVO')", "estado", "vigente");
                    if ($oficina == "") {
                        $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"contratos"'+","+'"(SELECT dsc_oficina FROM oficina WHERE id = oficina_id AND estado = '+"'ACTIVO'"+')"'+", "+'"estado"'+", "+'"vigente"'+")");
                        document.getElementById('buscador').value="";
                    }
                }

                if($button2.attr('class') == "down"){
                    $button2.toggleClass("down");

                }
                if($button3.attr('class') == "down"){
                     $button3.toggleClass("down");
                }
              });

              $button2.click(function() {
                if ( $(this).attr('class') != "down" ){
                    $(this).toggleClass("down");
                    buscarTablaPanelesQ(campos,"","contratos","(SELECT dsc_oficina FROM oficina WHERE id = oficina_id AND estado = 'ACTIVO')", "estado", "inactivo");

                    if ($oficina == "") {
                        $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"contratos"'+","+'"(SELECT dsc_oficina FROM oficina WHERE id = oficina_id AND estado = '+"'ACTIVO'"+')"'+", "+'"estado"'+", "+'"inactivo"'+")");
                        document.getElementById('buscador').value="";
                    }
                }

                if($button1.attr('class') == "down"){
                    $button1.toggleClass("down");
                }
                if($button3.attr('class') == "down"){
                     $button3.toggleClass("down");
                }
              });

              $button3.click(function() {
                if ( $(this).attr('class') != "down" ){
                    $(this).toggleClass("down");
                    buscarTablaPanelesQ(campos,"","contratos","(SELECT dsc_oficina FROM oficina WHERE id = oficina_id AND estado = 'ACTIVO')", "estado", "");
                    if ($oficina == "") {
                        $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"contratos"'+","+'"(SELECT dsc_oficina FROM oficina WHERE id = oficina_id AND estado = '+"'ACTIVO'"+')"'+", "+'"estado"'+", "+'""'+")");
                        document.getElementById('buscador').value="";
                    }
                }

                if($button2.attr('class') == "down"){
                        $button2.toggleClass("down");
                    }
                if($button1.attr('class') == "down"){
                     $button1.toggleClass("down");
                }

              });
            });
        </script>
    </body>

</html>
