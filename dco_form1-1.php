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
        include("Parametros/verificarConexion.php");
        $consulta= new Consultas();
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
        body{
            font-family: Arial;
        }
        #popupReserva{
            background-color: white;
            width: 900px;
            height: 350px;
            position: fixed;
            left: 25%;
            top:25%;
            margin-top:-75px;
            margin-left: -200px;
            box-sizing: border-box;
            border:1px solid black;
            border-radius: 20px;
            z-index: 10;
            padding: 15px;
            padding-top: 30px;
        }
        .titulo-tabla{
            background-color: #668cff;
            font-family: Arial;
            font-size: 15px;
            font-style: normal;
            font-weight: bold;
            border-top: 1px solid black;
            border-bottom:  1px solid black;
        }
        .fila-reserva:nth-child(odd) {
            background-color:#d3d6da;
        }
        .fila-reserva:nth-child(even) {
            background-color:#ffffff;
        }
        .fila-form{
            background-color: #eeecea;
        }
        .columna-form{
            padding-left: 20px;
        }
    </style>
</head>
<body style="background-color:white">
  <h2>Documento de Cierre de Operacion (D.C.O.) - Ventas</h2>
  <h4><?php echo $_GET['tOp']?></h4>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->

    <form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
    <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
    <input type="hidden" name="tOperacion" id='tOperacion' value="<?php echo $_GET['tOp']?>">
    <a id="datosGrales"  onclick="cambiarVista(1)"><h3 id="tituloDG">&#x25B6; Datos Generales</h3></a><hr>
    <div id="cabecera-operacion" class="">
      <table cellspacing='0' class="tabla-fomulario" >
        <tbody>
          <tr >
            <td class="columna-form"><label for="">Fecha</label></td>
            <td>
                <input autocomplete="off" type="date" name="fecha" id="fecha" value="" placeholder="Ingrese el nombre de la oficina" class="campos-ingreso"></td>
            <td class="columna-form"><label for="">Propiedad</label></td>
            <td>
                <input autocomplete="off" list="id_propiedades" id="propiedades" name="propiedades" autocomplete="off" >
                <!-- onkeyup="buscarListaQ(['id_remax'], this.value,'propiedades', 'id_remax', 'id_propiedades', 'idPropiedad','LIMIT 10')"  -->
                <datalist id="id_propiedades">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="text" name="idPropiedad" id="idPropiedad">
            </td>
          </tr>
          <tr ><td colspan="4"><h4 id='captadorTitu'>Captador</h4></td></tr>
          <tr>
            <td class="columna-form"><label for="">Nombre Oficina</label></td>
            <td>
                <input autocomplete="off" list="oficinaC" id="dscOficinaC" name="dscOficinaC" autocomplete="off" onkeyup="buscarListaQ(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'oficinaC', 'idOficinaC','estado','ACTIVO')" readonly >
                <datalist id="oficinaC">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idOficinaC" id="idOficinaC">
            </td>
            <td class="columna-form"><label for="">Nombre Agente</label></td>
            <td>
                <input autocomplete="off" list="agenteC" id="dscVendedorC" name="dscVendedorC" autocomplete="off" onkeyup="buscarListaQ(['dsc_vendedor'], this.value,'vendedor', 'dsc_vendedor', 'agenteC', 'idVendedorC','oficina_id',document.getElementById('idOficinaC').value)" readonly>
                <datalist id="agenteC">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idVendedorC" id="idVendedorC">
            </td>
          </tr>
        <tr ><td colspan="4"><h4 id='vendedorTitu'>Vendedor</h4></td></tr>
          <tr id='contenedor-vendedor'>
            <td class="columna-form"><label for="">Nombre Oficina</label></td>
            <td>
                <input autocomplete="off" list="oficinaV" id="dscOficinaV" name="dscOficinaV" autocomplete="off" onkeyup="buscarListaQ(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'oficinaV', 'idOficinaV','estado','ACTIVO')" >
                <datalist id="oficinaV">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idOficinaV" id="idOficinaV">
            </td>
            <td class="columna-form"><label for="">Nombre Agente</label></td>
            <td>
                <input autocomplete="off" list="agenteV" id="dscVendedorV" name="dscVendedorV" autocomplete="off" onkeyup="buscarListaQ(['dsc_vendedor'], this.value,'vendedor', 'dsc_vendedor', 'agenteV', 'idVendedorV','oficina_id',document.getElementById('idOficinaV').value)" >
                <datalist id="agenteV">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idVendedorV" id="idVendedorV">
            </td>
          </tr>
          <tr ><td colspan="4"><h4 id='referidoTitu'>Referido</h4></td></tr>
          <tr id='contenedor-referido'>
            <td class="columna-form"><label for="">Nombre Oficina</label></td>
            <td>
                <input autocomplete="off" list="oficinaR" id="dscOficinaR" name="dscOficinaR" autocomplete="off" onkeyup="buscarListaQ(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'oficinaR', 'idOficinaR','estado','ACTIVO')" >
                <datalist id="oficinaR">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idOficinaR" id="idOficinaR">
            </td>
            <td class="columna-form"><label for="">Nombre Agente</label></td>
            <td>
                <input autocomplete="off" list="agenteR" id="dscVendedorR" name="dscVendedorR" autocomplete="off" onkeyup="buscarListaQ(['dsc_vendedor'], this.value,'vendedor', 'dsc_vendedor', 'agenteR', 'idVendedorR','oficina_id',document.getElementById('idOficinaR').value);" >
                <datalist id="agenteR">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idVendedorR" id="idVendedorR">
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <a id="detalleOperacion" onclick="cambiarVista(2)"><h3 id='tituloDO'>&#x25B6; Detalle de operación</h3><hr></a>
    <div id="detalle-operacion">
      <table cellspacing='0' class="tabla-fomulario">
        <tbody>
            <tr class="fila-form"><td colspan="4"><h4>Datos de Propietario</h4></td></tr>
            <tr class="fila-form">
                <td class="columna-form">Nombre</td>
                <td><input id="propietarioL" name="propietarioL" autocomplete="off" class="campos-ingreso" >
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td class="columna-form">C.I. / R.U.C. </td>
                <td> <input autocomplete="off" type="text" name="ciPropietario" id="ciPropietario" value="" class="campos-ingreso"> </td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Apellido</td>
                <td><input id="propietarioApellido" name="propietarioApellido" autocomplete="off" class='campos-ingreso' >
                <td class="columna-form">Correo </td>
                <td> <input autocomplete="off" type="text" name="propietarioCorreo" id="propietarioCorreo" value="" class="campos-ingreso"> </td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Telefono</td>
                <td><input autocomplete="off" id="propietarioTelefono" name="propietarioTelefono" autocomplete="off" class="campos-ingreso">
                <td class="columna-form">Direccion</td>
                <td><input autocomplete="off" id="propietarioDireccion" name="propietarioDireccion" autocomplete="off" class="campos-ingreso" >

            </tr>
            <tr class="fila-form">
                <td class="columna-form">Nro. Factura</td>
                <td><input autocomplete="off" type="number" name="nFacturaCliente" id="nFacturaCliente" value="" class="campos-ingreso"></td>
                <td></td>
                <td></td>
            </tr>
            <tr><td colspan="4"><h4>Datos Cliente Comprador</h4></td>
            </tr>
            <tr>
                <td class="columna-form">Nombre y apellido/Razon Social</td>
                <td>
                    <input autocomplete="off" list="comprador" id="compradorL" name="compradorL" autocomplete="off" readonly >
                </td>
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td class="columna-form">C.I. / R.U.C. </td>
                <!-- Agregar nuevo cliente al presionar el boton -->
                <td width='600px;'> <input autocomplete="off" list='clienteC' type="text" name="ciComprador" id="ciComprador" value="" class="campos-ingreso" onkeyup="buscarListaQ(['ci_ruc'], this.value,'cliente', 'ci_ruc', 'clienteC', 'idComprador')">
                    <datalist id="clienteC">
                      <option value=""></option>
                    </datalist>
                <input autocomplete="off" type="hidden" name="idComprador" id="idComprador" value="">
                <input type="button" name="aggCliente"  value="Crear cliente" onclick="popupComprador()" style="margin-top: 0px;margin-left: 13px;width:146px;" class="boton-formulario"></td>
            </tr>
            <tr >
                <td class="columna-form">Telefono</td>
                <td><input autocomplete="off" list="propietario" id="telefonoC" name="telefonoC" autocomplete="off" onkeyup="buscarLista(['dsc_cliente'], this.value,'cliente', 'dsc_cliente', 'propietario', 'idPropietario')" readonly >
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td class="columna-form">Correo </td>
                <td> <input autocomplete="off" type="text" name="correoC" id="correoC" value="" class="campos-ingreso" readonly> </td>
            </tr>
            <tr >
                <td class="columna-form">Direccion</td>
                <td><input autocomplete="off" id="direccionC" name="direccionC" autocomplete="off" readonly>
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td class="columna-form"></td>
                <td></td>
            </tr>
            <tr class="fila-form"><td colspan="4"><h4>Pago</h4></td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form"><label for="">Moneda</label></td>
                <td><?php
                if(!(count(@$resultado)>0)){
                    $consulta->crearMenuDesplegable('moneda','id','dsc_moneda','moneda');
                }else{
                    $consulta->DesplegableElegido(@$resultado[3],'moneda','id','dsc_moneda','moneda');
                }?>
                </td>
                <td class="columna-form">Forma de pago</td>
                <td><?php $consulta->crearMenuDesplegable('fPago','id','dsc_medio','forma_pago')?></td>

            </tr>
            <tr class="fila-form">
                <td></td>
                <td></td>
                <td class="columna-form">Banco</td>
                <td> <input autocomplete="off" type="number" name="nBancoC" id="nBancoC" value="" placeholder="Ingrese el Banco" class="campos-ingreso" readonly> </td>
            </tr>
            <tr class="fila-form">
                <td></td>
                <td></td>
                <td class="columna-form">N. Cheque</td>
                <td> <input autocomplete="off" type="number" name="nChequeC" id="nChequeC" value="" placeholder="Ingrese el Banco" class="campos-ingreso" readonly> </td>
            </tr>
            <tr><td colspan="4"><h4>Datos Inmueble</h4></td></tr>
            <tr>
                <td class="columna-form">Finca o Cta. Cte. N.</td>
                <td><input autocomplete="off" type="text" name="nCtaCte" id="nCtaCte" value="" placeholder="Ingrese numero de Finca o Cta. Cte." class="campos-ingreso"></td>
                <td class="columna-form"> <label for="">Distrito</label></td>
                <td> <input autocomplete="off" type="text" name="distrito" id='distrito' value=""class='campos-ingreso' > </td>
                <!-- se debe estirar datos de la tabla de propiedades -->
            </tr>
            <tr>
                <td class="columna-form"> <label for="">Tipo Propiedad</label></td>
                <td> <input autocomplete="off" type="text" name="tipoPropiedad" id='tipoPropiedad' value=""class='campos-ingreso' readonly> </td>
                <td class="columna-form"><label for="">Ciudad</label></td>
                <td><input autocomplete="off" type="text" name="ciudad" id='ciudad' value=""class='campos-ingreso' readonly></td>
            <tr class="fila-form"><td colspan="4"><h4>Condiciones de Precio de Venta y comisión</h4></td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Valor Propiedad</td>
                <td> <input autocomplete="off" type="text" name="valorPropiedad" id="valorPropiedad" value="" class="campos-ingreso"   readonly> </td>
                <td class="columna-form">Comision Adicional</td>
                <td> <input autocomplete="off" type="text" name="comisionAdicional" id="comisionAdicional" value=""  class="campos-ingreso" readonly> </td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form"> Precio Final</td>
                <td> <input  autocomplete="off" type="text" name="precioFinal" id="precioFinal" value="" data-type='currency' onkeyup="formatoMoneda($(this))" onblur="formatoMoneda($(this),blur)" placeholder="Ingrese el precio final" class="campos-ingreso"> </td>
                <td class="columna-form">Porcentaje</td>
                <td> <input autocomplete="off" type="text" name="porcentaje" id="porcentaje" value="" placeholder="Ingrese el porcentaje" class="campos-ingreso" readonly> </td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Reserva</td>
                <td> <input autocomplete="off" type="text" name="reserva" id="reserva" value="" placeholder="Ingrese el precio final" class="campos-ingreso" readonly> </td>
                <td><input autocomplete="off" type="button" value="Ver Reserva" class="boton-formulario" id='btAggReserva' style="margin-top: 0px;margin-left: 13px;width:146px;"onclick="abrirPopupReserva()"></td>
                <!-- Al presionar el boton, debe traer los datos de las reservas relacionadas a la propiedad -->
                <td></td>
            </tr>
            <tr class="fila-form" >
                <td class="columna-form">Comision</td>
                <td> <input autocomplete="off" type="text" name="comision" id="comision" value="" placeholder="Ingrese el precio final" class="campos-ingreso" readonly> </td>
                <td></td>
                <td></td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Saldo</td>
                <td> <input autocomplete="off" type="text" name="saldo" id="saldo" value="" placeholder="Ingrese el precio final" class="campos-ingreso" readonly> </td>
                <td></td>
                <td></td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Tener en cuenta que:</td>
                <td><?php
                        if(!(count(@$resultado)>0)){
                            $consulta->crearMenuDesplegable('condiciones','id','titulo','condiciones');
                        }else{
                            $consulta->DesplegableElegido(@$resultado[3],'condiciones','id','titulo','condiciones');
                        }
                    ?>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr class="fila-form">
                <td></td>
                <td colspan="3"> <textarea id="detalleCondiciones" class="campos-ingreso" style="width:80%;height:130px;"> </textarea> </td>
                <td></td>
                <td></td>
                <!-- 681 * 122 -->
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Medio de contacto</td>
                <td><?php
                        if(!(count(@$resultado)>0)){
                            $consulta->crearMenuDesplegable('medioContacto','id','medio','medio_contacto');
                        }else{
                            $consulta->DesplegableElegido("",'medioContacto','id','medio','medio_contacto');
                        }
                    ?>
                </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
      </table>
    </div>
    <a id="distribucionIngreso" onclick="cambiarVista(3)"><h3 id="tituloDI">&#x25B6; Distribución de ingresos</h3><hr></a>
    <div id="distribucion-operacion" class="">
      <table cellspacing='0' class="tabla-fomulario" id="tabla-distribucion-pagos" border="1" style="font-size:12pt;font-family:Arial">
        <tbody>
          <tr>
            <td style="width:700px;"><label for="">Precio Venta</label></td>
            <td><input readonly autocomplete="off" type="text" name="pVenta" id="pVenta" value="" placeholder="Ingrese el precio de Venta" style="width:300px;"></td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="">Comision Inmobiliaria</label></td>
            <td><input readonly autocomplete="off" type="text" name="cInmobiliaria" id="cInmobiliaria" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

          </tr>
          <tr>
              <td style="width:700px;"><label for="" id='feeOfi1'>Menos Fee Regional Com.Oficina 1</label></td>
              <td><input readonly autocomplete="off" type="text" name="feeRegional1" id="feeRegional1" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionOfi1'>Comision neto oficina 1</label></td>
            <td><input readonly autocomplete="off" type="text" name="cInmobiliariaNeto1" id="cInmobiliariaNeto1" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionAgen1'>Comision agente 1</label></td>
            <td><input readonly autocomplete="off" type="text" name="cAgente1" id="cAgente1" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
            <td style="width:200px;"><label for="">Cheque</label></td>
            <td> <input autocomplete="off" type="checkbox" name="formaPago" value="cheque"> </td>
            <td style="width:300px;"><label for="">Transferencia</label></td>
            <td> <input autocomplete="off" type="checkbox" name="formaPago" value="transferencia"> </td>
            <td style="width:200px;"><label for="">Banco</label></td>
            <td> <input autocomplete="off" type="text" name="nombreBanco" value="" style="width:100px;"> </td>
            <td style="width:300px;"><label for="">Cuenta N.</label></td>
            <td> <input autocomplete="off" type="text" name="numeroCuenta" value="" style="width:100px;"> </td>
          </tr>
          <tr>
              <td style="width:700px;"><label for="" id='feeOfi2'>Menos Fee Regional Com.Oficina 2</label></td>
              <td><input readonly autocomplete="off" type="text" name="feeRegional2" id="feeRegional2" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionOfi2'>Comision neto oficina 2</label></td>
            <td><input readonly autocomplete="off" type="text" name="cInmobiliariaNeto2" id="cInmobiliariaNeto2" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionAgen2'>Comision agente 2</label></td>
            <td><input readonly autocomplete="off" type="text" name="cAgente2" id="cAgente2" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
            <td style="width:200px;"><label for="">Cheque</label></td>
            <td> <input autocomplete="off" type="checkbox" name="formaPago" value="cheque"> </td>
            <td style="width:300px;"><label for="">Transferencia</label></td>
            <td> <input autocomplete="off" type="checkbox" name="formaPago" value="transferencia"> </td>
            <td style="width:200px;"><label for="">Banco</label></td>
            <td> <input autocomplete="off" type="text" name="nombreBanco" value="" style="width:100px;"> </td>
            <td style="width:300px;"><label for="">Cuenta N.</label></td>
            <td> <input autocomplete="off" type="text" name="numeroCuenta" value="" style="width:100px;"> </td>
          </tr>
          <tr>
              <td style="width:700px;"><label for="" id='feeOfi3'>Menos Fee Regional Com.Oficina 3</label></td>
              <td><input readonly autocomplete="off" type="text" name="feeRegional3" id="feeRegional3" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionOfi3'>Comision neto oficina 3</label></td>
            <td><input readonly autocomplete="off" type="text" name="cInmobiliariaNeto" id="cInmobiliariaNeto" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionAgen3'>Comision agente 3</label></td>
            <td><input readonly autocomplete="off" type="text" name="cAgente3" id="cAgente3" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
            <td style="width:200px;"><label for="">Cheque</label></td>
            <td> <input autocomplete="off" type="checkbox" name="formaPago" value="cheque"> </td>
            <td style="width:300px;"><label for="">Transferencia</label></td>
            <td> <input autocomplete="off" type="checkbox" name="formaPago" value="transferencia"> </td>
            <td style="width:200px;"><label for="">Banco</label></td>
            <td> <input autocomplete="off" type="text" name="nombreBanco" value="" style="width:100px;"> </td>
            <td style="width:300px;"><label for="">Cuenta N.</label></td>
            <td> <input autocomplete="off" type="text" name="numeroCuenta" value="" style="width:100px;"> </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- moneda,tipo,simbolo -->
    <!-- BOTONES -->
    <input name="guardar" type="button" value="Guardar" class="boton-formulario guardar" onclick="guardarDatosDCO();">
    <input name="volver" type="button" value="Volver" onclick = "location='dco_panel.php';"  class="boton-formulario">
    </form>


