<!DOCTYPE html>
<?php
session_start();
    include("Parametros/conexion.php");
    $consulta= new Consultas();
    include("Parametros/verificarConexion.php");

// DATOS
$cabecera=['Fecha','Moneda','Compra','Venta'];
$campos=['fecha','moneda_id','cotiz_compra','cotiz_venta'];


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
<!--============================================================================= -->

        <div class="menu-panel" >

            <br><br>
            <!--campo buscador en el panel -->

            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:224px; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE COTIZACION</B></font>
            </div>

            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='cotizacion_form.php';" value="Nuevo">
        </div>

        <div class="mostrar-tabla">
            <?php
             $consulta->crearTabla($cabecera,$campos,'cotizacion');

            ?>
        </div>
    </body>

</html>
