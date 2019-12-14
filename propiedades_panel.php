<!DOCTYPE html>
<?php
session_start();
include("Parametros/conexion.php");
$consultas = new Consultas();
include("Parametros/verificarConexion.php");
// DATOS
$cabecera=['Remax','Inmueble','Categoria propiedad','Propietario','Fecha alta','Precio'];
$campos=['id_remax','dsc_inmueble','cate_propiedad','propietario','fecha_alta','precio'];
// test

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

        <script type="text/javascript">
        // para busqueda en paneles
            var campos=['(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id)','fe_vto','importe','estado','fe_pago','nro_comprob','substr(concepto,1,30)'];
        </script>

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
            <input type="text" name="buscador" id="buscador" onkeyup="buscarTablaPaneles(campos, this.value ,'propiedades','id_remax')">
            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:300px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE PROPIEDADES</B></font>
            </div>

            <input type="button" class="boton_panel" name="Editar" value="Ver" onclick="editar('propiedades_form.php')">
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'propiedades');

            ?>
        </div>
    </body>

</html>
