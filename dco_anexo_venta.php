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
        //CARGAR LOS DATOS CORRESPONDIENTES A LA CABECERA DCO
        $campos=[/*1*/'id',
                /*2*/'fecha',
                /*3*/'tipo_operacion',
                /*4*/'operacion',
                //'propiedades_id',
                /*5*/'(SELECT id_remax FROM propiedades WHERE id=propiedades_id)',
                /*6*/'propietario_nombre',
                /*7*/'propietario_ci',
                /*8*/'propietario_apellido',
                /*9*/'propietario_direccion',
                /*10*/'propietario_telefono',
                /*11*/'propietario_correo',
                //'cliente_id',
                /*12*/'(SELECT dsc_cliente FROM cliente WHERE id = cliente_id)',
                /*13*/'(SELECT ci_ruc FROM cliente WHERE id = cliente_id)',
                /*14*/'(SELECT telefono1 FROM cliente WHERE id = cliente_id)',
                /*15*/'(SELECT mail FROM cliente WHERE id = cliente_id)',
                /*16*/'(SELECT direccion FROM cliente WHERE id = cliente_id)',
                //traer valores del cliente con subselects y verificar la tabla, por cambios de separar nombre y apellido
                /*17*/'(SELECT Finca_ccctral FROM propiedades WHERE id=propiedades_id)',
                /*18*/'(SELECT cate_propiedad FROM propiedades WHERE id=propiedades_id)',
                //'distrito', VERIFICAR EXISTENCIA Y POSICION DE CARGA
                /*19*/'(SELECT dsc_ciudad FROM propiedades WHERE id=propiedades_id)',
                /*20*/'(SELECT precio FROM propiedades WHERE id=propiedades_id)',
                /*21*/'precio_final',
                //traer tabla reserva con id propiedad
                //calcular comisionAdicional
                /*22*/'com_inmob_porc',
                /*23*/'com_inmob',
                /*24*/'saldo_pagar',

                /*25*/'medio_contacto_id',
                /*26*/'forma_pago',
                /*27*/'moneda_id'
            ];
        $res=$consulta->consultarDatosQ($campos,'dco','','id',$id );
        $res=$res->fetch_array(MYSQLI_NUM);

        $tOp=$res[2];
        $camposIdForm=
        array(
            /*1*/'descarga',
            /*2*/'fecha',
            /*3*/'descarga',
            /*4*/'descarga',
            /*5*/'propiedades',
            /*6*/'propietarioL',
            /*7*/'ciPropietario',
            /*8*/'telefonoProp',
            /*9*/'correoProp',
            /*10*/'direccionProp',
            /*11*/'nFacturaCliente',
            /*12*/'compradorL',
            /*13*/'ciComprador',
            /*14*/'telefonoC',
            /*15*/'correoC',
            /*16*/'direccionC',
            /*17*/'nCtaCte',
            /*18*/'tipoPropiedad',
            /*19*/'ciudad',
            //'distrito',
            /*20*/'valorPropiedad',
            /*21*/'precioFinal',
            //'comisionAdicional',
            /*22*/'porcentaje',
            /*23*/'comision',
            /*24*/'saldo',
            /*25*/'medioContacto');

        //CARGAR LOS DATOS CORRESPONDIENTES AL DETALLE DEL DCO
        $camposDetalle=array(
            '(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)',
            '(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id)',
            'di_comof1',//fee regional
            'di_comneto',//comision neto oficina
            'di_com_ag1',//comision agente
            'papel_operacion'
        );
        $resDet=$consulta->consultarDatosQ($camposDetalle,'dco_detalle','','dco_id',$id );
        $datosDet=array();
        while($auxDet=$resDet->fetch_array(MYSQLI_NUM)){
            array_push($datosDet,$auxDet);
        }
        //echo count($datosDet);
    ?>

    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script  src="https://code.jquery.com/jquery-3.4.0.js" integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>
    <style media="screen">
        .popupLocal{
            background-color: white;
            width: 500px;
            height: 400px;
            position: absolute;
            left: 45%;
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
        .contenedores{
            display:flex;
            flex-direction:column;
            justify-content:space-around;
            flex-wrap:wrap;
            width: 100%;
        }
        .contenedores>select{
            margin-top:5px;
        }
        .contenedores>input{
            margin-top: 30px;
        }
        .contenedores>label{
            margin-top: 20px;
        }
        .visible{
            display:block;
        }
        .invisible{
            display:none;
        }
        body{
            font-family: Arial;
        }
        /* #popupDiscrepancias{
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
        } */
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
    <input type="hidden" name="descarga" id='descarga' value="">
    <?php            // echo "<pre> - ".print_r($datosDet,TRUE)."</pre>";?>
  <h2>Documento de Cierre de Operacion (D.C.O.) - N° <?php echo $id;?> <br> Venta</h2>
  <h4><?php echo $tOp?></h4>
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
                <input autocomplete="off" type="date" name="fecha" id="fecha" value="" placeholder="Ingrese el nombre de la oficina" class="campos-ingreso" readonly></td>
            <td class="columna-form"><label for="">Propiedad</label></td>
            <td>
                <input autocomplete="off" list="id_propiedades" id="propiedades" name="propiedades" autocomplete="off" readonly>
            </td>
          </tr>
          <tr ><td colspan="4"><h4 id='captadorTitu'><?php echo $datosDet[0][5];?></h4></td></tr>
          <tr>
            <td class="columna-form"><label for="">Nombre Oficina</label></td>
            <td>
                <input autocomplete="off" list="oficinaC" id="dscOficinaC" name="dscOficinaC"  readonly value="<?php echo $datosDet[0][0]?>" >
            </td>
            <td class="columna-form"><label for="">Nombre Agente</label></td>
            <td>
                <input autocomplete="off" list="agenteC" id="dscVendedorC" name="dscVendedorC" value="<?php echo $datosDet[0][1]?>" readonly>

            </td>
          </tr>
        <tr ><td colspan="4"><h4 id='vendedorTitu'><?php echo $datosDet[1][5];?></h4></td></tr>
          <tr id='contenedor-vendedor'>
            <td class="columna-form"><label for="">Nombre Oficina</label></td>
            <td>
                <input autocomplete="off" list="oficinaV" id="dscOficinaV" name="dscOficinaV" value="<?php echo $datosDet[1][0]?>" readonly>
                <datalist id="oficinaV">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idOficinaV" id="idOficinaV">
            </td>
            <td class="columna-form"><label for="">Nombre Agente</label></td>
            <td>
                <input autocomplete="off" list="agenteV" id="dscVendedorV" name="dscVendedorV" value="<?php echo $datosDet[1][1]?>" readonly>
                <datalist id="agenteV">
                  <option value=""></option>
                </datalist>
                <input autocomplete="off" type="hidden" name="idVendedorV" id="idVendedorV">
            </td>
          </tr>
          <?
            if((count($datosDet)==3)){
                echo'
                    <tr ><td colspan="4"><h4 id="referidoTitu">'.$datosDet[2][5].'</h4></td></tr>
                    <tr id="contenedor-referido">
                        <td class="columna-form"><label for="">Nombre Oficina</label></td>
                        <td>
                        <input autocomplete="off" list="oficinaR" id="dscOficinaR" name="dscOficinaR" autocomplete="off" value="'.$datosDet[2][0].'" >

                        </td>
                        <td class="columna-form"><label for="">Nombre Agente</label></td>
                        <td>
                        <input autocomplete="off" list="agenteR" id="dscVendedorR" name="dscVendedorR" value="'.$datosDet[2][1].'">
                        </td>
                        </tr>';
            }else if((count($datosDet)==4)){
                echo'
                    <tr ><td colspan="4"><h4 id="referidoTitu">'.$datosDet[2][5].'</h4></td></tr>
                    <tr id="contenedor-referido">
                        <td class="columna-form"><label for="">Nombre Oficina</label></td>
                        <td>
                        <input autocomplete="off" list="oficinaR" id="dscOficinaR" name="dscOficinaR" autocomplete="off" value="'.$datosDet[2][0].'" >

                        </td>
                        <td class="columna-form"><label for="">Nombre Agente</label></td>
                        <td>
                        <input autocomplete="off" list="agenteR" id="dscVendedorR" name="dscVendedorR" value="'.$datosDet[2][1].'">
                        </td>
                    </tr>
                    <tr ><td colspan="4"><h4 id="referidoTitu">'.$datosDet[3][5].'</h4></td></tr>
                    <tr id="contenedor-referido">
                        <td class="columna-form"><label for="">Nombre Oficina</label></td>
                        <td>
                        <input autocomplete="off" list="oficinaR" id="dscOficinaR" name="dscOficinaR" autocomplete="off" value="'.$datosDet[3][0].'" >

                        </td>
                        <td class="columna-form"><label for="">Nombre Agente</label></td>
                        <td>
                        <input autocomplete="off" list="agenteR" id="dscVendedorR" name="dscVendedorR" value="'.$datosDet[3][1].'">
                        </td>
                    </tr>';
                }?>
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
                <td><input autocomplete="off" list="propietario" id="propietarioL" name="propietarioL" autocomplete="off"  readonly>
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td class="columna-form">C.I. / R.U.C. </td>
                <td> <input autocomplete="off" type="text" name="ciPropietario" id="ciPropietario" value="" class="campos-ingreso" readonly> </td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Telefono</td>
                <td><input autocomplete="off" id="telefonoProp" name="telefonoProp" readonly>
                <!-- ACTUALIZAR CEDULA AL OBTENER EL ID  -->
                <td class="columna-form">Correo </td>
                <td> <input autocomplete="off" type="text" name="correoProp" id="correoProp" value="" class="campos-ingreso" readonly> </td>
            </tr>
            <tr class="fila-form">
                <td class="columna-form">Direccion</td>
                <td><input autocomplete="off"  id="direccionProp" name="direccionProp" readonly >
                <td class="columna-form">Nro. Factura</td>
                <td><input autocomplete="off" type="number" name="nFacturaCliente" id="nFacturaCliente" value="" class="campos-ingreso" readonly></td>
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
                <td width='600px;'> <input autocomplete="off" list='clienteC' type="text" name="ciComprador" id="ciComprador" value="" class="campos-ingreso" readonly>
            </tr>
            <tr >
                <td class="columna-form">Telefono</td>
                <td><input autocomplete="off" list="propietario" id="telefonoC" name="telefonoC" autocomplete="off"  readonly >
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
                <td><input autocomplete="off" type="text" name="nCtaCte" id="nCtaCte" value="" placeholder="Ingrese numero de Finca o Cta. Cte." class="campos-ingreso" readonly></td>
                <td class="columna-form"> <label for="">Distrito</label></td>
                <td> <input autocomplete="off" type="text" name="distrito" id='distrito' value=""class='campos-ingreso' readonly> </td>
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
                <td> <input  autocomplete="off" type="text" name="precioFinal" id="precioFinal" value="" data-type='currency'  class="campos-ingreso" readonly> </td>
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
            <td><input readonly autocomplete="off" type="text" name="pVenta" id="pVenta"  placeholder="Ingrese el precio de Venta" style="width:300px;" value="<?php echo $res[20]?>" ></td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="">Comision Inmobiliaria</label></td>
            <td><input readonly autocomplete="off" type="text" name="cInmobiliaria" id="cInmobiliaria"  placeholder="Ingrese la comision inmobiliaria" style="width:300px;"  value="<?php echo $res[22]?>" ></td>

          </tr>
          <tr>
              <td style="width:700px;"><label for="" id='feeOfi1'>Menos Fee Regional Oficina: <?php echo $datosDet[0][0];?></label></td>
              <td><input readonly autocomplete="off" type="text" name="feeRegional1" id="feeRegional1"  placeholder="Ingrese la comision inmobiliaria" style="width:300px;" value="<?php echo $datosDet[0][2];?>" ></td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionOfi1'>Comision neto Oficina: <?php echo $datosDet[0][0];?></label></td>
            <td><input readonly autocomplete="off" type="text" name="cInmobiliariaNeto1" id="cInmobiliariaNeto1" value="<?php echo $datosDet[0][3];?>" placeholder="Ingrese la comision inmobiliaria" style="width:300px;" ></td>

          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionAgen1'>Comision agente :<?php echo $datosDet[0][1];?></label></td>
            <td><input readonly autocomplete="off" type="text" name="cAgente1" id="cAgente1" value="<?php echo $datosDet[0][4];?>" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
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
              <td style="width:700px;"><label for="" id='feeOfi2'>Menos Fee Regional Oficina:<?php echo $datosDet[1][0];?></label></td>
              <td><input readonly autocomplete="off" type="text" name="feeRegional2" id="feeRegional2" value="<?php echo $datosDet[1][2];?>" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionOfi2'>Comision neto Oficina: <?php echo $datosDet[1][0];?></label></td>
            <td><input readonly autocomplete="off" type="text" name="cInmobiliariaNeto2" id="cInmobiliariaNeto2" value="<?php echo $datosDet[1][3];?>" placeholder="Ingrese la comision inmobiliaria" style="width:300px;" ></td>

          </tr>
          <tr>
            <td style="width:700px;"><label for="" id='comisionAgen2'>Comision agente:<?php echo $datosDet[1][1];?></label></td>
            <td><input readonly autocomplete="off" type="text" name="cAgente2" id="cAgente2" value="<?php echo $datosDet[1][4];?>"  style="width:300px;"></td>
            <td style="width:200px;"><label for="">Cheque</label></td>
            <td> <input autocomplete="off" type="checkbox" name="formaPago" value="cheque"> </td>
            <td style="width:300px;"><label for="">Transferencia</label></td>
            <td> <input autocomplete="off" type="checkbox" name="formaPago" value="transferencia"> </td>
            <td style="width:200px;"><label for="">Banco</label></td>
            <td> <input autocomplete="off" type="text" name="nombreBanco" value="" style="width:100px;"> </td>
            <td style="width:300px;"><label for="">Cuenta N.</label></td>
            <td> <input autocomplete="off" type="text" name="numeroCuenta" value="" style="width:100px;"> </td>
          </tr>
          <?php if(count($datosDet)==3) {
                    echo '<tr>
                        <td style="width:700px;"><label for="" id="feeOfi3">Menos Fee Regional Oficina: '.$datosDet[2][0].'</label></td>
                        <td><input readonly autocomplete="off" type="text" name="feeRegional3" id="feeRegional3" value="'.$datosDet[2][2].'" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
                    </tr>
                    <tr>
                      <td style="width:700px;"><label for="" id="comisionOfi3">Comision neto oficina: '.$datosDet[2][0].'</label></td>
                      <td><input readonly autocomplete="off" type="text" name="cInmobiliariaNeto" id="cInmobiliariaNeto" value="'.$datosDet[2][3].'" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

                    </tr>
                    <tr>
                      <td style="width:700px;"><label for="" id="comisionAgen3">Comision agente:'. $datosDet[2][1].'</label></td>
                      <td><input readonly autocomplete="off" type="text" name="cAgente3" id="cAgente3" value="'.$datosDet[2][4].'" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
                      <td style="width:200px;"><label for="">Cheque</label></td>
                      <td> <input autocomplete="off" type="checkbox" name="formaPago" value="cheque"> </td>
                      <td style="width:300px;"><label for="">Transferencia</label></td>
                      <td> <input autocomplete="off" type="checkbox" name="formaPago" value="transferencia"> </td>
                      <td style="width:200px;"><label for="">Banco</label></td>
                      <td> <input autocomplete="off" type="text" name="nombreBanco" value="" style="width:100px;"> </td>
                      <td style="width:300px;"><label for="">Cuenta N.</label></td>
                      <td> <input autocomplete="off" type="text" name="numeroCuenta" value="" style="width:100px;"> </td>
                    </tr>';
                }else if(count($datosDet)==4){
                    echo '<tr>
                        <td style="width:700px;"><label for="" id="feeOfi3">Menos Fee Regional Oficina: '.$datosDet[2][0].'</label></td>
                        <td><input readonly autocomplete="off" type="text" name="feeRegional3" id="feeRegional3" value="'.$datosDet[2][2].'" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
                    </tr>
                    <tr>
                      <td style="width:700px;"><label for="" id="comisionOfi3">Comision neto oficina: '.$datosDet[2][0].'</label></td>
                      <td><input readonly autocomplete="off" type="text" name="cInmobiliariaNeto" id="cInmobiliariaNeto" value="'.$datosDet[2][3].'" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

                    </tr>
                    <tr>
                      <td style="width:700px;"><label for="" id="comisionAgen3">Comision agente:'. $datosDet[2][1].'</label></td>
                      <td><input readonly autocomplete="off" type="text" name="cAgente3" id="cAgente3" value="'.$datosDet[2][4].'" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
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
                        <td style="width:700px;"><label for="" id="feeOfi3">Menos Fee Regional Oficina: '.$datosDet[3][0].'</label></td>
                        <td><input readonly autocomplete="off" type="text" name="feeRegional3" id="feeRegional3" value="'.$datosDet[3][2].'" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
                    </tr>
                    <tr>
                      <td style="width:700px;"><label for="" id="comisionOfi3">Comision neto oficina: '.$datosDet[3][0].'</label></td>
                      <td><input readonly autocomplete="off" type="text" name="cInmobiliariaNeto" id="cInmobiliariaNeto" value="'.$datosDet[3][3].'" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>

                    </tr>
                    <tr>
                      <td style="width:700px;"><label for="" id="comisionAgen3">Comision agente:'. $datosDet[3][1].'</label></td>
                      <td><input readonly autocomplete="off" type="text" name="cAgente3" id="cAgente3" value="'.$datosDet[3][4].'" placeholder="Ingrese la comision inmobiliaria" style="width:300px;"></td>
                      <td style="width:200px;"><label for="">Cheque</label></td>
                      <td> <input autocomplete="off" type="checkbox" name="formaPago" value="cheque"> </td>
                      <td style="width:300px;"><label for="">Transferencia</label></td>
                      <td> <input autocomplete="off" type="checkbox" name="formaPago" value="transferencia"> </td>
                      <td style="width:200px;"><label for="">Banco</label></td>
                      <td> <input autocomplete="off" type="text" name="nombreBanco" value="" style="width:100px;"> </td>
                      <td style="width:300px;"><label for="">Cuenta N.</label></td>
                      <td> <input autocomplete="off" type="text" name="numeroCuenta" value="" style="width:100px;"> </td>
                    </tr>
                    ';
                }
          ?>

        </tbody>
      </table>
    </div>

    <!-- moneda,tipo,simbolo -->
    <!-- BOTONES -->
    <input name="guardar" type="button" value="Guardar" class="boton-formulario guardar" onclick="guardarDatosDCO();">
    <input name="volver" type="button" value="Volver" onclick = "location='dco_panel.php';"  class="boton-formulario">
    <input name="discrepancias" type="button" value="Discrepancias" onclick ="popupDiscrepancias()"  class="boton-formulario" style="background-color:red;color:white;width:120px;">
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

    //======================================
    //FUNCION PARA PRECARGAR CAMPOS O ASIGNAR FUNCIONES A EVENTOS EN INPUTS
    //======================================
    function inicializar(){
        $("#cabecera-operacion").css("display","none");
        $("#detalle-operacion").css("display","none");
        $("#distribucion-operacion").css("display","none");

        //document.getElementById('fecha').value=(new Date().toDateInputValue());
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

    function popupDiscrepancias(){
        var pop=document.createElement('div');
            pop.id="popupDiscrepancias";
            pop.className="popupLocal";
        //    pop.style='position:fixed;width:45%;height:55%;float:left;left: 20%;top:10%;z-index:3;background-color:white';
        var contenedor=document.createElement('div');
            contenedor.className='contenedores';
            contenedor.id='contD';
        var label1=document.createElement('label');
            label1.id='tituAsunto';
            label1.innerHTML='Asunto'
        var asunto=document.createElement('input');
            asunto.type='text';
            asunto.id='Asunto';
        var label2=document.createElement("label");
            label2.innerHTML="Cuerpo";
        var cuerpo=document.createElement('textarea');
            cuerpo.id='cuerpo';
            cuerpo.style.height='100px';
        var botonCerrar=document.createElement("input");
            botonCerrar.type='button';
            botonCerrar.value='X';
            botonCerrar.style='background-color:red;color:white;float:right;';
            botonCerrar.id='btCerrarPopupCompradorDiscrepancias';
            botonCerrar.addEventListener('click',function(){btCerrarPopupDiscrepancias()});
        var btEnviar=document.createElement('input');
            btEnviar.type='button';
            btEnviar.id='enviar';
            btEnviar.value='Enviar';
            //btEnviar.className='boton-formulario'
            btEnviar.style="background-color:#16156f;color:white;border-radius: 20px;border:1px solid black;cursor:pointer;height:30px";
        pop.appendChild(botonCerrar);
        contenedor.appendChild(label1);
        contenedor.appendChild(asunto);
        contenedor.appendChild(label2);
        contenedor.appendChild(cuerpo);
        contenedor.appendChild(btEnviar);
        pop.appendChild(contenedor);

        document.body.appendChild(pop);
    }
    function btCerrarPopupDiscrepancias(){
            document.body.removeChild(document.getElementById('popupDiscrepancias'));
    }

  </script>
  <?php

      $valores=implode(",",$res);
      $camposIdForm=implode(",",$camposIdForm);
      //LLAMADA A LA FUNCION JS
      echo '<script>cargarCampos("'.$camposIdForm.'","'.$valores.'")</script>';

  ?>
</html>
