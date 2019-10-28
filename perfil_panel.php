<!DOCTYPE html>
<?php
include("Parametros/conexion.php");
$consultas=new Consultas();

// ========================================================================
//Seteo de cabecera y campos en el mismo orden para tomar de la $tabla
// ========================================================================
$cabecera=['Perfil','Tipo','Observaciones'];
$campos=['perfil','tipo','obs'];

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
          var campos=['perfil','elimina_doc','modifica_doc','substr(comentario,1,40)','fecreacion'];
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

    <body style="background-color:white" >
      <!--============================================================================= -->
      <!--CAMPO OCULTO UTILIZADO PARA LA EDICION -->
      <!--============================================================================= -->
              <form id="formularioMultiuso" action="" method="post">
                  <input type="hidden" name="seleccionado" id="seleccionado" value="0">
              </form>
      <!--============================================================================= -->
  <div class="menu-panel" >
      <!--campo buscador en el panel -->
        <h2 class='titulo-panel'>PANEL PERFILES</h2>


            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='perfil_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('perfil_form.php')" >
            <input type="button" class="boton_panel" name="EditarAcceso" value="Asignar Menu" onclick="editar('accesos_form.php')" >
            <input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('perfil')" >
        </div>

        <div class="mostrar-tabla">
            <table id='tablaPanel' cellspacing='0' style='width:100%'>
                <?php
                    $consultas->crearCabeceraTabla($cabecera);
                    array_unshift($campos,'id');
                    $resultadoConsulta=$consultas->consultarDatos($campos,'perfil');
                    echo "<tbody id='datosPanel'>";

                    while($datos=$resultadoConsulta->fetch_array(MYSQLI_NUM)){
                        $id=$datos[0];
                        echo "<tr class='datos-tabla' onclick='seleccionarFila($datos[0])' id='".$datos[0]."'>";
                        array_shift($datos);
                        foreach( $datos as $valor ){
                            echo "<td>".$valor." </td>";
                        }
                        echo "</tr>";
                    }
                    echo"</tbody>";

                 ?>
         </table>
        </div>

    </body>

</html>
