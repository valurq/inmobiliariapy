<?php
    session_start();
    include("Parametros/conexion.php");
    //include("Parametros/verificarConexion.php");
    $consultas=new Consultas();

    // ========================================================================
    //Seteo de cabecera y campos en el mismo orden para tomar de la $tabla
    // ========================================================================
    $cabecera=['ID','Creación','Vencimiento','ID Propiedad','Monto','Saldo','Estado'];
    $campos=['id','fecha','fe_vto','id_remax','monto','saldo','estado'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
      <title>Cobro de Alquileres</title>
      <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/paneles.css">
      <script src="JS/jquery-3.4.0.js"></script>
      <script src="JS/funciones.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script type="text/javascript">
         // para busqueda en paneles, es decir, los campos mostrados postumos a una busqueda
         var campos=['id','fecha','fe_vto','id_remax','monto','saldo','estado'];
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
            <!--Depende de este campo la diferenciacion entre "Ver" y "Cobrar", 
            en este contexto sus valores solo pueden ser "ver" o "cobrar"-->
            <input type="hidden" name="accion" id="accion" value="ver">
        </form>
      <!--============================================================================= -->

     <div class="menu-panel" >
         <div id="resultadoBusqueda">
        <br><br>
        <!---TITULO DEL PANEL-->
        <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:540px; height:22px; z-index:1">
            <font color="#808080" class="ws12"><B>PANEL DE COBROS DE ALQUILER</B></font>
        </div>
        <div class="row mb-3">
            <!--FILTROS DEL PANEL-->   
            <div class="col-sm-5">        
                <label for="dsc_cliente">ID Propiedad:</label>     
                <input class="form-control form-control-sm" type="text" name="id_remax" id="id_remax" onkeyup="buscar();">
            </div>
            <div class="col-sm-5">        
                <label for="dsc_cliente">Fecha de Vencimiento:</label>     
                <input class="form-control form-control-sm" type="date" name="fe_vto" id="fe_vto" onkeyup="buscar();" onchange="buscar();">
            </div>
            <div class="col-sm-2">
                <div class="mb-3"></div>
                <button type="button" class="boton_panel" name="limpiar" id="limpiar" onclick="limpiarFiltros();">
                  Limpiar Filtros
                </button>
            </div>
            <!--FIN FILTROS-->
        </div>
        <div class="row mb-3">
            <div class="col-sm-12 text-right">
                <!--ACCIONES DEL PANEL-->
                <input type="button" class="boton_panel" name="Cobrar" value="Cobrar" onclick="editar('cobros_alquiler_form.php','cobrar');">
                <input type="button" class="boton_panel" name="Ver Cobro" value="Ver" onclick="editar('cobros_alquiler_form.php','ver')">
                <input type="button" class="boton_panel" name="Ver Pagos" value="Ver Pagos" onclick="editar('cobranza_panel.php')">
                <input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="popup('Informacion','No se permite eliminar cobros')">
            </div>
        </div>
    </div>

        <div class="mostrar-tabla">
            <?php  $consultas->crearTabla($cabecera,$campos,'v_cobrosalquiler_propiedades','','',['*'],'assoc');?>
        </div>
    </body>
     
    <script>
        function buscar(){
            //Inicializacion de Variables{
                var where = "WHERE";
                var c = 0;
                var id_remax = document.getElementById("id_remax");
                var fe_vto = document.getElementById("fe_vto");
            //}

            //Formacion de la clausula where{
                if(id_remax.value.length >= 0){ //esto ya sobra pero bue
                    where += " id_remax LIKE '%"+id_remax.value+"%'";
                    c++;
                }     

                if(fe_vto.value != ""){
                    if(c==0){
                        where += " fe_vto = '"+fe_vto.value+"'";
                    }else{
                        where += " AND fe_vto = '"+fe_vto.value+"'";
                    }
                    c++;
                }
            //}

            //Depuracion{
                //alert("Desde: "+fecha_desde.value+" Hasta: "+fecha_hasta.value+" Tipo: "+tipo.value);
                //console.log(where);
            //}
            
            buscarTablaPanelesCustom(campos,'v_cobrosalquiler_propiedades',where);

        }

        function limpiarFiltros(){
            var id_remax = document.getElementById("id_remax");
            var fe_vto = document.getElementById("fe_vto");

            id_remax.value = "";
            fe_vto.value = "";

            buscar();
        }

        function formatear_campos(){
            //aqui se usan selectores css, en palabras estos selectores serian como seleccionar todas 
            //las id  monto_* y saldo_*
            var campos = document.querySelectorAll("[id*='monto_'],[id*='saldo_']");
            var size = campos.length;
            $(campos).each(function(){
               //el valor de cada celda es equivalente al contenido entre los tags <td></td>
               var value = this.innerHTML;
               this.innerHTML=nfor(value);
            });
        }
        formatear_campos();

        

    </script>

</html>
