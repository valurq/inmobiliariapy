<?php
     //INICIALIZACION DE VARIABLES
      session_start();
      include("Parametros/conexion.php");
      include("Parametros/verificarConexion.php");
      $consultas = new Consultas();
      $cobro_alquiler_id = 0;
      $moneda_list = array();
      $inputsVal = array();
      $campos = array('id_remax','moneda_id','fecha','monto','referencia','obs','fe_vto',
      'estado','saldo');
      $inputsId =  array('id_remax','moneda_id','fecha','monto','referencia','obs','fe_vto',
      'estado','saldo');

      /*IMPORTANTE:
      =========================================================================================== */
      /*ya no se verifica isset($_POST['seleccionado']) ya que no se puede llegar a este formulario 
      sin haber seleccionado algun registro (fallara si no esta activado javascript)*/

      $cobro_alquiler_id = $_POST['seleccionado'];
      $accion = $_POST['accion'];      

      $tmpdatos = $consultas->consultarDatos($campos,'v_cobrosalquiler_propiedades',"","id",$cobro_alquiler_id);
      //ver de controlar mejor este caso
      if(gettype($tmpdatos)!="boolean"){
        $inputsVal = $tmpdatos->fetch_array(MYSQLI_NUM);
      }

      //Obtencion de las monedas{
        $aux = $consultas->consultarDatos(array('id','simbolo'),'moneda');
        if(gettype($aux)!="boolean"){
          while($row = $aux->fetch_assoc()){
            array_push($moneda_list,$row);
          }
        }
        
        //si no hay monedas marcamos como indefinido
        if(count($moneda_list)<=0){
          $moneda_list = array ( 
            0 => array(
              "id" => "INDEFINIDO",
              "simbolo" => "INDEFINIDO"
            ) 
          );
        }
      //}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Módulo de Cobros de Alquiler</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <link rel="stylesheet" href="CSS/text_styles.css">
    <link rel="stylesheet" href="CSS/popup.css">
    <script src="Js/jquery-3.4.0.js"></script>
    <script type="text/javascript" src="Js/funciones.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </head>

  <body class="container">  
    <!-- Titulo del Formulario -->  
    <h5 class="text-left mt-3 mb-3 text-muted">Cobro de Alquiler</h5>

    <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
    <form name="CLIENT_FORM" method="POST" onsubmit="return verificar();" >

    <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
      <input type="hidden" name="seleccionado" id="seleccionado" value=<?php echo $cobro_alquiler_id;?> >
    <!--Campo oculto para no perder la ccion-->
      <input type="hidden" name="accion" id="accion" value=<?php echo $accion;?> >
    <!-- Campos del Formulario-->
      <div class="row mt-3">
        <div class="col-sm-6">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text border border-0 bg-white">
                Fecha:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </span>
            </div>
            <input class="form-control" type="date" name="fecha" id="fecha" readonly>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text border border-0 bg-white">Fecha de Vencimiento:</span>
            </div>
            <input class="form-control" type="date" name="fe_vto" id="fe_vto" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="input-group input-group-sm mt-3">
            <div class="input-group-prepend">
              <span class="input-group-text border border-0 bg-white">Propiedad:</span>
            </div>
            <input type="text" name="id_remax" id="id_remax" class="form-control" readonly>
          </div>
        </div>
        <div class="col-sm-6"></div>
      </div>
      <div class="row mt-3">
        <div class="col-sm-6">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text border border-0 bg-white">
                Monto:
                &nbsp;&nbsp;&nbsp;&nbsp;
              </span>
            </div>
            <input class="form-control" name="monto" id="monto" type="text" readonly>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text border border-0 bg-white">
                Moneda:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </span>
            </div>
            <select name="moneda_id" id="moneda_id" class="form-control" disabled>
              <?php foreach($moneda_list as $element): ?>
                  <option value="<?php echo $element['id']; ?>">
                      <?php echo $element['simbolo']; ?>
                  </option>
              <?php endforeach; ?>>
            </select>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-sm-6">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text border border-0 bg-white">
                Estado:
                &nbsp;&nbsp;&nbsp;&nbsp;
              </span>
            </div>
            <select name="estado" id="estado" class="form-control" disabled>
              <option value="Pendiente">Pendiente</option>
              <option value="Pagado">Pagado</option>
            </select>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text border border-0 bg-white">
                Referencia:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
              </span>
            </div>
            <textarea class="form-control" name="referencia" id="referencia" rows="1" readonly></textarea>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-sm-6">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text border border-0 bg-white">
                Saldo:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </span>
            </div>
            <input type="text" class="form-control" name="saldo" id="saldo" readonly>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text border border-0 bg-white">
                Observaciones:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </span>
            </div>
            <textarea class="form-control" name="obs" id="obs" rows="1" readonly></textarea>
          </div>
        </div>
      </div>

      <!--A partir de aqui se muestran los campos usados para cobrar
      =============================================================-->
      <?php if($accion == "cobrar"): ?>
        <h5 class="text-left mt-5 mb-3 text-muted">Pago de Alquiler</h5>
        <div class="row">
          <div class="col-sm-6">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text border border-0 bg-white">Nro. Comprobante:</span>
              </div>
              <input name="nro_comprob" id="nro_comprob" class="form-control">
              <div class="valid-feedback">Correcto.</div>
              <div class="invalid-feedback">Debe indicar el numero de comprobante.</div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text border border-0 bg-white">Forma de Pago:</span>
              </div>
              <select name="forma_pago" id="forma_pago" class="form-control">
                <option value="Efectivo">Efectivo</option>
                <option value="Cheque">Cheque</option>
                <option value="Transferencia">Transferencia</option>
                <option value="Otros">Otros</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-6">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text border border-0 bg-white">
                  Monto a Pagar:
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>
              </div>
              <input type="text" name="monto_pagar" id="monto_pagar" class="form-control">
              <div class="valid-feedback">Correcto.</div>
              <div class="invalid-feedback">El monto igresado es invalido.</div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text border border-0 bg-white">
                  Moneda:
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>
              </div>
              <select name="moneda_id_pago" id="moneda_id_pago" class="form-control" onchange="checkMoneda()">
                <?php foreach($moneda_list as $element): ?>
                    <option value="<?php echo $element['id']; ?>">
                        <?php echo $element['simbolo']; ?>
                    </option>
                <?php endforeach; ?>>
              </select>
              <div class="valid-feedback">Correcto.</div>
              <div class="invalid-feedback">No hay cotizacion válida para la moneda.</div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-6">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text border border-0 bg-white">
                  Fecha:
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>
              </div>
              <input type="date" name="fecha_pago" id="fecha_pago" class="form-control">
              <div class="valid-feedback">Correcto.</div>
              <div class="invalid-feedback">Indique la fecha del cobro.</div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text border border-0 bg-white">
                  Observaciones:
                </span>
              </div>
              <textarea name="obs" id="obs" class="form-control" rows="1"></textarea>
            </div>
          </div>
        </div>
        <!--SECCION: CAMPO OCULTOS-->
        <input type="hidden" name="cotiz_venta" id="cotiz_venta" value="0">
        <!--FIN SECCION: CAMPOS OCULTOS-->
      <?php endif; ?>
      
      <!--Botones del formulario-->
      <?php if($accion=="cobrar"): ?>
        <div class="row mt-3">
          <div class="col-sm-6 mt-3 text-center">
            <input type="submit" class="btn btn-sm btn-info" value="Confirmar Pago" name="submit_cobro_alquiler">
          </div>
          <div class="col-sm-6 mt-3 text-center" onclick="location='cobros_alquiler_panel.php';">
            <button type="button" class="btn btn-sm btn-info">Volver</button>
          </div>
        </div>
      <?php else: ?>
        <div class="row mt-3 text-center">
          <div class="col-sm-12 mt-3" onclick="location='cobros_alquiler_panel.php';">
            <button type="button" class="btn btn-sm btn-info">Volver</button>
          </div>
        </div>
      <?php endif; ?>
      
      
      <!--Fin Botones del formulario-->

    </form>

      <!-- Fin titulos y etiquetas -->

  </body>

  <script type="text/javascript">
    //======================================================================
    // FUNCION QUE VALIDA EL FORMULARIO
    //======================================================================
      function verificar(){
        var ok = true;
        var monto_pagar = document.getElementById("monto_pagar");
        var nro_comprob = document.getElementById("nro_comprob");
        var fecha_pago = document.getElementById("fecha_pago");
        var moneda_id_pago = document.getElementById("moneda_id_pago");
        var moneda_id = document.getElementById("moneda_id");
        var saldo = document.getElementById("saldo");
        var cotiz_venta = document.getElementById("cotiz_venta");

        if(cotiz_venta.value == "0"){
          esInvalido(moneda_id_pago);
          ok = false;
        }else{
          esValido(moneda_id_pago);
          if(moneda_id_pago.value == "INDEFINIDO"){
            esInvalido(moneda_id_pago);
            ok = false;
          }else{
            esValido(moneda_id_pago);
          }
        }

        if(monto_pagar.value <= 0  || monto_pagar.value == "" || isNaN(monto_pagar.value)){
          esInvalido(monto_pagar);
          ok = false;
        }else{
          //para hacer esta validacion debemos saber que ambos valores son numeros válidos
          if(parseFloat(monto_pagar.value)*parseFloat(cotiz_venta.value) > parseFloat(saldo.value)){
            esInvalido(monto_pagar);
            ok = false;
          }else{
            esValido(monto_pagar); 
          }
        }

        if(nro_comprob.value == ""){
          esInvalido(nro_comprob);
          ok = false;
        }else{
          esValido(nro_comprob);
          
        }

        if(fecha_pago.value == ""){
          esInvalido(fecha_pago);
          ok = false;
        }else{
          esValido(fecha_pago);
          
        }

        return ok;

      }

      //se encarga de chequear las monedas con que se opera, si son diferentes, 
      //se trae de la base de datos la cotizacion de la moneda con que se esta pagando
      function checkMoneda(resultado = ""){
        var moneda_id_pago = document.getElementById("moneda_id_pago");
        var moneda_id = document.getElementById("moneda_id");
        var max_id = "(SELECT MAX(id) FROM cotizacion WHERE moneda_id="+moneda_id_pago.value+")";
        var where = " WHERE id="+max_id;
        var campos = ["cotiz_venta"];
        if(resultado == ""){
          if(moneda_id.value != moneda_id_pago.value){  
            /*<ASINCRONO>---------------------------------------------------------------------------------*/
            busquedaLibre(campos,"cotizacion",where,checkMoneda);
            /*</ASINCRONO>--------------------------------------------------------------------------------*/
          }else{
            document.getElementById("cotiz_venta").value = "1";
            esValido(moneda_id_pago);
          }
        }else{
          if(resultado.length > 1){
            if(isNaN(resultado[1][1])){
              ok = false;
              esInvalido(moneda_id_pago);
              document.getElementById("cotiz_venta").value = 0;
            }else{
              document.getElementById("cotiz_venta").value = resultado[1][1];
              esValido(moneda_id_pago);
            }  
          }else{
            ok = false;
            esInvalido(moneda_id_pago);
            document.getElementById("cotiz_venta").value = 0;
          } 
        }
      }
  </script>

