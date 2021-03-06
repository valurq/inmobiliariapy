<!DOCTYPE html>
<?php
  session_start();
      include("Parametros/conexion.php");
      $consultas= new Consultas();
      include("Parametros/verificarConexion.php");

  // DATOS
  $cabecera=['Oficina', 'Ciudad', 'RUC', 'Email', 'Tipo'];
  $campos=['id','dsc_oficina', '(SELECT dsc_ciudad FROM ciudad WHERE id = ciudad_id)', 'ruc', 'mail', 'tipo'];


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
            var campos=['dsc_oficina', '(SELECT dsc_ciudad FROM ciudad WHERE id = ciudad_id)', 'ruc', 'mail', 'tipo'];
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
            <!-- oficina: la tabla, dsc_oficina: el campo a buscar -->
            <input type="text" name="buscador" id="buscador" placeholder="Buscar por oficina" onkeyup="buscarTablaPanelesQ(campos, this.value ,'oficina','dsc_oficina', ['estado','tipo'], ['ACTIVO','OTROS'])">

            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:224px; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE OFICINAS</B></font>
            </div>

            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='inmobiliaria_externa_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('inmobiliaria_externa_form.php')">
            <input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick='cambiarEstado()'>
        </div>

        <div class="mostrar-tabla" >
          <table id='tablaPanel' cellspacing='0' style='width:100%'>
            <?php
              $consulta->crearCabeceraTabla($cabecera);
              $datos=$consulta->consultarDatosQ($campos,'oficina','',['estado','tipo'],['ACTIVO','OTROS']);
              $consulta->crearContenidoTabla($datos);
             //$consultas->crearTabla($cabecera,$campos,'oficina', 'estado', 'ACTIVO');

            ?>
          </table>
        </div>

        <script type="text/javascript">
            function cambiarEstado() {
            var sel=document.getElementById('seleccionado').value;
               if((sel=="")||(sel==' ')||(sel==0)){
                   popup('Advertencia',"DEBE SELECCIONAR UN ELEMENTO PARA PODER ELIMINARLO");
               }else {
                   //metodo,url destino, nombre parametros y valores a enviar, nombre con el que recibe la consulta
                   $.post("Parametros/modificarDatos.php", {campos: new Array('estado'), tabla: 'oficina', valores: new Array('INACTIVO'), campoCondicion: 'id', valorCondicion: sel}, function(msg) {
                       console.log(msg);
                       if(msg==0){
                           document.getElementById('seleccionado').value="";
                           location.reload();
                       }else{
                           popup('Error',"ERROR EN LA ELIMINACION DEL REGISTRO");
                       }
                    });
               }
            }

            function buscarTablaPaneles(camposResultado,valor,tabla,campo) {
                $.post("Parametros/buscador.php", {camposResultado: camposResultado ,dato:valor,tabla:tabla,campoBusqueda:campo, campoCondicion: new Array('estado'), valorCondicion: new Array('ACTIVO')}, function(resultado) {
                    //$("#resultadoBusqueda").html(resultado);
                    var i;
                    //console.log(resultado);
                    $("#datosPanel tr").remove();
                    resultado=JSON.parse(resultado);
                    for(i=1 ; i<resultado.length;i++){
                        cargarTabla(resultado[i],"datosPanel");
                    }
                 });
            }


        </script>
    </body>

</html>
