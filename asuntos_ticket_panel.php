<?php
    session_start();
    include("Parametros/conexion.php");
    include("Parametros/verificarConexion.php");
    $consultas=new Consultas();

    // ========================================================================
    //Seteo de cabecera y campos en el mismo orden para tomar de la $tabla
    // ========================================================================
    $cabecera=['ID','Asunto','Observaciones'];
    $campos=['id','asunto','obs'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
      <title>Módulo de Asuntos de Tickets</title>
      <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/paneles.css">
      <script src="JS/jquery-3.4.0.js"></script>
      <script src="JS/funciones.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script type="text/javascript">
         // para busqueda en paneles
         var campos = ['id','asunto','obs'];
      </script> 
      <style media="screen">
         .menu-panel{
             width: 100%
         }
         .mostrar-tabla{
            width: 100%;
         }
      </style>
    </head>
    <body class="container-fluid" style="background-color:white">
      <!--============================================================================= -->
            <!--CAMPO OCULTO UTILIZADO PARA LA EDICION -->
      <!--============================================================================= -->
        <form id="formularioMultiuso" action="" method="post">
            <input type="hidden" name="seleccionado" id="seleccionado" value="0">
        </form>
      <!--============================================================================= -->

     <div class="menu-panel" >
         <div id="resultadoBusqueda">
        <br><br>
        <!---TITULO DEL PANEL-->
        <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:540px; height:22px; z-index:1">
            <font color="#808080" class="ws12"><B>PANEL DE ASUNTOS DE TICKETS</B></font>
        </div>
        <div class="row mb-3 mx-3">
            <!--FILTROS DEL PANEL-->     
            <label for="asunto">Buscar:</label>     
            <input class="form-control form-control-sm" type="text" name="asunto" id="asunto" onkeyup="buscar();">
        </div>
        <div class="row mb-3">
            <div class="col-sm-12 text-right">
                <!--ACCIONES DEL PANEL-->
                <input type="button" class="boton_panel" name="Nuevo" onclick = "location='asuntos_ticket_form.php';"  value="Nuevo">
                <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('asuntos_ticket_form.php')" >
                <input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('asuntos')" >
            </div>
        </div>
    </div>
        <div class="mostrar-tabla">
            <?php  $consultas->crearTabla($cabecera,$campos,'asuntos');?>
        </div>
    </body>
     
    <script>
        function buscar(){

        var where = "WHERE";
        var asunto = document.getElementById("asunto");
        
        buscarTablaPaneles(campos,asunto.value,'asuntos','asunto');

        }
    </script>

</html>
