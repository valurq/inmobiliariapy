<!DOCTYPE html>
<?php
    session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
    include("Parametros/verificarConexion.php");

    // DATOS
    $cabecera=['Código RE/MAX', 'Nombre', 'Moneda', 'Importe', 'Referencia', 'Fecha', 'Fec. Vencimiento'];
    $campos=['(SELECT id_remax FROM propiedades WHERE id = propiedades_id)', 'nombre', '(SELECT dsc_moneda FROM moneda WHERE id = moneda_id)', 'importe', 'referencia', 'fecha', 'fecha_vto'];

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

    <script>
        var campos = ['(SELECT id_remax FROM propiedades WHERE id = propiedades_id)', 'nombre', '(SELECT dsc_moneda FROM moneda WHERE id = moneda_id)', 'importe', 'referencia', 'fecha', 'fecha_vto'];
    </script>

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
            <input type="text" name="buscador" id="buscador" style="width: 25%;" placeholder="Buscar por código RE/MAX o por nombre" onkeyup="buscarTablaPanelesQ(campos, this.value ,'reservas','buscador', 'estado', 'PENDIENTE');">

            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:224px; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE RESERVAS</B></font>
            </div>

            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='reserva_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('reserva_form.php')">
            <input type="button" class="boton_panel" name="Eliminar" value="Dar de baja" onclick="popupC('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles', () => {cambiarEstado()})">
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'reservas', 'estado', 'PENDIENTE');

            ?>
        </div>
    </body>
    <script>
        function cambiarEstado() {
            var sel=document.getElementById('seleccionado').value;
               if((sel=="")||(sel==' ')||(sel==0)){
                   popup('Advertencia',"DEBE SELECCIONAR UN ELEMENTO PARA PODER DARLO DE BAJA");
               }else {
                   //metodo,url destino, nombre parametros y valores a enviar, nombre con el que recibe la consulta
                   $.post("Parametros/modificarDatos.php", {campos: new Array('estado'), tabla: 'reservas', valores: new Array('INACTIVO'), campoCondicion: 'id', valorCondicion: sel}, function(msg) {
                       console.log(msg);
                       if(msg==0){
                           document.getElementById('seleccionado').value="";
                           location.reload();
                       }else{
                           popup('Error',"ERROR EN DAR DE BAJA EL REGISTRO");
                       }
                    });
               }
            }
    </script>
</html>
