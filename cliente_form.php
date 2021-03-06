<?php
//INICIALIZACION DE VARIABLES
session_start();
include("Parametros/conexion.php");
//include("Parametros/verificarConexion.php");
$consultas = new Consultas();
$cliente_id = 0;
$paises_list = array();
$ciudades_list = array();
$campos = array();
$inputsId = array();
$inputsVal = array();
$btn_label = "Crear Cliente";
/*
      SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
      ========================================================================
      */
if (isset($_POST['seleccionado'])) {
  $cliente_id = $_POST['seleccionado'];
  $campos = array(
    'pais_id', 'ciudad_id', 'dsc_cliente', 'apellido', 'ci_ruc', 'direccion', 'mail', 'telefono1', 'telefono2', 'telefono3',
    'sitioweb', 'obs'
  );
  $inputsId =  array(
    'pais', 'ciudad', 'dsc_cliente', 'apellido', 'ci_ruc', 'direccion', 'mail', 'telefono1', 'telefono2', 'telefono3',
    'sitioweb', 'obs'
  );
  //echo "ID ". $cliente_id;
  $tmpdatos = $consultas->consultarDatos($campos, 'cliente', "", "id", $cliente_id);
  //ver de controlar mejor este caso
  if (gettype($tmpdatos) != "boolean") {
    $inputsVal = $tmpdatos->fetch_array(MYSQLI_NUM);
  } else {
    //echo "Vacio como el corazon de ella";
  }
}
//para el label del boton
if (isset($_POST['seleccionado'])) {
  if ($_POST['seleccionado'] != 0) {
    $btn_label = "Modificar Cliente";
  }
}
if (isset($_POST['idformulario'])) {
  if ($_POST['idformulario'] != 0) {
    $btn_label = "Modificar Cliente";
  }
}
//Obtencion de paises
$aux = $consultas->consultarDatos(array('id', 'dsc_pais'), 'pais');
if (gettype($aux) != "boolean") {
  while ($row = $aux->fetch_assoc()) {
    array_push($paises_list, $row);
  }
}

if (count($paises_list) <= 0) {
  $paises_list = array(
    0 => array(
      "id" => "INDEFINIDO",
      "dsc_pais" => "INDEFINIDO"
    )
  );
}

//para diferenciar por que pais filtrar las ciudades cuando se entra a modificar y se entra a crear respectivamente
if (!empty($inputsVal)) {
  $pais_actual = $inputsVal[0];
} else {
  $pais_actual = $paises_list[0]["id"];
}

//obtencion de ciudades
$aux = $consultas->consultarDatos(array('id', 'dsc_ciudad'), 'ciudad', '', 'pais_id', $pais_actual);
if (gettype($aux) != "boolean") {
  while ($row = $aux->fetch_assoc()) {
    array_push($ciudades_list, $row);
  }
}

