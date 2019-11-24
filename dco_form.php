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
        $id=0;
        $resultado="";

        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos=array( 'dsc_oficina', 'ruc', 'dsc_manager', 'direccion', 'mail', 'fe_contrato', 'telefono1', 'telefono2', 'tel_movil', 'obs', 'tipo', 'cod_remax', 'cod_remaxlegacy', 'cobro_fee_desde', 'razon');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'oficina',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('oficina','ruc','manager','direccion','email','fe_contrato','tel1','tel2','celular','obs','tipo', 'cod_remax','cod_remaxlegacy','cobro_fee_desde', 'razon');
        }
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
  <h2>D.C.O.</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->

<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <a id="datosGrales" onclick="cambiarVista(1)"><h3 >Datos Generales</h3></a>
  <div id="cabecera-operacion" class="">
      <table class="tabla-fomulario">
        <tbody>
          <tr>
            <td><label for="">Fecha</label></td>
            <td><input type="date" name="fecha" id="fecha" value="" placeholder="Ingrese el nombre de la oficina" class="campos-ingreso"></td>
            <td><label for="">Propiedad</label></td>
            <td>
                <input list="id_propiedades" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscarLista(['idpropiedad_remax'], this.value,'dco', 'idpropiedad_remax', 'id_propiedades', 'idPropiedad')" >
                <datalist id="id_propiedades">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idPropiedad" id="idPropiedad">
            </td>
          </tr>
          <tr>
              <td>Tipo de Operacion</td>
              <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[1],'tipoOperacion',array('Individual','Compartida','Otro'))?></td>
          </tr>
          <tr class="detIndividual">
            <td><label for="">Nombre Oficina</label></td>
            <td>
                <input list="oficina" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscarLista(['dsc_oficina'], this.value,'dco', 'dsc_oficina', 'oficina', 'idOficina')" >
                <datalist id="oficina">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idOficina" id="idOficina">
            </td>
            <td><label for="">Nombre Agente</label></td>
            <td>
                <input list="agente" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscarLista(['dsc_vendedor'], this.value,'dco', 'dsc_vendedor', 'agente', 'idVendedor')" >
                <datalist id="agente">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idVendedor" id="idVendedor">
            </td>
          </tr>
          <tr class="detIndividual">
            <td><label for="">Nombre Oficina</label></td>
            <td>
                <input list="oficina" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscarLista(['dsc_oficina'], this.value,'dco', 'dsc_oficina', 'oficina', 'idOficina')" >
                <datalist id="oficina">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idOficina" id="idOficina">
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>

            <td><label for="">Nombre Agente1</label></td>
            <td>
                <input list="agente" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscarLista(['dsc_vendedor'], this.value,'dco', 'dsc_vendedor', 'agente', 'idVendedor')" >
                <datalist id="agente">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idVendedor" id="idVendedor">
            </td>
            <td><label for="">Nombre Agente2</label></td>
            <td>
                <input list="agente" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscarLista(['dsc_vendedor'], this.value,'dco', 'dsc_vendedor', 'agente', 'idVendedor')" >
                <datalist id="agente">
                  <option value=""></option>
                </datalist>
                <input type="hidden" name="idVendedor" id="idVendedor">
            </td>
        </tr>
        </tbody>
      </table>
  </div>
  <a id="detalleOperacion" onclick="cambiarVista(2)"><h3>Detalle de operación</h3></a>
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
                <td><h4>Pago</h4></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
      </table>
  </div>
  <a id="distribucionIngreso" onclick="cambiarVista(3)"><h3>Distribución de ingresos</h3></a>
  <div id="distribucion-operacion" class="">
      <table class="tabla-fomulario">
        <tbody>
          <tr>
            <td><label for="">Oficina</label></td>
            <td><input type="text" name="oficina" id="oficina" value="" placeholder="Ingrese el nombre de la oficina" class="campos-ingreso"></td>

            <td><label for="">Ruc</label></td>
            <td><input type="text" name="ruc" id="ruc" value="" placeholder="Ingrese el RUC" class="campos-ingreso"></td>
          </tr>
          <tr>
            <td><label for="">País</label></td>
            <td>
              <?php
              //name, campoId, campoDescripcion, tabla
                $inserta_Datos->crearMenuDesplegable('pais', 'id', 'dsc_pais', 'pais');
              ?>
            </td>

            <td><label for="">Razón Social</label></td>
            <td>
              <input type="text" name="razon" id="razon" value="" placeholder="Ingrese la razón social" class="campos-ingreso">
            </td>
          </tr>
          <tr>
            <td><label for="">Ciudad</label></td>
            <td>
              <?php
              //name, campoId, campoDescripcion, tabla
                $inserta_Datos->crearMenuDesplegable('ciudad', 'id', 'dsc_ciudad', 'ciudad');
              ?>
            </td>
            <td><label for="">Manager</label></td>
            <td><input type="text" name="manager" id="manager" value=""  readonly placeholder="Nombre del manager" class="campos-ingreso"></td>
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

