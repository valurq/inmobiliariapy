<!DOCTYPE html>
<?php
session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
    include("Parametros/verificarConexion.php");

// DATOS
$cabecera=['Agente', 'Fecha','Estado','Conceptos','Importe','Fecha de Uso'];
$campos=['(SELECT dsc_vendedor FROM vendedor WHERE id = vendedor_id)' ,'fecha','estado','(SELECT dsc_concepto FROM conceptos WHERE id= conceptos_id)','importe','fecha_uso'];
//$campos = ['fecha','estado','conceptos_id','obs'];


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
            var campos=['(SELECT dsc_vendedor FROM vendedor WHERE id = vendedor_id)' ,'fecha','estado','(SELECT dsc_concepto FROM conceptos WHERE id= conceptos_id)','importe','fecha_uso'];
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
            <input type="text" name="buscador" id="buscador" placeholder="Buscar por agente" onkeyup="buscarTablaPaneles(campos, this.value ,'descuentos','(SELECT dsc_vendedor FROM vendedor WHERE id = vendedor_id)')">
            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE DESCUENTOS</B></font>
            </div>

            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='descuentos_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('descuentos_form.php')">
            <input type="button" class="boton_panel" name="Eliminar" value="Eliminar"
            id="eliminarTest" onclick="popupC('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles',function (){eliminar('descuentos')},'descuentos')">
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'descuentos');

            ?>
        </div>
    </body>

</html>
