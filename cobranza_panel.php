<?php
    session_start();
    include("Parametros/conexion.php");
    //include("Parametros/verificarConexion.php");
    $consultas=new Consultas();

    // ========================================================================
    //Seteo de cabecera y campos en el mismo orden para tomar de la $tabla
    // ========================================================================
    $moneda = "(SELECT simbolo FROM moneda mon WHERE moneda_id = mon.id )";
    $cabecera=['ID','Creación','Nro. Comprob','Monto','Forma de Pago','Moneda'];
    $campos=['id','fecha','nro_comprob','monto','forma_pago',$moneda];

    //recibimos el id del cobor
    $cobro_alquiler_id = $_POST['seleccionado'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
      <title>Pagos de Cobro de Alquiler</title>
      <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/paneles.css">
      <script src="JS/jquery-3.4.0.js"></script>
      <script src="JS/funciones.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script type="text/javascript">
         // para busqueda en paneles, es decir, los campos mostrados postumos a una busqueda
         var moneda = "(SELECT simbolo FROM moneda mon WHERE moneda_id = mon.id )";
         var campos=['id','fecha','nro_comprob','monto','forma_pago',moneda];
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
            <input type="hidden" name="id_cobro" id="id_cobro" value="<?php echo $cobro_alquiler_id; ?>">
        </form>
      <!--============================================================================= -->

     <div class="menu-panel" >
        <br><br>
        <!---TITULO DEL PANEL-->
        <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:540px; height:22px; z-index:1">
            <font color="#808080" class="ws12"><B>PANEL DE PAGOS DE COBRO DE ALQUILER</B></font>
        </div>
        <div class="row mb-3">
            <!--FILTROS DEL PANEL-->   
            <div class="col-sm-5">        
                <label for="dsc_cliente">Nro. Comprobante:</label>     
                <input class="form-control form-control-sm" type="text" name="nro_comprob" id="nro_comprob" onkeyup="buscar();">
            </div>
            <div class="col-sm-5">        
                <label for="dsc_cliente">Fecha de Pago:</label>     
                <input class="form-control form-control-sm" type="date" name="fecha" id="fecha" onkeyup="buscar();" onchange="buscar();">
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
                <input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminarCobranza();">
                <input type="button" class="boton_panel" name="Volver" onclick = "location='cobros_alquiler_panel.php';"  value="Volver">
            </div>
        </div>
    </div>

        <div class="mostrar-tabla">
            <?php  $consultas->crearTabla($cabecera,$campos,'cobranza','cobros_alquiler_id',$cobro_alquiler_id); ?>
        </div>
    </body>
     
    <script>
        function buscar(retorno = ""){
            if(retorno == ""){
                //Inicializacion de Variables{
                    var where = "WHERE";
                    var c = 0;
                    var fecha = document.getElementById("fecha");
                    var nro_comprob = document.getElementById("nro_comprob");
                    var id_cobro = document.getElementById("id_cobro");
                //}

                //Formacion de la clausula where{
                    where += " cobros_alquiler_id = "+id_cobro.value+""

                    if(nro_comprob.value.length >= 0){ //esto ya sobra pero bue
                        where += " AND nro_comprob LIKE '%"+nro_comprob.value+"%'";
                        c++;
                    }     

                    if(fecha.value != ""){
                        if(c==0){
                            where += " fecha = '"+fecha.value+"'";
                        }else{
                            where += " AND fecha = '"+fecha.value+"'";
                        }
                        c++;
                    }
                //}

                buscarTablaPanelesCustom(campos,'cobranza',where,buscar);
            }else{
                formatear_campos();
            }
        }

        function limpiarFiltros(){
            var fecha = document.getElementById("fecha");
            var nro_comprob = document.getElementById("nro_comprob");

            fecha.value = "";
            nro_comprob.value = "";

            buscar();
        }

        function eliminarCobranza(retorno = ""){
            var id_cobro = document.getElementById("id_cobro");
            var id_pago = document.getElementById("seleccionado");
            var c = 1;
            if(id_pago == "0"){
                popup("Error","Seleccione la conbranza a eliminar");
                return false;
            }
            if(retorno == ""){
                var saldo = "(SELECT saldo FROM cobros_alquiler ca WHERE ca.id = "+id_cobro.value+")";
                var campos = ["monto",saldo,'cotizacion'];
                var where = " WHERE id = "+id_pago.value;
                busquedaLibre(campos, "cobranza", where, eliminarCobranza);
            }else{
                if(retorno.length>1){
                    var monto = parseFloat(retorno[1][1]); //monto del pago
                    var saldo = parseFloat(retorno[1][2]); //saldo del cobro
                    var cotiz = parseFloat(retorno[1][3]); //cotizacion del pago
                    var campos = [];
                    var valores = [];
                    var nuevo_saldo = saldo + monto*cotiz;

                    /*console.log(monto);
                    console.log(saldo);
                    console.log(cotiz);
                    console.log(nuevo_saldo);*/

                    if(saldo == 0){
                        campos = ['saldo','estado'];
                        valores = [nuevo_saldo,"Pendiente"];
                    }else{
                        campos = ['saldo'];
                        valores = [nuevo_saldo];
                    }

                    /*console.log(campos);
                    console.log(valores);*/
                    
                    $.post("Parametros/modificarDatos.php",
                        { tabla: "cobros_alquiler" ,campos:campos, valores:valores,
                            valorCondicion:id_cobro.value, campoCondicion: "id" }, function(resultado) {
                            if(resultado=="0"){
                                eliminar('cobranza',"preventReload");
                                popup("Informacion","Pago eliminado, se ha actualizado el cobro");
                            }else{
                                popup("Informacion","No se puedo completar la operacion");
                            }
                            //window.location='cobros_alquiler_panel.php';
                            buscar();
                        }
                    );

                }else{
                    //popup("","No se pudo eliminar la cobranza");
                }
            }
      }

      function formatear_campos(){
            //aqui se usan selectores css, el siguiente selector es para seleccionar el quinto 
            //y el cuarto td que se encuentra bajo el tr
            var campos = document.querySelectorAll("td:nth-child(5),td:nth-child(4)");
            var size = campos.length;
            $(campos).each(function(){
               //el valor de cada celda es equivalente al contenido entre los tags <td></td>
               var value = this.innerHTML;
               if(!isNaN(value)){
                 this.innerHTML=nfor(value);
               }
               
            });
        }
        formatear_campos();

    </script>

</html>
