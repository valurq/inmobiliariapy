<!DOCTYPE html>
<?php
session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
    include("Parametros/verificarConexion.php");

// DATOS
$cabecera=['Moneda','Oficina', 'Vigencia', 'Pago adm.', '% de operación', 'Pago mkt.', 'Pago afiliación', 'Estado'];
$campos=['(SELECT dsc_moneda FROM moneda WHERE id = moneda_id)','(SELECT dsc_oficina FROM oficina WHERE id = oficina_id)', 'vigencia_hasta', 'fee_adm', 'fee_operaciones', 'fee_marketing', 'fee_afiliacion', 'estado'];

@$oficina=$_POST['idOfi'];
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

            <input type="button" class="boton_panel" name="Nuevo" value="Nuevo" onclick="document.getElementById('form_contrato').submit();" >
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('contrato2_form.php')">
           <!--  <input type="button" class="boton_panel" name="Eliminar" value="Eliminar"
            id="eliminarTest" onclick="popupC('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles',function (){eliminar('ciudad')},'ciudad')"> -->
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'contratos', 'oficina_id', @$oficina);

            ?>
        </div>
    </body>

</html>
