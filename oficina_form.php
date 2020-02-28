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
            $campos=array( 'dsc_oficina', 'ruc', 'dsc_manager', 'direccion', 'mail', 'fe_contrato', 'telefono1', 'telefono2', 'tel_movil', 'obs', 'tipo', 'cod_remax', 'cod_remaxlegacy', 'cobro_fee_desde', 'razon', '(SELECT dsc_pais FROM pais WHERE id = pais_id)','pais_id', '(SELECT dsc_ciudad FROM ciudad WHERE id = ciudad_id)','ciudad_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'oficina',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('oficina','ruc','manager','direccion','email','fe_contrato','tel1','tel2','celular','obs','tipo', 'cod_remax','cod_remaxlegacy','cobro_fee_desde', 'razon', 'pais_lista', 'pais_id', 'ciudad_lista', 'ciudad_id');
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
</head>
<body style="background-color:white">
  <h2>DEFINICIÓN DE OFICINA</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->

<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
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
            <input list="pais" id="pais_lista" name="pais_lista" autocomplete="off" placeholder="Ingrese el nombre del pais" class="campos-ingreso" onkeyup="buscarListaQ(['dsc_pais'], this.value,'pais', 'dsc_pais', 'pais', 'pais_id')" >
            <datalist id="pais">
              <option value=""></option>
            </datalist>
          </td>

        <td><label for="">Razón Social</label></td>
        <td>
          <input type="text" name="razon" id="razon" value="" placeholder="Ingrese la razón social" class="campos-ingreso">
        </td>

        <td>
            <input type="hidden" name="pais_id" id="pais_id">
          </td>
      </tr>
      <tr>
        <td><label for="">Ciudad</label></td>
          <td>
            <input list="ciudad" id="ciudad_lista" name="ciudad_lista" autocomplete="off" placeholder="Ingrese el nombre de la ciudad" class="campos-ingreso" onkeyup="buscarListaQ(['dsc_ciudad'], this.value,'ciudad', 'dsc_ciudad', 'ciudad', 'ciudad_id', 'pais_id', document.getElementById('pais_id').value)" >
            <datalist id="ciudad">
              <option value=""></option>
            </datalist>
          </td>

        <td><label for="">Manager</label></td>
        <td><input type="text" name="manager" id="manager" value=""  readonly placeholder="Nombre del manager" class="campos-ingreso"></td>

        <td>
            <input type="hidden" name="ciudad_id" id="ciudad_id">
          </td>

      </tr>
      <tr>
        <td><label for="">Dirección</label></td>
        <td><input type="text" name="direccion" id="direccion" value="" placeholder="Ingrese la dirección de la oficina" class="campos-ingreso"></td>

        <td><label for="">Broker</label></td>
        <td><input type="text" name="broker" id="broker" value=""  readonly placeholder="Nombre del broker" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha de contrato</label></td>
        <td><input type="date" name="fe_contrato" id="fe_contrato" value="" placeholder="Ingrese la fecha de contrato" class="campos-ingreso"></td>
        <td><label for="">Email</label></td>
        <td><input type="email" name="email" id="email" value="" placeholder="Ingrese el email" class="campos-ingreso"></td>

      </tr>
      <tr>
        <td><label for="">Teléfono 1</label></td>
        <td><input type="text" name="tel1" id="tel1" value="" placeholder="Ingrese numero del teléfono" class="campos-ingreso"></td>
        <td><label for="">Teléfono 2</label></td>
        <td><input type="text" name="tel2" id="tel2" value="" placeholder="Ingrese numero del teléfono" class="campos-ingreso"></td>

      </tr>
      <tr>
        <td><label for="">Num. Celular</label></td>
        <td><input type="text" name="celular" id="celular" value="" placeholder="Ingrese numero del celular" class="campos-ingreso"></td>

        <td hidden="hidden"><label for="">Tipo</label></td>
        <td hidden="hidden">
          <select name="tipo" id="tipo">
            <option value="RE/MAX">RE/MAX</option>
          </select>
        </td>

        <td><label for="">Código RE/MAX legacy</label></td>
        <td><input type="text" name="cod_remaxlegacy" id="cod_remaxlegacy" value="" placeholder="Ingrese el código para el informe a DENVER" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Primer cobro del fee</label></td>
        <td><input type="date" name="cobro_fee_desde" id="cobro_fee_desde" value="" placeholder="Ingrese la fecha de inicio del cobro" class="campos-ingreso"></td>

        <td><label for="">Código RE/MAX</label></td>
        <td><input type="text" name="cod_remax" id="cod_remax" value="" placeholder="Ingrese el código internacional REMAX" class="campos-ingreso"></td>
      </tr>
      <tr>

      </tr>
      <tr>
        <td><label for="">Observación</label></td>
        <td><textarea name="obs" id="obs" class="campos-ingreso"></textarea></td>
      </tr>
    </tbody>
  </table>
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
        $pais =trim($_POST['pais_id']);
        $ciudad =trim($_POST['ciudad_id']);
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
        $creador =$_SESSION['usuario'];
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
    }else if($("#ruc").val()==""){
      popup('Advertencia','Es necesario ingresar el ruc de la oficina!!') ;
      return false ;
    }else if($("#pais_id").val()==""){
      popup('Advertencia','Es necesario ingresar el pais al cual pertenece la oficina!!') ;
      return false ;
    }else if($("#pais_lista").val()==""){
      popup('Advertencia','Es necesario ingresar el pais al cual pertenece la oficina!!') ;
      return false ;
    }else if($("#ciudad_id").val()==""){
      popup('Advertencia','Es necesario ingresar la ciudad a la cual pertenece la oficina!!') ;
      return false ;
    }else if($("#ciudad_lista").val()==""){
      popup('Advertencia','Es necesario ingresar la ciudad a la cual pertenece la oficina!!') ;
      return false ;
    }else if($("#direccion").val()==""){
      popup('Advertencia','Es necesario ingresar la direccion!!') ;
      return false ;
    }else if($("#fe_contrato").val()==""){
      popup('Advertencia','Es necesario ingresar la fecha del contrato!!') ;
      return false ;
    }else if($("#email").val()==""){
      popup('Advertencia','Es necesario ingresar el correo electronico!!') ;
      return false ;
    }else if($("#celular").val()==""){
      popup('Advertencia','Es necesario ingresar el número celular!!') ;
      return false ;
    }else if($("#cobro_fee_desde").val()==""){
      popup('Advertencia','Es necesario ingresar la fecha del primer cobro!!') ;
      return false ;
    }else if($("#cod_remax").val()==""){
      popup('Advertencia','Es necesario ingresar el código RE/MAX!!') ;
      return false ;
    }
  }
  </script>

</html>