</html>

<?php
  //var_dump($_POST);

  //cuando el id es distinto de cero el form fue llamado para edicion, cargar campos entonces
  if(($cobro_alquiler_id!=0 and !empty($inputsVal))){
      /*
          CONVERTIR LOS ARRAY A UN STRING PARA PODER ENVIAR POR PARAMETRO A LA FUNCION JS
      */
      $inputsVal = implode(",",$inputsVal);
      $inputsId = implode(",",$inputsId);
      echo '<script>cargarCampos("'.$inputsId.'","'.$inputsVal.'")</script>';
      echo "<script>checkMoneda();</script>";
  }else{
    //echo "are im a joke to you";
  }

  //Creación o Modificación de Clientes en la BD
  if(isset($_POST['submit_cobro_alquiler'])){
        //parametros de insercion/modificacion
        $fecha = $_POST["fecha_pago"];
        $nro_comprob = $_POST["nro_comprob"];
        $obs = $_POST['obs'];
        $forma_pago = $_POST["forma_pago"];
        $moneda_id = $_POST["moneda_id_pago"];
        $monto = $_POST["monto_pagar"];
        $saldo  = $_POST["saldo"];
        $idForm = $_POST['seleccionado'];
        $cotiz_venta = $_POST["cotiz_venta"];
        $creador = "nn"; //debe obtenerse de $_SESSION

        $saldo_actual = $saldo - $monto*$cotiz_venta;

        $campos_pago = array('moneda_id','cobros_alquiler_id','fecha','nro_comprob','monto','obs',
       'forma_pago','creador','cotizacion');
       $valores_pago = "$moneda_id,$idForm,'$fecha','$nro_comprob',$monto,'$obs',
       '$forma_pago','$creador',$cotiz_venta";

        if($saldo_actual > 0){
          $campos_cobro = array('saldo');
          $valores_cobro = "$saldo_actual";
        }else{
          $campos_cobro = array('saldo','estado');
          $valores_cobro = "$saldo_actual,'Pagado'";
        }
        
        //solo se va a modificar el saldo si efectivamente se inserto la cobranza
        if($consultas->insertarDato('cobranza',$campos_pago,$valores_pago)){
          $consultas->modificarDato('cobros_alquiler',$campos_cobro,$valores_cobro,'id',$idForm);
        }
        echo "<script>window.location='cobros_alquiler_panel.php'</script>" ;
    }
?>