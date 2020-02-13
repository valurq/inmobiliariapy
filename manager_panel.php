<!DOCTYPE html>
<?php
session_start();
include("Parametros/conexion.php");
$consultas = new Consultas();
include("Parametros/verificarConexion.php");

// DATOS
$cabecera=['Nombre', 'Apellido', 'Usuario','Oficina', 'Comisión sobre operaciones','Fecha Ingreso'];
$campos=['nombrefull', 'apellido', '(SELECT usuario FROM usuario WHERE id=usuario_id)','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)', 'porcentaje_opera','fe_ingreso'];


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
            var campos=['nombrefull', 'apellido', '(SELECT usuario FROM usuario WHERE id=usuario_id)','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)', 'porcentaje_opera','fe_ingreso'];
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
            <input type="text" name="buscador" id="buscador" placeholder="Buscar por nombre o por oficina" style="width: 15%;" onkeyup="buscarTablaPaneles(campos, this.value ,'manager','(CONCAT(nombrefull,(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)) )')">
            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:224px; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE MANAGER</B></font>
            </div>

            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='manager_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('manager_form.php')">
            <input type="button" class="boton_panel" name="Eliminar" value="Eliminar"
            id="eliminarTest" onclick="popupC('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles',function (){eliminarManager()},'manager')">
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'manager', '', '', ['16%','16%','16%','16%','16%','16%']);

            ?>
        </div>
    </body>
    <script type="text/javascript">
        
    function eliminarManager(){
        let id = document.getElementById('seleccionado').value;

        obtenerDatosCallBack(["oficina_id"], 'manager', 'id', id, '', resultado => {console.log(resultado[0]); modificarDatos('oficina', ['dsc_manager'], [''], 'id', resultado[0][0])});

        obtenerDatosCallBack(["usuario_id"], 'manager', 'id', id, '', resultado => {console.log(resultado[0]); modificarDatos('usuario', ['asignado'], ['NO'], 'id', resultado[0][0])});

        eliminar('manager');
    }
    </script>

</html>