<?php
/*
    LLAMADA A FUNCION JS CORRESPONDIENTE A CARGAR DATOS EN LOS CAMPOS DEL FORMULARIO HTML
*/
    if(($id!=0 )){
        /*
            CONVERTIR LOS ARRAY A UN STRING PARA PODER ENVIAR POR PARAMETRO A LA FUNCION JS
        */
        $valores=implode(",",$resultado);
        $camposIdForm=implode(",",$camposIdForm);
        //LLAMADA A LA FUNCION JS
        echo '<script>cargarCampos("'.$camposIdForm.'","'.$valores.'")</script>';
    }


if (isset($_POST['oficina'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['oficina'])){
        $oficina =trim($_POST['oficina']);
        $ruc =trim($_POST['ruc']);
        $pais =trim($_POST['pais']);
        $ciudad =trim($_POST['ciudad']);
        $manager =trim($_POST['manager']);
        $direccion =trim($_POST['direccion']);
        $fe_contrato =trim($_POST['fe_contrato']);
        $email =trim($_POST['email']);
        $tel1 =trim($_POST['tel1']);
        $tel2 =trim($_POST['tel2']);
        $celular =trim($_POST['celular']);
        $tipo =trim($_POST['tipo']);
        $cod_remaxlegacy =trim($_POST['cod_remaxlegacy']);
        $cod_remax =trim($_POST['cod_remax']);
        $cobro_fee_desde =trim($_POST['cobro_fee_desde']);
        $obs =trim($_POST['obs']);
        $razon = trim($_POST['razon']);
        $idForm=$_POST['Idformulario'];
        $creador ="UsuarioLogin";
        $campos = array( 'dsc_oficina','pais_id', 'ciudad_id', 'ruc', 'dsc_manager', 'direccion', 'mail', 'fe_contrato', 'telefono1', 'telefono2', 'tel_movil', 'obs', 'tipo', 'cod_remax', 'cod_remaxlegacy', 'cobro_fee_desde', 'razon', 'creador');
        $valores="'".$oficina."', '".$pais."', '".$ciudad."', '".$ruc."', '".$manager."', '".$direccion."', '".$email."', '".$fe_contrato."', '".$tel1."', '".$tel2."', '".$celular."', '".$obs."', '".$tipo."', '".$cod_remax."', '".$cod_remaxlegacy."', '".$cobro_fee_desde."', '".$razon."', '".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('oficina',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('oficina',$campos,$valores);
        }
    }
}
?>
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
        $("#tipoOperacion").on("change",function (){cambiar()});
    }
    $(document).ready( function() {
        inicializar();
        $("#cabecera-operacion").css("display","none");
        $("#detalle-operacion").css("display","none");
        $("#distribucion-operacion").css("display","none");

    });
    function cambiar(){
        alert($("#tipoOperacion").val().toUpperCase());
        switch ($("#tipoOperacion").val().toUpperCase()) {
            case "COMPARTIDA":

                break;
            case "INDIVIDUAL":

                break;
            case "OTRO":

                break;
            default:

        }
        /*
            mostrar o no mostrar campos para los distintos tipos de operacion
        */
    }
    function cambiarVista(valor){
        console.log("test"+valor);
        switch (valor) {
            case 1:
                $("#cabecera-operacion").css("display","");
                $("#detalle-operacion").css("display","none");
                $("#distribucion-operacion").css("display","none");
                break;
            case 2:
                $("#cabecera-operacion").css("display","none");
                $("#detalle-operacion").css("display","");
                $("#distribucion-operacion").css("display","none");
                break;
            case 3:
                $("#cabecera-operacion").css("display","none");
                $("#detalle-operacion").css("display","none");
                $("#distribucion-operacion").css("display","");
                break;
            default:

        }
    }

  </script>

</html>
