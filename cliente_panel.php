<?php
    session_start();
    include("Parametros/conexion.php");
    //include("Parametros/verificarConexion.php");
    $consultas=new Consultas();

    // ========================================================================
    //Seteo de cabecera y campos en el mismo orden para tomar de la $tabla
    // ========================================================================
    $cabecera=['ID','Descripción Cliente','Correo Electrónico','Teléfono','C.I / R.U.C','Fecha Creación'];
    $campos=['id','dsc_cliente','mail','telefono1','ci_ruc','fecreacion'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
      <title>Clientes</title>
      <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/paneles.css">
      <script src="JS/jquery-3.4.0.js"></script>
      <script src="JS/funciones.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script type="text/javascript">
         // para busqueda en paneles
         var campos=['id','dsc_cliente','mail','telefono1','ci_ruc','fecreacion'];
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
            <font color="#808080" class="ws12"><B>PANEL DE CLIENTES</B></font>
        </div>
        <div class="row mb-3">
            <!--FILTROS DEL PANEL-->   
            <div class="col-sm-12">        
                <label for="dsc_cliente">Buscar:</label>     
                <input class="form-control" type="text" name="dsc_cliente" id="dsc_cliente" onkeyup="buscar();">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-12 text-right">
                <!--ACCIONES DEL PANEL-->
                <input type="button" class="boton_panel" name="Nuevo" onclick = "location='cliente_form.php';"  value="Nuevo">
                <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('cliente_form.php')" >
                <input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('cliente')" >
            </div>
        </div>
    </div>

        <div class="mostrar-tabla">
            <?php  $consultas->crearTabla($cabecera,$campos,'cliente');?>
        </div>
    </body>
     
    <script>
        function buscar(){
            //Inicializacion de Variables{
                var where = "WHERE";
                var c = 0;
                var dsc_cliente = document.getElementById("dsc_cliente");
            //}

            //Formacion de la clausula where{
                if(dsc_cliente.value.length > 0){
                    where += " dsc_cliente LIKE '%"+dsc_cliente.value+"%'";
                    c++;
                }     
            //}

            //Depuracion{
                //alert("Desde: "+fecha_desde.value+" Hasta: "+fecha_hasta.value+" Tipo: "+tipo.value);
                //console.log(where);
            //}
            
            buscarTablaPanelesCustom(campos,'cliente',where);

        }

    </script>

</html>