if (count($ciudades_list) <= 0) {
  $ciudades_list = array(
    0 => array(
      "id" => "INDEFINIDO",
      "dsc_ciudad" => "INDEFINIDO"
    )
  );
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
  <title>Módulo de Cliente</title>
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
  <h5 class="text-left mt-3 mb-3 text-muted">Crear Cliente</h5>

  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
  <form name="CLIENT_FORM" method="POST" onsubmit="return verificar();">

    <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="idformulario" id="idformulario" value=<?php echo $cliente_id; ?>>
    <!-- Campos del Formulario-->
    <div class="row">
      <div class="col-sm-6">
        <div class="input-group input-group-sm mt-3">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Nombre/s: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <input type="text" class="form-control" name="dsc_cliente" id="dsc_cliente" maxlength="58">
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">Por favor, indique el apellido del cliente.</div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="input-group input-group-sm mt-3">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Apellido/s:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;
            </span>
          </div>
          <input class="form-control" name="apellido" id="apellido" type="text" maxlength="58">
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">Por favor, indique el apellido del cliente.</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              C.I o R.U.C:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <input class="form-control" name="ci_ruc" id="ci_ruc" type="text" maxlength="30">
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">Por favor, indique la cédula o el ruc del cliente.</div>
        </div>
      </div>
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Correo electrónico:&nbsp;
            </span>
          </div>
          <input class="form-control" name="mail" id="mail" type="text" maxlength="60">
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">Por favor, indique el correo electrónico del cliente.</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              País:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <select class="form-control" name="pais" id="pais" onchange="buscarCiudades();">
            <?php foreach ($paises_list as $element) : ?>
              <option value="<?php echo $element['id']; ?>">
                <?php echo $element['dsc_pais']; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">No hay paises definidos.</div>
        </div>
      </div>
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Ciudad:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <select class="form-control" name="ciudad" id="ciudad">
            <?php foreach ($ciudades_list as $element) : ?>
              <option value="<?php echo $element['id']; ?>">
                <?php echo $element['dsc_ciudad']; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">No hay ciudades definidas.</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Teléfono 1:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <input class="form-control" name="telefono1" id="telefono1" type="text" maxlength="30">
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">Por favor, indique al menos un número de teléfono correctamente.</div>
        </div>
      </div>
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Teléfono 2:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <input class="form-control" name="telefono2" id="telefono2" type="text" maxlength="60">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Teléfono 3:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <input class="form-control" name="telefono3" id="telefono3" type="text" maxlength="60">
        </div>
      </div>
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Dirección:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;
            </span>
          </div>
          <input class="form-control" name="direccion" id="direccion" type="text" maxlength="30">
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">Por favor, indique la dirección cliente.</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Observaciones:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <textarea class="form-control" name="obs" id="obs" rows="1"></textarea>
        </div>
      </div>
      <div class="col-sm-6 mt-3">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text border border-0 bg-white">
              Sitio Web:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <input class="form-control" name="sitioweb" id="sitioweb" type="text" maxlength="30">
        </div>
      </div>
    </div>

    <!--Fin campos de formulario-->

    <!--Botones del formulario-->
    <div class="row ml-1 mt-2">
      <div class="col-sm-6 mt-3 text-center">
        <input type="submit" id="submit_button" class="btn btn-sm btn-info" value="<?php echo $btn_label; ?>" name="submit_cliente">
      </div>
      <div class="col-sm-6 mt-3 text-center" onclick="location='cliente_panel.php';">
        <button type="button" class="btn btn-sm btn-info">Volver</button>
      </div>
    </div>

    <!--Fin Botones del formulario-->

  </form>

  <!-- Fin titulos y etiquetas -->

</body>

<script type="text/javascript">
  //======================================================================
  // FUNCION QUE VALIDA EL FORMULARIO
  //======================================================================
  function verificar() {
    var ok = true;
    var dsc_cliente = document.getElementById("dsc_cliente");
    var apellido = document.getElementById("apellido");
    var ci_ruc = document.getElementById("ci_ruc");
    var mail = document.getElementById("mail");
    var direccion = document.getElementById("direccion");
    var pais = document.getElementById("pais");
    var ciudad = document.getElementById("ciudad");
    var telefono1 = document.getElementById("telefono1");
    if ((dsc_cliente.value == '' || dsc_cliente.length > 60)) {
      esInvalido(dsc_cliente);
      ok = false;
    } else {
      esValido(dsc_cliente);
    }
    if ((apellido.value == '' || apellido.length > 60)) {
      esInvalido(apellido);
      ok = false;
    } else {
      esValido(apellido);
    }
    if ((ci_ruc.value == '')) {
      esInvalido(ci_ruc);
      ok = false;
    } else {
      esValido(ci_ruc);
    }
    if (!validateEmail(mail.value) || mail.value == '') {
      esInvalido(mail);
      ok = false;
    } else {
      esValido(mail);
    }

    if ((direccion.value == '' || direccion.length > 100)) {
      esInvalido(direccion);
      ok = false;
    } else {
      esValido(direccion);
    }

    //si tiene INDEFINIDO como texto es que no hay paises en la DB
    if ((pais.options[0].text == 'INDEFINIDO')) {
      esInvalido(pais);
      ok = false;
    } else {
      esValido(pais);
    }
    //si tiene INDEFINIDO como texto es que no hay ciudades en la DB
    if ((ciudad.options[0].text == 'INDEFINIDO')) {
      esInvalido(ciudad);
      ok = false;
    } else {
      esValido(ciudad);
    }
    if (telefono1.value == '' || isNaN(telefono1.value)) {
      esInvalido(telefono1);
    } else {
      esValido(telefono1);
    }
    return ok;
  }

  function buscarCiudades(retorno = "") {
    var paises = document.getElementById("pais");
    var ciudades = document.getElementById("ciudad");
    var c = 1;
    var option = null;
    if (retorno == "") {
      //limpiamos las ciudades actuales
      var k = 0;
      while (k < ciudades.length) {
        ciudades.remove(k);
      }
      //obtenemos el pais seleccionado y realizamos la busqueda
      var pais_id = pais.options[pais.selectedIndex].value;
      var campos = ["dsc_ciudad"];
      busquedaLibre(campos, "ciudad", " WHERE pais_id = " + pais_id, buscarCiudades);
    } else {
      if (retorno.length > 1) {
        while (c < retorno.length) {
          option = document.createElement("option");
          option.value = retorno[c][0];
          option.text = retorno[c][1];
          ciudades.add(option);
          c++;
        }
      } else {
        option = document.createElement("option");
        option.value = "INDEFINIDO";
        option.text = "INDEFINIDO";
        ciudades.add(option);
      }
    }
  }

  //Código para que cuando se intente crear un cliente este seleccionado por default el pais PARAGUAY
  var btn = document.getElementById(id = "submit_button");
  if (btn.value == "Crear Cliente") {
    var opts_paises = document.getElementById("pais");
    for (i = 0; i < opts_paises.length; i++) {
      var nombre = opts_paises[i].text.toLowerCase();
      if (nombre.indexOf("paraguay") != -1) {
        opts_paises.selectedIndex = i;
        buscarCiudades();
      }
    }
  }
</script>

</html>

<?php
//var_dump($_POST);
//cuando el id es distinto de cero el form fue llamado para edicion, cargar campos entonces
if (($cliente_id != 0 and !empty($inputsVal))) {
  /*
          CONVERTIR LOS ARRAY A UN STRING PARA PODER ENVIAR POR PARAMETRO A LA FUNCION JS
      */
  $inputsVal = implode(",", $inputsVal);
  $inputsId = implode(",", $inputsId);
  echo '<script>cargarCampos("' . $inputsId . '","' . $inputsVal . '")</script>';
} else {
  //echo "are im a joke to you";
}
//Creación o Modificación de Clientes en la BD
if (isset($_POST['submit_cliente'])) {
  //parametros de insercion/modificacion
  $pais  = $_POST["pais"];
  $ciudad  = $_POST["ciudad"];
  $dsc_cliente = $_POST["dsc_cliente"];
  $apellido = $_POST["apellido"];
  $ci_ruc = $_POST["ci_ruc"];
  $direccion = $_POST["direccion"];
  $mail = $_POST["mail"];
  $telefono1 = $_POST["telefono1"];
  $telefono2 = $_POST["telefono2"];
  $telefono3 = $_POST["telefono3"];
  $creador = "usuarioLogin"; //deber ser con $_SESSION
  $sitioweb = $_POST["sitioweb"];
  $obs = $_POST["obs"];
  //solo usado para las modificaciones
  $idForm = $_POST['idformulario'];
  $campos = array(
    'pais_id', 'ciudad_id', 'dsc_cliente', 'apellido', 'ci_ruc', 'direccion', 'mail', 'telefono1', 'telefono2', 'telefono3',
    'sitioweb', 'obs'
  );
  $valores = "$pais,$ciudad,'$dsc_cliente', '$apellido' ,'$ci_ruc','$direccion','$mail','$telefono1','$telefono2','$telefono3'," .
    "'$sitioweb','$obs'";

  //update o insert dependiend de las circunstancias
  if (isset($idForm) && ($idForm != 0)) {
    $consultas->modificarDato('cliente', $campos, $valores, 'id', $idForm);
  } else {
    //el creador solo se debe setear cuando se esta creando el cliente
    array_push($campos, "creador");
    $valores .= ",'$creador'";
    $consultas->insertarDato('cliente', $campos, $valores);
  }
  echo "<script>window.location='cliente_panel.php'</script>";
}
?>