<!DOCTYPE html>
<?php
    session_start();
    include("Parametros/conexion.php");
    $consultas = new Consultas();
    include("Parametros/verificarConexion.php");
    // DATOS
    $cabecera=['Remax','Inmueble','Categoria propiedad','Fecha alta','Precio', 'Moneda'];
    $campos=['id_remax','SUBSTR(dsc_inmueble,1,40)','cate_propiedad','fecha_alta','precio', 'precio_mon'];
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
            var campos=['id_remax','dsc_inmueble','cate_propiedad','fecha_alta','precio', 'precio_mon'];
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
            <input type="text" name="buscador" id="buscador" autocomplete="off" placeholder="Buscar por código" onkeyup="buscarTablaPaneles(campos, this.value ,'propiedades','id_remax')">
            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:300px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE PROPIEDADES</B></font>
            </div>

            <input type="button" class="boton_panel" name="Editar" value="Ver" onclick="editar('propiedades_form.php')">
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
            <?php 
                $aux=$consultas->consultarDatos(array('cate_propiedad'), 'propiedades', 'GROUP BY cate_propiedad', '', '');
                $res=array();
                while($datos=$aux->fetch_row()){
                    array_push($res,$datos[0]);
                }
                //print_r($res);
                $consultas->DesplegableElegidoFijo('', 'grupo', $res);

             ?>
            
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'propiedades', '', '', ['15%', '30%', '15%', '15%', '15%', '15%']);

            ?>
        </div>
    </body>
    <script>
        window.menu = [];
        menu.push("<?php echo $res[0]?>");
        menu.push("<?php echo $res[1]?>");
        
        
        $grupo = $("#grupo");
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
                buscarTablaPanelesQ(campos, "", 'propiedades','id_remax', 'cate_propiedad', $value);
                $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"propiedades"'+", "+'"id_remax"'+", "+'"cate_propiedad"'+", '"+$value+"')");
            }
            else if ($value == 0){
                document.getElementById('buscador').value="";
                buscarTablaPanelesQ(campos, "", 'propiedades','id_remax', '', '');
                $buscador.attr("onkeyup", "buscarTablaPanelesQ(campos, this.value, "+'"propiedades"'+", "+'"id_remax"'+", '', '')");
            }

        });
        
    </script>
</html>