</body>
<script type="text/javascript">
    //CLASES
    class Agentes{
        dscAgente;
        dscOficina;
        tipoAgente;
        feeOperacionesOficina;
        categoria;
        datos=[];
        precioFinal;
        porcRegional;
        comisionInmobOfi;
        comisionInmoNetoOfi;
        comisionAgente;
        utilidad_oficina;

        constructor(){

        }
        calcularDatos(vDivision){
            this.precioFinal=window.datosGenerales.pFinal/vDivision;
            this.porcRegional=window.porcentaje;
            //console.log(this.precioFinal);
            this.comisionInmobOfi=window.datosGenerales.comision/vDivision;
            this.comisionInmoNetoOfi=((1-(this.feeOperacionesOficina /100))*this.comisionInmobOfi);
            this.comisionAgente=(this.categoria/100)*this.comisionInmoNetoOfi;
            this.utilidad_oficina=this.comisionInmoNetoOfi-this.comisionAgente;
            //console.log((this.categoria/100)*this.comisionInmoNetoOfi);
            this.datos["precio_final"]= window.datosGenerales.pFinal;
            //this.datos["precio_reserva"]= window.reserva.totalReserva;
            this.datos["com_inmob"]=(this.comisionInmobOfi/100)/vDivision ;
            this.datos["com_inmob_porc"]=(this.feeOperacionesOficina*this.comisionInmobOfi);
            this.datos["utilidad_oficina"]=this.utilidad_oficina;
            this.datos["saldo_pagar"]=(this.categoria/100)*this.comisionInmoNetoOfi;
        }
    }
    class Reserva{
        nCi;
        fecha;
        moneda_id;
        importe;
        referencia;
        vCotizacion;
        totalConvertido;

        constructor(vector){
            //console.log(vector);
            this.moneda_id=vector[0];
            this.fecha=vector[1];
            this.importe=vector[2];
            this.referencia=vector[3];
            this.vCotizacion=vector[4];
            this.nCi=vector[5];
            this.monedaSimbolo=vector[6];
        }
        totalizarReserva(){
            if(window.cotizacionGeneral.id!=this.moneda_id){
                this.totalConvertido=(this.importe*this.vCotizacion)/window.cotizacionGeneral.cCompra;
            }else{
                this.totalConvertido=this.importe;
            }
            return this.totalConvertido;
        }
        crearFila(){
            return "<tr class='fila-reserva'><td>"+this.fecha+"</td><td>"+this.importe+"</td><td>"+this.monedaSimbolo+"</td><td>"+this.referencia+"</td><td>"+this.nCi+"</td></tr>";

        }
    }
    class datosGeneral{
        constructor(pPropiedad){
            this.saldo=0;
            this.tOperacion="";
            this.pPropiedad=parseInt(pPropiedad);
            this.pFinal=parseInt(pPropiedad);
            this.comisionAdicional=0;
            this.comision=0;
            this.porcentaje=0;
            this.reserva=0;
            this.tOperacionDivisor=1;
            this.reserva=window.reserva.totalizarReserva();
            obtenerDatosCallBack(['ultcotiz_v','ultcotiz_co','id'],'moneda','id',$("#moneda").val(),'',window.cotizacionGeneral.actualizarCotizaciones);
            obtenerDatosCallBack(['importe_desde','importe_hasta','comision',' moneda_id','(SELECT ultcotiz_v from moneda where id=moneda_id)'], 'comision_fija','moneda_id',window.cotizacionGeneral.id,'',function (valores){ window.comision=valores;});
            $("#reserva").val(window.reserva.totalizarReserva)
        }
        realizarCalculos(){
            var vComision=this.verificarComision();
            this.porcentaje=window.porcentaje;
            this.reserva=window.reserva.totalReserva;
            if(vComision[0]==0){
                //console.log(this.pFinal+" * "+this.porcentaje+ " = "+this.pFinal*(this.porcentaje/100));
                this.comision=this.pFinal*(this.porcentaje/100);
            }else{
                this.comision=vComision[1];
                this.porcentaje=0;
            }
            this.saldo=this.pFinal-this.reserva;
            this.comisionAdicional=this.pFinal-this.pPropiedad;
            this.cargarHTML();
        }

        setPrecioFinal(valor){
            //console.log("test"+valor.replace(/\./g,"")+" valor"+valor);
            this.pFinal=(valor!="")?valor.replace(/\./g,""):0;
            this.realizarCalculos();
        }
        setTipoOperacion(tipoOP){
            this.tOperacion=tipoOP.toUpperCase();
            this.verificarTipoOperacion();
        }
        verificarTipoOperacion(){
            if((this.tOperacion==("Compartida misma oficina").toUpperCase())||((this.tOperacion==("Compartida Otra Oficina").toUpperCase()))){
                this.tOperacionDivisor=2;
            }else if ((this.tOperacion==("Compartida misma oficina-Ref. Captacion").toUpperCase())||(this.tOperacion==("Compartida Otra Oficina-Ref. Captacion").toUpperCase())) {
                this.tOperacionDivisor=4;
            }else if((this.tOperacion==("Compartida misma oficina-Ref. Cap. y Venta").toUpperCase()) || (this.tOperacion==("Compartida Otra Oficina -Ref. Cap. y Venta").toUpperCase())){
                this.tOperacionDivisor=4;
            }
        }
        cargarHTML(){
            //$("#precioFinal").val(formatearDinero(this.pFinal));
            $("#valorPropiedad").val(this.formatearDinero(this.pPropiedad));
            $("#pVenta").val(this.formatearDinero(this.pFinal));
            $("#porcentaje").val(this.porcentaje);
            $("#comisionAdicional").val(this.formatearDinero(this.comisionAdicional));
            $("#reserva").val(this.formatearDinero(this.reserva));
            $("#comision").val(this.formatearDinero(this.comision));
            $("#cInmobiliaria").val(this.formatearDinero(this.comision));
            $("#saldo").val(this.formatearDinero(this.saldo));
        }
        verificarComision(){
            for (var val of window.comision) {
                if((this.pFinal>= parseInt(val[0]))&&(this.pFinal<= parseInt(val[1]))){
                    return [val[3],val[2]];
                }
            }
            return [0,0];
        }
        formatearDinero(dato){
            return String(dato).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }
    }
    //Variables Globales{
    window.creador="<?php echo $_SESSION['usuario'].",".$_SESSION['idUsu'];?>"
    window.creadorId="<?php echo $_SESSION['idUsu'];?>"
    window.rolOperacion='';
    window.feeOficina=0;
    window.categoriaAgente=0;
    window.tablaReserva=[];
    window.porcentaje=0;
    window.cotizacionGeneral={
        id:0,
        cVenta:4,
        cCompra:1,
        actualizarCotizaciones : function(result) {
            //console.log("cotiz Actulizada");
            result=result[0];
            window.cotizacionGeneral.cVenta=parseInt(result[0]);
            window.cotizacionGeneral.cCompra=parseInt(result[1])
            window.cotizacionGeneral.id=parseInt(result[2])
        },
        convertirCompra:function (valor){
            return valor*window.cotizacionGeneral.cCompra
        },
        convertirVenta:function (valor){
            return valor/window.cotizacionGeneral.cVenta
        }
    };
    window.agenteCaptador=new Agentes();
    window.agenteVendedor=new Agentes();
    window.agenteReferido;
    window.comision=[];
    window.reserva={
        totalReserva:0,
        reservas:[],
        totalizarReserva : ()=>{
            var suma=0;
            for (var dato of window.reserva.reservas){
                suma+=parseInt(dato.totalizarReserva());
            }
            window.reserva.totalReserva=suma;
            return suma;
        },
        crearCuerpoTabla:()=>{
            var filas="";
            for (var dato of window.reserva.reservas){
                filas+=dato.crearFila();
                console.log(filas);
            }
            return filas;
        }
    };
    window.datosGenerales=new datosGeneral();
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0,10);
    });

    //======================================
    //FUNCION PARA PRECARGAR CAMPOS O ASIGNAR FUNCIONES A EVENTOS EN INPUTS
    //======================================
    function inicializar(){
        document.getElementById('fecha').value=(new Date().toDateInputValue());
        $("#detallesVendedor").hide();
        if($("#tOperacion").val()=='Individual'){
            $("#contenedor-vendedor").hide();
            $("#vendedorTitu").hide();
            $("#contenedor-referido").hide();
            $("#referidoTitu").hide();

        }
        $("#propiedades").on("keydown",function (e){obtenerDatosPropiedades(e.keyCode)});
        $("#dscOficinaV").on("keydown",function(e){$("#dscVendedorV").val("");$("#idVendedorV").val("") });
        $("#dscVendedorV").on("keydown",function(e){vendedor(e.keyCode) });
        $("#dscOficinaR").on("keydown",function(e){$("#dscVendedorR").val("");$("#idVendedorR").val("") });
        $("#dscVendedorR").on("keydown",function (e){referido(e.keyCode)});
        $("#reserva").on("keyup",function (){actualizarMontos()});
        $("#porcentaje").on("keyup",function (){actualizarMontos()});
        $("#precioFinal").on("keyup",function (){
                window.datosGenerales.setPrecioFinal(this.value);
            });
        $("#fPago").on("change",function (){formasDePago()});
        $("#condiciones").on("change",function (){cargarCondiciones(this.value)});
        $("#ciComprador").on("keydown",function (e){seleccionarComprador(e.keyCode)});
        $("#moneda").on("change",function (){
            //REALIZAR CONVERSION AL CAMBIAR EL TIPO DE MONEDA
            actualizarMontos();
        })
    }
    $(document).ready( function() {
        inicializar();
        $("#cabecera-operacion").css("display","none");
        $("#detalle-operacion").css("display","none");
        $("#distribucion-operacion").css("display","none");

    });

    //======================================
    //FUNCION PARA PODER DESPLEGAR BLOQUES DEL FORMULARIO
    //======================================
    function cambiarVista(valor){
        //console.log("test"+valor);
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

    //======================================
    //PRECRAGAR LOS DATOS DE  LAS PROPIEDADES Y DEMAS
    //======================================
    function seleccionarComprador(e){
        if(e==9){
            obtenerDatosCallBack(['dsc_cliente','telefono1','direccion','mail'],'cliente','id',$("#idComprador").val(),'',(res)=>{
                res=res[0];
                $("#compradorL").val(res[0]);
                $("#telefonoC").val(res[1]);
                $("#direccionC").val(res[2]);
                $("#correoC").val(res[3]);

            });
        }
    }
    function obtenerDatosPropiedades(e){
        if(e==9){
            var idProp=$("#idPropiedad").val();
            obtenerDatosCallBack(['precio','cate_propiedad','Finca_ccctral','dsc_ciudad','cod_iconnect','propietario','moneda_id'], 'propiedades' ,'id',idProp,"",cargarProp);
            obtenerDatosCallBack(['vta_comision'],'parametros','','','ORDER BY fecreacion DESC',cargarPorc);
            obtenerDatosCallBack(['moneda_id','fecha','importe','referencia','cotizacion','nro_ci','(SELECT simbolo FROM moneda WHERE id=moneda_id )'],"reservas","propiedades_id",idProp,'',cargarReserva)
            actualizarMontos();
        }
    }
    function cargarProp(resultado){
        resultado=resultado[0];

            window.datosGenerales=new datosGeneral(resultado[0]);
            $("#propietarioL").val(resultado[5]);
            $("#reserva").val("0");
            $("#nCtaCte").val(resultado[2]);
            $("#tipoPropiedad").val(resultado[1]);
            window.datosGenerales.pPropiedad=resultado[0];
            window.datosGenerales.setPrecioFinal(resultado[0]);
            $("#precioFinal").val(formatearDinero(resultado[0]));
            $("#moneda option").map(function (){if ($(this).val() == resultado[6]) return this;}).attr('selected', 'selected');
            $("#ciudad").val(resultado[3]);
            obtenerDatosCallBack(['ultcotiz_v','ultcotiz_co','id'],'moneda','id',resultado[6],'',window.cotizacionGeneral.actualizarCotizaciones);
            obtenerDatosCallBack(['importe_desde','importe_hasta','comision',' moneda_id','(SELECT ultcotiz_v from moneda where id=moneda_id)'], 'comision_fija','moneda_id',window.cotizacionGeneral.id,'',cargarComision);
            obtenerDatosCallBack(['dsc_vendedor','id','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id LIMIT 1)','oficina_id','usuario_id','categoria','(SELECT fee_operaciones FROM contratos WHERE contratos.oficina_id=vendedor.oficina_id LIMIT 1)'],'vendedor','cod_iconnect',resultado[4],'',cargarCaptador);
            //console.log("Cargo datos de reserva");
    }
    function cargarPorc(res){
        window.porcentaje=res[0][0];
    }
    function cargarComision(valores){
        window.comision=valores
    }

    //======================================
    //CARGAR DATOS DE LOS AGENTES
    //======================================
    function cargarCaptador(resultado){
        resultado=resultado[0];
        console.log(resultado);
        //SALDO A PAGAR SE CARGA EN LA FUNCION DE CARGAR DETALLE
        if(typeof resultado!="undefined"){
            window.agenteCaptador.datos["vendedor_id"]= resultado[1];
            //dco_id se carga en la funcion de cargar detalle
            window.agenteCaptador.datos["oficina_id"]= resultado[3];
            window.agenteCaptador.datos["fecha"]= $("#fecha").val();
            window.agenteCaptador.datos["operacion"]= "VENTA";
            //precio_final se carga en la funcion de cargar detalle
            //precio_reserva se carga en la funcion de cargar detalle
            //fecha reserva es innecesario
            //saldo_pagar  se carga en la funcion de cargar detalle
            //com_inmob se carga en la funcion de cargar detalle
            //com_inmob_porc se carga en la funcion de cargar detalle
            //tener_cuenta es innecesario
            //di_precio ?
            //di_cominmo = ?
            //di_comof1 = ?
            //di_comof2 innecesario
            //di_feeregional debe cargarse en detalle
            //di_comneto = debe cargarse en detalle
            //di_com_ag1 = debe cargarse en detalle
            //di_com_ag2 es innecesario
            //di_nfactura_ag  debe cargarse en detalle
            //di_nfactura_remax ?
            //di_nfactura_oficina
            window.agenteCaptador.datos["creador"]= window.creador;
            window.agenteCaptador.datos["forma_cobro"]="";//debeCargarse en detalle
            window.agenteCaptador.datos["ch_cantidad"]= "";
            window.agenteCaptador.datos["transf_banco1"]= "";
            window.agenteCaptador.datos["transf_cta1"]= "";
            //alq_vigencia no utilizado en este ambito
            window.agenteCaptador.datos["por_agente"]= resultado[5];
            window.agenteCaptador.datos["estado_pagocom"]="";
            window.agenteCaptador.datos["buscador"]= resultado[2]+resultado[0];
            //utilidad_oficina debe cargarse en detalle
            window.agenteCaptador.datos["papel_operacion"]= "CAPTADOR";

            window.agenteCaptador.tipoAgente="Captador";
            window.agenteCaptador.feeOperacionesOficina=resultado[6];
            window.agenteCaptador.categoria=resultado[5];
            window.agenteCaptador.dscAgente=resultado[0];
            window.agenteCaptador.dscOficina=resultado[2];

            $("#dscOficinaC").val(resultado[2]);
            $("#idOficinaC").val(resultado[3]);
            $("#dscVendedorC").val(resultado[0]);
            $("#idVendedorC").val(resultado[1]);
            if(window.creadorId==resultado[4]){
                window.rolOperacion='CAPTADOR'
                $("#referidoTitu").html("Referido Captacion")
            }else{
                if($("#tOperacion").val()!="Individual"){
                    window.rolOperacion='VENDEDOR'
                    $("#referidoTitu").html("Referido Venta")
                    obtenerDatosCallBack(['dsc_vendedor','id','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id LIMIT 1)','oficina_id','usuario_id','categoria','(SELECT fee_operaciones FROM contratos WHERE contratos.oficina_id=vendedor.oficina_id LIMIT 1)'],'vendedor','usuario_id',window.creadorId,' LIMIT 1',cargarVendedor);
                }else{
                    popup("Advertencia","Usted no es el propietario de la propiedad sobre la cual quiere realizar esta Operacion");
                }
            }
        }else{
            popupAfirmar("Error","No existe agente captador registrado para esta Propiedad",function (){console.log("test");location='dco_panel.php'});

        }
    }
    function vendedor(e){
        console.log("referido");
        if(e==9){
        var idVen=$("#idVendedorV").val();
        obtenerDatosCallBack(['dsc_vendedor','id','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id LIMIT 1)','oficina_id','usuario_id','categoria','(SELECT fee_operaciones FROM contratos WHERE contratos.oficina_id=vendedor.oficina_id LIMIT 1)'],'vendedor','id',idVen,'',cargarVendedor);
        }

    }
    function cargarVendedor(resultado){
        resultado=resultado[0];
        window.agenteVendedor.datos["vendedor_id"]= resultado[1];
        //dco_id se carga en la funcion de cargar detalle
        window.agenteVendedor.datos["oficina_id"]= resultado[3];
        window.agenteVendedor.datos["fecha"]= $("#fecha").val();
        window.agenteVendedor.datos["operacion"]= "VENTA";
        //precio_final se carga en la funcion de cargar detalle
        //precio_reserva se carga en la funcion de cargar detalle
        //fecha reserva es innecesario
        //saldo_pagar  se carga en la funcion de cargar detalle
        //com_inmob se carga en la funcion de cargar detalle
        //com_inmob_porc se carga en la funcion de cargar detalle
        //tener_cuenta es innecesario
        //di_precio ?
        //di_cominmo = ?
        //di_comof1 = ?
        //di_comof2 innecesario
        //di_feeregional debe cargarse en detalle
        //di_comneto = debe cargarse en detalle
        //di_com_ag1 = debe cargarse en detalle
        //di_com_ag2 es innecesario
        //di_nfactura_ag  debe cargarse en detalle
        //di_nfactura_remax ?
        //di_nfactura_oficina
        window.agenteVendedor.datos["creador"]= window.creador;
        window.agenteVendedor.datos["forma_cobro"]="";//debeCargarse en detalle
        window.agenteVendedor.datos["ch_cantidad"]= "";
        window.agenteVendedor.datos["transf_banco1"]= "";
        window.agenteVendedor.datos["transf_cta1"]= "";
        //alq_vigencia no utilizado en este ambito
        window.agenteVendedor.datos["por_agente"]= resultado[5];
        window.agenteVendedor.datos["estado_pagocom"]="";
        window.agenteVendedor.datos["buscador"]= resultado[2]+resultado[0];
        //utilidad_oficina debe cargarse en detalle
        window.agenteVendedor.datos["papel_operacion"]= "VENDEDOR";

        window.agenteVendedor.tipoAgente="Vendedor";
        window.agenteVendedor.feeOperacionesOficina=resultado[6];
        window.agenteVendedor.categoria=resultado[5];
        window.agenteVendedor.dscAgente=resultado[0];
        window.agenteVendedor.dscOficina=resultado[2];
        $("#dscOficinaV").val(resultado[2]);
        $("#idOficinaV").val(resultado[3]);
        $("#dscVendedorV").val(resultado[0]);
        $("#idVendedorV").val(resultado[1]);
        actualizarMontos();
    }
    function referido(e){
        console.log("referido");
        if(e==9){
            var idRef=$("#idVendedorR").val();
            if((idRef!=null) && (idRef!="")){
                obtenerDatosCallBack(['dsc_vendedor','id','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id LIMIT 1)','oficina_id','usuario_id','categoria','(SELECT fee_operaciones FROM contratos WHERE contratos.oficina_id=vendedor.oficina_id LIMIT 1)'],'vendedor','id',idRef,'',cargarReferido);
            }
        }
    }
    function cargarReferido(resultado){
        console.log("cargarDatos");
        window.agenteReferido=new Agentes();

        resultado=resultado[0];
        window.agenteVendedor.datos["vendedor_id"]= resultado[1];
        //dco_id se carga en la funcion de cargar detalle
        window.agenteVendedor.datos["oficina_id"]= resultado[3];
        window.agenteVendedor.datos["fecha"]= $("#fecha").val();
        window.agenteVendedor.datos["operacion"]= "VENTA";
        //precio_final se carga en la funcion de cargar detalle
        //precio_reserva se carga en la funcion de cargar detalle
        //fecha reserva es innecesario
        //saldo_pagar  se carga en la funcion de cargar detalle
        //com_inmob se carga en la funcion de cargar detalle
        //com_inmob_porc se carga en la funcion de cargar detalle
        //tener_cuenta es innecesario
        //di_precio ?
        //di_cominmo = ?
        //di_comof1 = ?
        //di_comof2 innecesario
        //di_feeregional debe cargarse en detalle
        //di_comneto = debe cargarse en detalle
        //di_com_ag1 = debe cargarse en detalle
        //di_com_ag2 es innecesario
        //di_nfactura_ag  debe cargarse en detalle
        //di_nfactura_remax ?
        //di_nfactura_oficina
        window.agenteVendedor.datos["creador"]= window.creador;
        window.agenteVendedor.datos["forma_cobro"]="";//debeCargarse en detalle
        window.agenteVendedor.datos["ch_cantidad"]= "";
        window.agenteVendedor.datos["transf_banco1"]= "";
        window.agenteVendedor.datos["transf_cta1"]= "";
        //alq_vigencia no utilizado en este ambito
        window.agenteVendedor.datos["por_agente"]= resultado[5];
        window.agenteVendedor.datos["estado_pagocom"]="";
        window.agenteVendedor.datos["buscador"]= resultado[2]+resultado[0];
        //utilidad_oficina debe cargarse en detalle
        window.agenteVendedor.datos["papel_operacion"]= "VENDEDOR";

        window.agenteVendedor.tipoAgente="Captador";
        window.agenteVendedor.feeOperacionesOficina=resultado[6];
        window.agenteVendedor.categoria=resultado[5];
        window.agenteVendedor.dscAgente=resultado[0];
        window.agenteVendedor.dscOficina=resultado[2];
        actualizarMontos();
    }

    //======================================
    //REALIZACION DE CALCULOS GENERALES
    //======================================
    function actualizarMontos(){
        obtenerDatosCallBack(['ultcotiz_v','ultcotiz_co','id'],'moneda','id',$("#moneda").val(),'',window.cotizacionGeneral.actualizarCotizaciones);
        obtenerDatosCallBack(['importe_desde','importe_hasta','comision',' moneda_id','(SELECT ultcotiz_v from moneda where id=moneda_id)'], 'comision_fija','moneda_id',window.cotizacionGeneral.id,'',cargarComision);
        window.reserva.totalizarReserva;
        window.datosGenerales.realizarCalculos();
        window.datosGenerales.setTipoOperacion($("#tOperacion").val().toUpperCase() );
        actualizarMontosTablaPagos();
    }
    function actualizarMontosTablaPagos(){
        var aux="Referido Captador";
        $("#feeRegional").val(((window.feeOficina)/100)*($("#cInmobiliaria").val()));
        $("#cInmobiliariaNeto").val((1-((window.feeOficina)/100))*(($("#cInmobiliaria").val())/window.datosGenerales.tOperacionDivisor));
        $("#cAgente1").val((window.categoriaAgente/100)*$("#cInmobiliariaNeto").val());
        if(tOperacion!=1){
            if((typeof window.agenteReferido!="undefined") &&($("#idVendedorR").val()!='')){
                if(window.agenteReferido.tipoAgente.toUpperCase()==aux.toUpperCase()){
                    window.agenteReferido.calcularDatos(4)
                    window.agenteCaptador.calcularDatos(4)
                    window.agenteVendedor.calcularDatos(2)
                }else{
                    window.agenteReferido.calcularDatos(4)
                    window.agenteCaptador.calcularDatos(2)
                    window.agenteVendedor.calcularDatos(4)

                }
            }else{
                window.agenteCaptador.calcularDatos(2)
                window.agenteVendedor.calcularDatos(2)
            }
        }else{
            window.agenteCaptador.calcularDatos(2)
        }

        actualizarDatosTablaDistribucion();
    }
    function cargarCondiciones(valor){
        var condiciones=obtenerDatos(['condiciones'],'condiciones','id',valor);
        $("#detalleCondiciones").val(condiciones);
    }
    function formasDePago(){
        var valor=$("#fPago").find(':selected').text();
        //console.log(valor);
        if(valor.toUpperCase()=="CHEQUE"){
            $("#nBancoC").removeAttr("readonly");
            $("#nChequeC").removeAttr("readonly");
        }else{
            $("#nBancoC").attr("readonly","true");
            $("#nChequeC").attr("readonly","true");

        }
    }
    function actualizarDatosTablaDistribucion(){
        $("#feeOfi1").html("Fee. oficina: " +window.agenteCaptador.dscOficina);
        $("#feeRegional1").val(formatearDinero(window.agenteCaptador.comisionInmobOfi));
        $("#comisionOfi1").html("Comision Oficina :"+window.agenteCaptador.dscOficina);
        $("#cInmobiliariaNeto1").val(formatearDinero(window.agenteCaptador.comisionInmoNetoOfi));
        $("#comisionAgen1").html("Comision Agente :"+window.agenteCaptador.dscAgente);
        $("#cAgente1").val(formatearDinero(window.agenteCaptador.comisionAgente));
        if(($("#tOperacion").val()).toUpperCase()!=("Individual").toUpperCase()){
            $("#feeOfi2").html("Fee. oficina: " +window.agenteVendedor.dscOficina);
            $("#feeRegional2").val(formatearDinero(window.agenteVendedor.comisionInmobOfi));
            $("#comisionOfi2").html("Comision Oficina :"+window.agenteVendedor.dscOficina);
            $("#cInmobiliariaNeto2").val(formatearDinero(window.agenteVendedor.comisionInmoNetoOfi));
            $("#comisionAgen2").html("Comision Agente :"+window.agenteVendedor.dscAgente);
            $("#cAgente2").val(formatearDinero(window.agenteVendedor.comisionAgente));
            if(typeof window.agenteReferido!="undefined"){
                var fila1=document.createElement("tr");
                fila1.innerHTML='<td style="width:700px;"><label for="" id="feeOfi3">Menos Fee Regional Com.Oficina 3</label></td> <td><input readonly autocomplete="off" type="text" name="feeRegional3" id="feeRegional3" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>';
                var fila2=document.createElement("tr");
                fila2.innerHTML='<td style="width:700px;"><label for="" id="comisionOfi3">Comision neto oficina 3</label></td><td><input readonly autocomplete="off" type="text" name="cInmobiliariaNeto3" id="cInmobiliariaNeto3" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>';
                var fila3=document.createElement("tr");
                document.getElementById("tabla-distribucion-pagos").appendChild(fila1);
                document.getElementById("tabla-distribucion-pagos").appendChild(fila2);
                document.getElementById("tabla-distribucion-pagos").appendChild(fila3);
                fila3.innerHTML='<td style="width:700px;"><label for="" id="comisionAgen3">Comision agente 3</label></td><td><input readonly autocomplete="off" type="text" name="cAgente3" id="cAgente3" value="" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td><td style="width:200px;"><label for="">Cheque</label></td><td> <input autocomplete="off" type="checkbox" name="formaPago" value="cheque"> </td><td style="width:300px;"><label for="">Transferencia</label></td><td> <input autocomplete="off" type="checkbox" name="formaPago" value="transferencia"> </td><td style="width:200px;"><label for="">Banco</label></td><td> <input autocomplete="off" type="text" name="nombreBanco" value="" style="width:100px;"> </td><td style="width:300px;"><label for="">Cuenta N.</label></td><td> <input autocomplete="off" type="text" name="numeroCuenta" value="" style="width:100px;"> </td>';

                $("#feeOfi3").html("Fee. oficina: " +window.agenteReferido.dscOficina);
                $("#feeRegional3").val(formatearDinero(window.agenteReferido.comisionInmobOfi));
                $("#comisionOfi3").html("Comision Oficina :"+window.agenteReferido.dscOficina);
                $("#cInmobiliariaNeto3").val(formatearDinero(window.agenteReferido.comisionInmoNetoOfi));
                $("#comisionAgen3").html("Comision Agente :"+window.agenteReferido.dscAgente);
                $("#cAgente3").val(formatearDinero(window.agenteReferido.comisionAgente));
            }else{
                $("#tabla-distribucion-pagos").find("tr:gt(7)").remove();
            }
            /*
            $("#feeOfi2").html("Fee. oficina: " +window.agenteVendedor.dscOficina);
            $("#comisionOfi2").html("Comision Oficina :"+window.agenteVendedor.dscOficina);
            $("#comisionAgen2").html("Comision Agente :"+window.agenteVendedor.dscAgente);
            */
        }else{
            $("#tabla-distribucion-pagos").find("tr:gt(4)").remove();
        }
    }
    function obtenerCotizacion(){
        var tipoMid=document.getElementById('tipoMoneda').value;
        obtenerDatosCallBack(['ultcotiz_co'],'moneda','id',tipoMid,'',cargarTablaReserva);
    }
    //======================================
    //SECCION DE GUARDADO DE DATOS
    //======================================

    //FUNCION PARA VALIDACIONES DE CARGA DE CAMPOS
    function guardarDatosDCO(){
        //VALIDACION DE CAMPOS
        if( ($("#idPropiedad").val()!="" ) && ($("#idPropiedad").val()!=null)){
            if( ($("#idVendedorC").val()!="" ) && ($("#idVendedorC").val()!=null)){
                if(($("#idOficinaV").val()!="" )&& ($("#idOficinaV").val()!=null)||(window.datosGenerales.tOperacion=="INDIVIDUAL") ){
                    if(($("#idVendedorv").val()!="" )&& ($("#idVendedorV").val()!=null)||(window.datosGenerales.tOperacion=="INDIVIDUAL")){
                        if(($("#ciPropietario").val()!="" )&& ($("#ciPropietario").val()!=null)){
                            if(($("#idComprador").val()!="" )&& ($("#idComprador").val()!=null)){
                                if(($("#ciComprador").val()!="" )&& ($("#ciComprador").val()!=null)){
                                    if(($("#moneda").val()!="" )&& ($("#moneda").val()!=null)){
                                        if(($("#fPago").val()!="" )&& ($("#fPago").val()!=null)){
                                            if(($("#precioFinal").val()!="" )&& ($("#precioFinal").val()!=null)){
                                                if($("#precioFinal").val()< $("#valorPropiedad").val()) {
                                                    //enviar mail
                                                    console.log("ENVIAR MAIL, AVISANDO QUE EL PRECIO FINAL ES MENOR AL VALOR DE LA PROPIEDAD");
                                                }
                                                actualizarMontos();
                                                //actualizarMontoReserva();
                                                guardarDatosCabecera();
                                                //guardarDetalle(16);
                                            }else{
                                                popup("Advertencia","Error no puede guardar un DCO sin un precio final");
                                            }
                                        }else{
                                            popup("Advertencia","Debe seleccionar una forma de pago");
                                        }
                                    }else {
                                        popup("Advertencia","Debe seleccionar una moneda de pago");
                                    }
                                }else{
                                    popup("Advertencia","Debe ingresar la Cedula de Identidad del Comprador");
                                }
                            }else{
                                popup("Advertencia","Debe ingresar un comprador registrado");
                            }
                        }else{
                            popup("Advertencia","Debe ingresar la Cedula de identidad del Propietario");
                        }
                    }else{
                        popup("Advertencia","Debe ingresar un Agente Registrado");
                    }
                }else{
                    console.log(window.datosGenerales.tOperacion);
                    popup("Advertencia","La propiedad no posee datos del Vendedor");
                }
            }else{
                popup("Advertencia","Debe ingrear una Oficina");
            }
        }else {
            popup("Advertencia","Debe ingresar el identificador de la Propiedad (id-Remax)");
        }
    }

    //FUNCION PARA GUARDAR LOS DATOS DE LA CABECERA DEL DCO EN LA TABLA dco
    function guardarDatosCabecera(){
        var datos={
            "medio_contacto_id":$("#medioContacto").val(),
            "propiedades_id":$("#idPropiedad").val(),
            "oficina_id":$("#idOficina").val(),// CUESTIONABLE NECESIDAD
            "moneda_id":$("#moneda").val(),
            "forma_pago_id":$("#fPago").val(),
            "fecha":$("#fecha").val(),
            "tipo_operacion":($("#tOperacion").val()).toUpperCase(),//VALOR TRAIDO POR DEFECTO DEPENDIENDO DE LO QUE SE ELIGE
            "operacion":"VENTA",
            "forma_pago":$("#fPago option:selected").text(),
            //"obs_pago":$("#").val(),
            "propietario_nombre":$("#propietarioL").val(),
            "propietario_ci":$("#ciPropietario").val(),
            "propietario_apellido":$("#propietarioApellido").val(),
            "propietario_direccion":$("propietarioDireccion").val(),
            "propietario_telefono":$("propietarioTelefono").val(),
            "propietario_correo":$("propietarioCorreo").val(),
            "precio_final":window.datosGenerales.pFinal,
            "saldo_pagar":window.datosGenerales.saldo,
            "com_inmob":window.datosGenerales.comision,//comision inmobiliaria
            "com_inmob_porc":window.datosGenerales.porcentaje,
            //tener cuenta que... innecesario
            "creador":window.creador,
            "fecreacion":$("#fecha").val(),
            //forma_cobro
            "comprador_nombre":$("#compradorL").val(),
            "comprador_ci_ruc":$("#ciComprador").val(),
            "idpropiedad_remax":$("#propiedades").val(),
            "buscador":$("#dscOficina").val()+$("#dscVendedor").val(),
            //SECUENCIA INNECESARIO
            "cliente_id":$("#idComprador").val(),
            "dco_estado":"ABIERTO",
            "utilidad_oficina":"",
            //rol_operacion -> innecesario
            "desde_precio":"",
            "hasta_precio":""
            //"comprador_id":$("#idComprador").val(),
            //"n_factura":$("#nFacturaCliente").val(),
            //"fecha_reserva":$("#").val(),verificar idReserva o solo total reserva
            //"reserva_importe":$("#reserva").val(),
        }
        $.post("Parametros/insertarDCO.php",{cabecera :JSON.stringify(datos),tabla:"dco"} , function(resultado){
            console.log(resultado);
            resultado=JSON.parse(resultado);
            if(resultado[0]!=0){
                popup("Error","Ha ocurrido un error al insertar el DCO");
            }else{
                guardarDetalle(resultado[1], window.agenteCaptador);
                if(($("#tOperacion").val()).toUpperCase()!=("Individual").toUpperCase()){
                    guardarDetalle(resultado[1],window.agenteVendedor);
                    if(window.agenteReferido!=null){
                        //guardarDetalle(resultado[1],window.agenteReferido);
                        console.log("diferente de null");
                    }
                }else{
                    window.agenteCaptador.datos['papel_operacion']='VENDEDOR';
                    guardarDetalle(resultado[1], window.agenteCaptador);
                }
                popup("Informacion","Insertado con exito");
            }
        })

    }
    function guardarDetalle(idDco,valoresFull){
        valores=Object.assign({},valoresFull.datos);
        console.log(valores);
        //precio_final se carga en la funcion de cargar detalle
        //precio_reserva se carga en la funcion de cargar detalle
        //fecha_reserva es innecesario
        //saldo_pagar  se carga en la funcion de cargar detalle
        //com_inmob se carga en la funcion de cargar detalle
        //com_inmob_porc se carga en la funcion de cargar detalle
        //tener_cuenta es innecesario
        //di_precio ?
        //di_cominmo = ?
        //di_comof1 = ?
        //di_comof2 innecesario
        //di_feeregional debe cargarse en detalle
        //di_comneto = debe cargarse en detalle
        //di_com_ag1 = debe cargarse en detalle
        //di_com_ag2 es innecesario
        //di_nfactura_ag  debe cargarse en detalle
        //di_nfactura_remax ?
        //di_nfactura_oficina
        //utilidad_oficina debe cargarse en detalle
        valores['dco_id']=idDco;
        valores["precio_final"]=window.datosGenerales.pFinal;
        //valores["fecha_reserva"]="";
        valores["saldo_pagar"]=window.datosGenerales.saldo;
        valores["com_inmob"]=window.datosGenerales.comision;
        valores["com_inmob_porc"]=window.datosGenerales.porcentaje;
        valores["di_comof1"]=valoresFull.comisionInmobOfi;
        valores["di_comneto"]=valoresFull.comisionInmoNetoOfi;
        valores["di_com_ag1"]=valoresFull.comisionAgente;
        console.log(valores);
        $.post("Parametros/insertarDCO.php",{cabecera :JSON.stringify(valores),tabla:"dco_detalle"} , function(resultado){
            console.log(resultado);
            resultado=JSON.parse(resultado);
            if(resultado[0]!=0){
                popup("Error","Ha ocurrido un error al insertar el DCO");
            }else{
                popup("Informacion","Realizado con exito detalle \n Numero de D.C.O. :"+idDco);
            }
        });

    }

    //======================================
    //REGISTRO DE NUEVO CLIENTE COMPRADOR
    //======================================
    function popupComprador(){
        var pop=document.createElement('div');
            pop.id="popupClienteNuevo";
            pop.style='position:fixed;width:45%;height:55%;float:left;left: 20%;top:10%;z-index:3;background-color:white';
        var iframeCliente=document.createElement('iframe');
            iframeCliente.id='contIframe';
            iframeCliente.src='cliente_form.php';
            iframeCliente.style='width:100%;height:95%;border:none;'
        var fondo=document.createElement('div');
            fondo.id='fondo';
            fondo.style='background-color:#919191;opacity:0.5;width:100%; height:95%; position:fixed;top:0px;left:0px;z-index:2'
        var botonCerrar=document.createElement("input");
            botonCerrar.type='button';
            botonCerrar.value='X';
            botonCerrar.style='background-color:red;color:white;float:right;';
            botonCerrar.id='btCerrarPopupComprador';
            botonCerrar.addEventListener('click',function(){cerrarPopupComprador()});

        pop.appendChild(botonCerrar);
        pop.appendChild(iframeCliente);
        document.body.appendChild(pop);
        document.body.appendChild(fondo);
        //document.getElementById("contIframe").contentWindow.document.getElementsByName('submit_cliente')[0].addEventListener('click',function(){cerrarPopupComprador()})
    }
    function cerrarPopupComprador(){
        document.body.removeChild(document.getElementById('popupClienteNuevo'));
        document.body.removeChild(document.getElementById('fondo'));
    }

    //======================================
    //RESERVA
    //======================================
    function cargarReserva(resultado){
        console.log(resultado);
        window.reserva.reservas=[];
        for(var dato of resultado){
            (window.reserva.reservas).push(new Reserva(dato));
        }
        window.reserva.totalizarReserva();
    }
    function abrirPopupReserva(){
        var pop=document.createElement('div');
            pop.id="popupReserva";
            pop.style='position:fixed;width:45%;height:55%;float:left;left: 20%;top:10%;z-index:3;background-color:white';
        var contenedor=document.createElement('div');
            contenedor.className='contenedores';
            contenedor.id='contR';
        var tblReserva=document.createElement('table');
            tblReserva.id="tblReserva";
            tblReserva.cellSpacing=0;
            tblReserva.style.width='100%';
            tblReserva.innerHTML="<thead><tr><td class='titulo-tabla'>Fecha</td><td class='titulo-tabla'>Importe</td><td class='titulo-tabla'>Moneda</td><td class='titulo-tabla'>Referencia</td><td class='titulo-tabla'>C.I.</td></tr></thead><tbody>"+window.reserva.crearCuerpoTabla()+"</tbody>";
        var botonCerrar=document.createElement("input");
            botonCerrar.type='button';
            botonCerrar.value='X';
            botonCerrar.style='background-color:red;color:white;float:right;';
            botonCerrar.id='btCerrarPopupComprador';
            botonCerrar.addEventListener('click',function(){cerrarPopupReserva()});
        pop.appendChild(botonCerrar);
        contenedor.appendChild(tblReserva);
        pop.appendChild(contenedor);
        document.body.appendChild(pop);
    }
    function cerrarPopupReserva(){
            document.body.removeChild(document.getElementById('popupReserva'));
    }

    //======================================
    //FORMATO DE NUMEROS
    //======================================
    function formatearDinero(dato){
        return String(dato).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
  </script>

</html>
