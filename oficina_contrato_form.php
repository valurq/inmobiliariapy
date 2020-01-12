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
        $cantidadContratos=0;
        $tipoOficina = "";

        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $cantidadContratos=$inserta_Datos->consultarDatos(array("count(*)"),'contratos',"","oficina_id",$id);
            $cantidadContratos=$cantidadContratos->fetch_array(MYSQLI_NUM);
            $cantidadContratos=$cantidadContratos[0];

            @$cantidadMetas=$inserta_Datos->consultarDatos(array("count(*)"),'metas',"","oficina_id",$id);
            @$cantidadMetas=$cantidadMetas->fetch_array(MYSQLI_NUM);
            @$cantidadMetas=$cantidadMetas[0];

            $campos=array( 'dsc_oficina', 'ruc', '(SELECT nombrefull FROM manager WHERE oficina_id = '.$id.' limit 1)', 'direccion','(SELECT dsc_broker FROM brokers WHERE oficina_id = '.$id.' limit 1)' ,'mail', 'fe_contrato', 'telefono1', 'telefono2', 'tel_movil', 'obs', 'tipo', 'cod_remax', 'cod_remaxlegacy', 'cobro_fee_desde','razon','pais_id','ciudad_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'oficina',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('oficina','ruc','manager','direccion', 'broker','email','fe_contrato','tel1','tel2','celular','obs','tipo', 'cod_remax','cod_remaxlegacy','cobro_fee_desde','razon');

            $tipoOficina = $resultado[11];
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
        <style>
          #contrato, #meta{
            cursor: pointer;
            border: 1px solid black;
            border-radius: 20px;
            padding: 5px 10px;
            box-sizing: border-box;
            width: 100px;
          }

          #contrato:hover, #meta:hover{
            color: white;
            background-color: #16156f;
          }

        </style>
</head>
<body style="background-color:white">
  <h2>DEFINICIÓN DE OFICINA</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form action=<?php echo (($cantidadContratos>0)?"'contrato_panel.php'": "'contrato_form.php'");?>
target="_blank" method="POST" id='form_contrato'>
  <input type="hidden" name='idOfi'  value=<?php echo "'$id'";?>>
</form>

<form action=<?php echo ((@$cantidadMetas>0)?"'meta_panel.php'": "'meta_form.php'");?>
target="_blank" method="POST" id='form_meta'>
  <input type="hidden" name='idOfi'  value=<?php echo "'$id'";?>>
</form>

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
            <?php
            //name, campoId, campoDescripcion, tabla
              if(!(count($resultado)>0)){
                  $inserta_Datos->crearMenuDesplegable('pais', 'id', 'dsc_pais', 'pais');
              }else{
                  $inserta_Datos->DesplegableElegido(@$resultado[16],'pais','id','dsc_pais','pais');
              }
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
              if(!(count($resultado)>0)){
                  $inserta_Datos->crearMenuDesplegable('ciudad', 'id', 'dsc_ciudad', 'ciudad');
              }else{
                  $inserta_Datos->DesplegableElegido(@$resultado[17],'ciudad', 'id', 'dsc_ciudad', 'ciudad');
              }

            ?>
          </td>

        <td><label for="">Manager</label></td>
        <td><input type="text" name="manager" id="manager" value=""  readonly placeholder="Ingrese el nombre del manager" class="campos-ingreso"></td>

      </tr>
      <tr>
        <td><label for="">Dirección</label></td>
        <td><input type="text" name="direccion" id="direccion" value="" placeholder="Ingrese la direccion de la oficina" class="campos-ingreso"></td>

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

        <td><label for="">Tipo</label></td>
        <td>
          <?php
            $inserta_Datos->DesplegableElegidoFijo(@$resultado[11],'tipo',array('REMAX','OTROS'));
          ?>
        </td>


      </tr>
      <tr>
        <td><label for="">Código REMAX legacy</label></td>
        <td><input type="text" name="cod_remaxlegacy" id="cod_remaxlegacy" value="" placeholder="Ingrese el código para el informe a DENVER" class="campos-ingreso"></td>

        <td><label for="">Código REMAX</label></td>
        <td><input type="text" name="cod_remax" id="cod_remax" value="" placeholder="Ingrese el código internacional REMAX" class="campos-ingreso"></td>


      </tr>
      <tr>

        <td><label for="">Primer cobro del fee</label></td>
        <td><input type="date" name="cobro_fee_desde" id="cobro_fee_desde" value="" placeholder="Ingrese la fecha de inicio del cobro" class="campos-ingreso"></td>

      </tr>
      <tr>
        <td><label for="">Observación</label></td>
        <td><textarea name="obs" id="obs" class="campos-ingreso"></textarea></td>
        <td>
          <?php
            if ($tipoOficina != "OTROS") {
              echo "<input type='button' id='contrato' class='boton-formulario' target='_blank' value='Contrato' onclick='document.getElementById(".'"form_contrato"'.").submit();'>";
            }
           ?>
        </td>
        <td>
          <?php
            if ($tipoOficina != "OTROS") {
              echo "<input type='button' id='meta' class='boton-formulario' target='_blank' value='Meta' onclick='document.getElementById(".'"form_meta"'.").submit();'>";
            }
           ?>
        </td>
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
        $campos = array( 'dsc_oficina','pais_id', 'ciudad_id', 'ruc', 'dsc_manager', 'direccion', 'mail', 'fe_contrato', 'telefono1', 'telefono2', 'tel_movil', 'obs', 'tipo', 'cod_remax', 'cod_remaxlegacy', 'cobro_fee_desde', 'razon','creador');
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
  </script>

</html>
