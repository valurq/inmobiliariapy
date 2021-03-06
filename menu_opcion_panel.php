<!DOCTYPE html>
<?php
session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
    include("Parametros/verificarConexion.php");

// DATOS
$cabecera=['Título','Grupo','Posición','Dirección'];
$campos=['titulo_menu','(SELECT descripcion FROM grupo_menu WHERE id=grupo_menu_id)','posicion','link_acceso'];


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
            var campos = ['titulo_menu','(SELECT descripcion FROM grupo_menu WHERE id=grupo_menu_id)','posicion','link_acceso'];
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

            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:224px; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE MENU</B></font>
            </div>

            <input type='text' name='buscador' id='buscador' placeholder="Buscar por titulo" onkeyup='buscarTablaPanelesQ(campos, this.value, "menu_opcion", "titulo_menu", "", "")'>
            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='menu_opcion_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('menu_opcion_form.php')">
            <input type="button" class="boton_panel" name="Eliminar" value="Eliminar"
            id="eliminarTest" onclick="popupC('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles',function (){eliminar('menu_opcion')},'menu_opcion')">
            <?php
                //name, campoId, campoDescripcion, tabla
                $consultas->crearMenuDesplegable('grupo','id','descripcion','grupo_menu');
             ?>
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'menu_opcion');

            ?>
        </div>
    </body>

    <script>
        $grupo = $("[name='grupo']");
        var option = document.createElement('option');
        var text = "Todos los grupos";
        option.appendChild(document.createTextNode(text));
        option.setAttribute('selected', true);
        option.setAttribute("value", "0");
        grupo.prepend(option);

        $buscador = $('#buscador');
        $grupo.change(function(){
            $value = $(this).val();
            //alert($value);

            if ($value != 0){
                document.getElementById('buscador').value="";
                buscarTablaPanelesQ(campos, "", 'menu_opcion','titulo_menu', 'grupo_menu_id', $value);
                $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"menu_opcion"'+", "+'"titulo_menu"'+", "+'"grupo_menu_id"'+", "+$value+")");
            }
            else if ($value == 0){
                document.getElementById('buscador').value="";
                buscarTablaPanelesQ(campos, "", 'menu_opcion','titulo_menu', '', '');
                $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"menu_opcion"'+", "+'"titulo_menu"'+", '', '')");
            }

        });

    </script>
</html>
