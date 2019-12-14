<!DOCTYPE html>
<?php
session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
    include("Parametros/verificarConexion.php");

    @$usuarioLogeado = $_SESSION['perfil'] ;

    $perfilUser=$consultas->consultarDatos(array('tipo'),'perfil',"","id",$usuarioLogeado );
    $perfilUser=$perfilUser->fetch_array(MYSQLI_NUM);
    

// DATOS
$cabecera=['Referencia','Relación','Categoria', 'Estado','Fecha Vencimiento [AAAA/MM/DD]'];
$campos=['referencia','refobjeto','categorias', 'estado','fecha_vto'];


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
        <script>
            var campos=['referencia','refobjeto','categorias', 'estado','fecha_vto'];
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

            <input type="text" name="buscador" id="buscador" placeholder="Ingrese su busqueda" onkeyup="buscarTablaPaneles(campos, this.value ,'adjuntos','buscador')">

            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE ADJUNTOS</B></font>
            </div>

            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='adjunto_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Ver" value="Ver" onclick="editar('adjunto_form.php')">
            <?php
                if ($perfilUser[0] == "TI") {
                echo "<input type='button' class='boton_panel' name='Eliminar' value='Eliminar'
                id='eliminarTest' onclick='popupC(".'"Advertencia"'.",".'"Esta seguro de que desea eliminar? los cambios son irreversibles"'.",function (){eliminar(".'"adjuntos"'.")},".'"adjuntos"'.")'>";
                    
                }
            ?>
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'adjuntos');

            ?>
        </div>
    </body>

</html>
