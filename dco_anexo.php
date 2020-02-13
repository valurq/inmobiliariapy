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
        $id=$_POST['seleccionado'];
        $campos=['id',
                'operacion',
                'tipo_operacion',
                'fecha',
                'propiedades_id',
                'propietario_nombre',
                'propietario_ci',
                'propietario_apellido',
                'propietrio_direccion',
                'propietario_telefono',
                'propietario_correo',
                //'cliente_id',
                '(SELECT dsc_cliente FROM cliente WHERE id = cliente_id)',
                '(SELECT ci_ruc FROM cliente WHERE id = cliente_id)',
                '(SELECT telefono1 FROM cliente WHERE id = cliente_id)',
                '(SELECT mail FROM cliente WHERE id = cliente_id)',
                '(SELECT direccion FROM cliente WHERE id = cliente_id)',

                //traer valores del cliente con subselects y verificar la tabla, por cambios de separar nombre y apellido
                '(SELECT Finca_ccctral FROM propiedades WHERE id=propiedades_id)',
                '(SELECT cate_propiedad FROM propiedades WHERE id=propiedades_id)',
                //'distrito', VERIFICAR EXISTENCIA Y POSICION DE CARGA
                '(SELECT dsc_ciudad FROM propiedades WHERE id=propiedades_id)',
                '(SELECT precio FROM propiedades WHERE id=propiedades_id)',
                'precio_final',
                'reserva',//traer tabla reserva con id propiedad
                //calcular comisionAdicional
                'pcom_inmob_porc',
                'com_inmob',
                'saldo_pagar',

                'medio_contacto_id',
                'forma_pago',
                'moneda_id'
            ];
            $res=$consulta->consultarDatosQ($campos,'dco','','id',$id );
            $res=$res->fetch_array();
            print_r($res);
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
                <input autocomplete="off" list="id_propiedades" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscarListaQ(['id_remax'], this.value,'propiedades', 'id_remax', 'id_propiedades', 'idPropiedad','LIMIT 10')" >
                <datalist id="id_propiedades">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idPropiedad" id="idPropiedad">
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
            <tr class="fila-form"><td colspan="4"><h4>Datos Cliente Vendedor o Propietario</h4></td></tr>
            <tr class="fila-form">
                <td class="columna-form">Nombre y apellido/Razon Social</td>
                <td><input autocomplete="off" list="propietario" id="propietarioL" name="propietarioL" autocomplete="off" onkeyup="buscarLista(['dsc_cliente'], this.value,'cliente', 'dsc_cliente', 'propietario', 'idPropietario')" >
                <datalist id="propietario">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idPropietario" id="idPropietario">
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td class="columna-form">C.I. / R.U.C. </td>
                <td> <input autocomplete="off" type="text" name="ciPropietario" id="ciPropietario" value="" class="campos-ingreso"> </td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Telefono</td>
                <td><input autocomplete="off" list="propietario" id="propietarioL" name="propietarioL" autocomplete="off" onkeyup="buscarLista(['dsc_cliente'], this.value,'cliente', 'dsc_cliente', 'propietario', 'idPropietario')" >
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td class="columna-form">Correo </td>
                <td> <input autocomplete="off" type="text" name="ciPropietario" id="ciPropietario" value="" class="campos-ingreso"> </td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Direccion</td>
                <td><input autocomplete="off" list="propietario" id="propietarioL" name="propietarioL" autocomplete="off" onkeyup="buscarLista(['dsc_cliente'], this.value,'cliente', 'dsc_cliente', 'propietario', 'idPropietario')" >
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td class="columna-form">Nro. Factura</td>
                <td><input autocomplete="off" type="number" name="nFacturaCliente" id="nFacturaCliente" value="" class="campos-ingreso"></td>
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
        $("#cabecera-operacion").css("display","none");
        $("#detalle-operacion").css("display","none");
        $("#distribucion-operacion").css("display","none");

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


    function formatearDinero(dato){
        return String(dato).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
  </script>

</html>
