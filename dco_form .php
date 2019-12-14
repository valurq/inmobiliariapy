<!DOCTYPE HTML>
<html>
<head>
    <?php
        /*
        SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
        ========================================================================
        */
        session_start();
        include("Parametros/conexion.php");
        $inserta_Datos= new Consultas();
        include("Parametros/verificarConexion.php");
        $id="";
    ?>

    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>
    <style media="screen">
        .visible{
            display:block;
        }
        .invisible{
            display:none;
        }
    </style>
</head>
<body style="background-color:white">
  <h2>Documento de Cierre de Operacion (D.C.O.) - Ventas</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->

<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <a id="datosGrales"  onclick="cambiarVista(1)"><h3 id="tituloDG">&#x25B6; Datos Generales</h3></a><hr>
  <div id="cabecera-operacion" class="">
      <table class="tabla-fomulario">
        <tbody>
          <tr>
            <td><label for="">Fecha</label></td>
            <td><input type="date" name="fecha" id="fecha" value="" placeholder="Ingrese el nombre de la oficina" class="campos-ingreso"></td>
            <td><label for="">Propiedad</label></td>
            <td>
                <input list="id_propiedades" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscarLista(['id_remax'], this.value,'propiedades', 'id_remax', 'id_propiedades', 'idPropiedad')" >
                <datalist id="id_propiedades">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idPropiedad" id="idPropiedad">
            </td>
          </tr>
          <tr >
            <td><label for="">Nombre Oficina</label></td>
            <td>
                <input list="oficina" id="dscOficina" name="dscOficina" autocomplete="off" onkeyup="buscarListaQ(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'oficina', 'idOficina','estado','ACTIVO')" >
                <datalist id="oficina">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idOficina" id="idOficina">
            </td>
            <td><label for="">Nombre Agente</label></td>
            <td>
                <input list="agente" id="dscVendedor" name="dscVendedor" autocomplete="off" onkeyup="buscarListaQ(['dsc_vendedor'], this.value,'vendedor', 'dsc_vendedor', 'agente', 'idVendedor','oficina_id',document.getElementById('idOficina').value)" >
                <datalist id="agente">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idVendedor" id="idVendedor">
            </td>
          </tr>
          <tr>
              <td>Tipo de Operacion</td>
              <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[1],'tipoOperacion',array('Individual','Compartida','Otro'))?></td>
          </tr>

          <tr  id="detallesVendedor" >
              <td><label for="">Nombre Oficina</label></td>
              <td>
                  <input list="oficinaC" id="dscOficinaC" name="dscOficinaC" autocomplete="off" onkeyup="buscarLista(['dsc_oficina'], this.value,'dco', 'dsc_oficina', 'oficinaC', 'idOficina')" >
                  <datalist id="oficinaC">
                    <option value=""></option>
                  </datalist>
                  <input type="hidden" name="idOficinaC" id="idOficinaC">
              </td>
              <td><label for="">Nombre Agente</label></td>
              <td>
                  <input list="agente" id="dscAgenteC" name="dscAgenteC" autocomplete="off" onkeyup="buscarListaQ(['dsc_vendedor'], this.value,'vendedor', 'dsc_vendedor', 'agente', 'idVendedor','oficina_id',document.getElementById('idOficinaC').value)" >
                  <datalist id="agente">
                    <option value=""></option>
                  </datalist>
                  <input type="hidden" name="idVendedorC" id="idVendedorC">
              </td>
        </tr>
        <tr>
            <td colspan="4">
                <table id="tablaVendedor">

                </table>
            </td>
        </tr>
        </tbody>
      </table>
  </div>
  <a id="detalleOperacion" onclick="cambiarVista(2)"><h3 id='tituloDO'>&#x25B6; Detalle de operación</h3><hr></a>
  <div id="detalle-operacion">

      <table class="tabla-fomulario">
        <tbody>
            <tr>
                <td><h4>Datos Cliente Vendedor o Propietario</h4></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Nombre y apellido/Razon Social</td>
                <td><input list="propietario" id="propietarioL" name="propietarioL" autocomplete="off" onkeyup="buscarLista(['dsc_cliente'], this.value,'cliente', 'dsc_cliente', 'propietario', 'idPropietario')" >
                <datalist id="propietario">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idPropietario" id="idPropietario">
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td>C.I. / R.U.C. </td>
                <td> <input type="text" name="idPropietario" id="idPropietario" value="" class="campos-ingreso"> </td>
            </tr>
            <tr>
                <td><h4>Datos Cliente Comprador</h4></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Nombre y apellido/Razon Social</td>
                <td>
                    <input list="comprador" id="compradorL" name="compradorL" autocomplete="off" onkeyup="buscarLista(['dsc_cliente'], this.value,'cliente', 'dsc_cliente', 'comprador', 'idComprador')" >
                    <datalist id="comprador">
                        <option value=""></option>
                    </datalist>
                    <input type="hidden" name="idComprador" id="idComprador" value="">
                </td>
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td>C.I. / R.U.C. </td>
                <td> <input type="text" name="idPropietario" id="idPropietario" value="" class="campos-ingreso"> </td>
            </tr>
            <tr>
                <td><h4>Pago</h4></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><label for="">Moneda</label></td>
                <td><?php
                if(!(count($resultado)>0)){
                    $inserta_Datos->crearMenuDesplegable('moneda','id','dsc_moneda','moneda');
                }else{
                    $inserta_Datos->DesplegableElegido(@$resultado[3],'moneda','id','dsc_moneda','moneda');
                }?>
                </td>
                <td>Forma de pago</td>
                <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[1],'fPago',array('Financiado','Otro'))?></td>
            </tr>
            <tr>
                <td><h4>Datos Inmueble</h4></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Finca o Cta. Cte. N.</td>
                <td><input type="text" name="nCtaCte" id="nCtaCte" value="" placeholder="Ingrese numero de Finca o Cta. Cte." class="campos-ingreso"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><label for="">Tipo Propiedad</label></td>
                <td> <input type="text" name="tipoPropiedad" id='tipoPropiedad' value=""class='campos-ingreso' readonly> </td>
                <td><label for="">Ciudad</label></td>
                <td>
                    <?php
                    if(!(count($resultado)>0)){
                        $inserta_Datos->crearMenuDesplegable('ciudad','id','dsc_ciudad','ciudad');
                    }else{
                        $inserta_Datos->DesplegableElegido(@$resultado[3],'ciudad','id','dsc_ciudad','ciudad');
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><h4>Condiciones de Precio de Venta y comisión</h4></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Precio Final</td>
                <td> <input type="number" name="precioFinal" id="precioFinal" value="" placeholder="Ingrese el precio final" class="campos-ingreso" > </td>
                <td>Porcentaje</td>
                <td> <input type="text" name="porcentaje" id="porcentaje" value="" placeholder="Ingrese el porcentaje" class="campos-ingreso" > </td>
            </tr>
            <tr>
                <td>Reserva</td>
                <td> <input type="number" name="reserva" id="reserva" value="" placeholder="Ingrese el precio final" class="campos-ingreso"> </td>
                <td>Fecha de reserva</td>
                <td> <input type="date" name="fReserva" id="fReserva" value="" placeholder="Ingrese el porcentaje" class="campos-ingreso"> </td>
            </tr>
            <tr>
                <td>Comision</td>
                <td> <input type="number" name="comision" id="comision" value="" placeholder="Ingrese el precio final" class="campos-ingreso" readonly> </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Saldo</td>
                <td> <input type="number" name="saldo" id="saldo" value="" placeholder="Ingrese el precio final" class="campos-ingreso" readonly> </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
      </table>
  </div>
  <a id="distribucionIngreso" onclick="cambiarVista(3)"><h3 id="tituloDI">&#x25B6; Distribución de ingresos</h3><hr></a>
  <div id="distribucion-operacion" class="">
      <table class="tabla-fomulario" border="1" style="font-size:12pt;font-family:Arial">
        <tbody>
          <tr>
            <td style="width:700px;"><label for="">Precio Venta</label></td>
            <td><input type="text" name="pVenta" id="pVenta" value="" placeholder="Ingrese el precio de Venta" style="width:300px;"></td>


          </tr>
          <tr>
            <td style="width:700px;"><label for="">Comision Inmobiliaria</label></td>
            <td><input type="text" name="cInmobiliaria" id="cInmobiliaria" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

          </tr>
          <tr>
            <td style="width:700px;"><label for="">Comision Compartida oficina 1</label></td>
            <td><input type="text" name="cInmobiliaria" id="cInmobiliaria" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

          </tr>
          <tr>
            <td style="width:700px;"><label for="">Comision Compartida oficina 2</label></td>
            <td><input type="text" name="cInmobiliaria" id="cInmobiliaria" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
            <td style="width:200px;"><label for="">Cheque</label></td>
            <td> <input type="checkbox" name="cheque" value=""> </td>
            <td style="width:300px;"><label for="">Transferencia</label></td>
            <td> <input type="checkbox" name="" value=""> </td>
            <td style="width:200px;"><label for="">Banco</label></td>
            <td> <input type="text" name="" value="" style="width:100px;"> </td>
            <td style="width:300px;"><label for="">Cuenta N.</label></td>
            <td> <input type="text" name="" value="" style="width:100px;"> </td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="">Menos Fee Regional Com.Oficina 1</label></td>
            <td><input type="text" name="cInmobiliaria" id="cInmobiliaria" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
            <td style="width:200px;"><label for="">Cheque</label></td>
            <td> <input type="checkbox" name="cheque" value=""> </td>
            <td style="width:300px;"><label for="">Transferencia</label></td>
            <td> <input type="checkbox" name="" value=""> </td>
            <td style="width:200px;"><label for="">Banco</label></td>
            <td> <input type="text" name="" value="" style="width:100px;"> </td>
            <td style="width:300px;"><label for="">Cuenta N.</label></td>
            <td> <input type="text" name="" value="" style="width:100px;"> </td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="">Neto Comisión oficina 1</label></td>
            <td><input type="text" name="cInmobiliaria" id="cInmobiliaria" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

          </tr>
          <tr>
            <td style="width:700px;"><label for="">Comision agente 1</label></td>
            <td><input type="text" name="cInmobiliaria" id="cInmobiliaria" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
            <td style="width:200px;"><label for="">Cheque</label></td>
            <td> <input type="checkbox" name="cheque" value=""> </td>
            <td style="width:300px;"><label for="">Transferencia</label></td>
            <td> <input type="checkbox" name="" value=""> </td>
            <td style="width:200px;"><label for="">Banco</label></td>
            <td> <input type="text" name="" value="" style="width:100px;"> </td>
            <td style="width:300px;"><label for="">Cuenta N.</label></td>
            <td> <input type="text" name="" value="" style="width:100px;"> </td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="">Comision agente 2s</label></td>
            <td><input type="text" name="cInmobiliaria" id="cInmobiliaria" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
            <td style="width:200px;"><label for="">Cheque</label></td>
            <td> <input type="checkbox" name="cheque" value=""> </td>
            <td style="width:300px;"><label for="">Transferencia</label></td>
            <td> <input type="checkbox" name="" value=""> </td>
            <td style="width:200px;"><label for="">Banco</label></td>
            <td> <input type="text" name="" value="" style="width:100px;"> </td>
            <td style="width:300px;"><label for="">Cuenta N.</label></td>
            <td> <input type="text" name="" value="" style="width:100px;"> </td>
          </tr>
        </tbody>
      </table>
  </div>

<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='oficina_panel.php';"  class="boton-formulario">
</form>


</body>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
    function verificar(){
        if($("#oficina").val()==""){
            popup('Advertencia','Es necesario ingresar el nombre de la oficina!!') ;
            return false ;
        }else if($("#direccion").val()==""){
            popup('Advertencia','Es necesario ingresar la direccion!!') ;
            return false ;
        }else if($("#email").val()==""){
            popup('Advertencia','Es necesario ingresar el correo electronico!!') ;
            return false ;
        }
    }
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0,10);
    });
    function inicializar(){
        document.getElementById('fecha').value=(new Date().toDateInputValue());
        $("#detallesVendedor").hide();
        $("#tipoOperacion").on("change",function (){cambiar()});
        $("#propiedades").on("keydown",function (e){cargarDatosPropiedades(e.keyCode)});
        $("#dscOficina").on("keydown",function(e){seleccionarOficina(e.keyCode) });
        $("#reserva").on("keyup",function (){actualizarMontos()});
        $("#porcentaje").on("keyup",function (){actualizarMontos()});
        $("#precioFinal").on("keyup",function (){actualizarMontos()});
    }
    $(document).ready( function() {
        inicializar();
        $("#cabecera-operacion").css("display","none");
        $("#detalle-operacion").css("display","none");
        $("#distribucion-operacion").css("display","none");

    });
    function cambiar(){
        switch ($("#tipoOperacion").val().toUpperCase()) {
            case "COMPARTIDA":
                $("#detallesVendedor").show();
                $("#dscOficinaC").attr("readonly","");

                break;
            case "INDIVIDUAL":
                $("#detallesVendedor").hide();

                break;
            case "OTRO":
                $("#detallesVendedor").show();
                $("#dscOficinaC").removeAttr("readonly","");
                break;
            default:
        }
        seleccionarOficina(9);
    }
    function cambiarVista(valor){
        console.log("test"+valor);
        switch (valor) {
            case 1:
                $("#tituloDG").html("&#x25BC; Datos Generales");
                //$("#cabecera-operacion").css("display","");
                $("#cabecera-operacion").fadeIn("500");
                $("#tituloDO").html("&#x25B6; Detalle de operación");
                $("#detalle-operacion").fadeOut("fast");
                $("#tituloDI").html("&#x25B6; Distribución de ingresos");
                $("#distribucion-operacion").fadeOut("fast");
                break;
            case 2:
                $("#tituloDO").html("&#x25BC; Detalle de operación");
                $("#detalle-operacion").fadeIn("500");
                $("#tituloDG").html("&#x25B6; Datos Generales");
                $("#cabecera-operacion").fadeOut("fast");
                $("#tituloDI").html("&#x25B6; Distribución de ingresos");
                $("#distribucion-operacion").fadeOut("fast");
                break;
            case 3:
                $("#tituloDI").html("&#x25BC; Distribución de ingresos");
                $("#distribucion-operacion").fadeIn("500");
                $("#tituloDG").html("&#x25B6; Datos Generales");
                $("#cabecera-operacion").fadeOut("fast");
                $("#tituloDO").html("&#x25B6; Detalle de operación");
                $("#detalle-operacion").fadeOut("fast");
                break;
            default:

        }
    }
    function cargarDatosPropiedades(e){
        if(e==9){
            var idProp=$("#idPropiedad").val();
            var res=obtenerDatos(['precio','cate_propiedad','Finca_ccctral','ciudad_id'],'propiedades','id',idProp);
            $("#reserva").val("0");
            $("#nCtaCte").val(res[2]);
            $("#tipoPropiedad").val(res[1]);
            $("#precioFinal").val(res[0]);
            $("#pVenta").val(res[0]);
            $("#ciudad option").map(function (){
                if ($(this).val() == res[3]) return this;}).attr('selected', 'selected');
            var porcentaje=obtenerDatos(['vta_comision'],'parametros','','','ORDER BY fecreacion DESC');
            console.log(porcentaje);
            $("#porcentaje").val(porcentaje[0]);
            actualizarMontos();
        }
    }
    function seleccionarOficina(e){
        if(e==9){
            $("#idOficinaC").val($("#idOficina").val());
            $("#dscOficinaC").val($("#dscOficina").val());
        }
    }
    function actualizarMontos(){
        var pFinal=$("#precioFinal").val();
        var porc=$("#porcentaje").val()/100;
        var reservar=$("#reserva").val();
        $("#saldo").val(pFinal-reservar);
        $("#comision").val(pFinal*porc);
        $("#cInmobiliaria").val(pFinal*porc);
    }
  </script>

</html>
