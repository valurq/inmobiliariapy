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
            $campos=array('nombrefull','porcentaje_opera','fe_ingreso','obs','apellido','oficina_id','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)','usuario_id','(SELECT usuario FROM usuario WHERE id=usuario_id)', 'oficina_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'manager',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('nombrefull','porcentaje_opera','fe_ingreso','obs','apellido','oficina','oficinaLista','usuario','usuarioLista', 'oficina_anterior');
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
          span.warning{
            color: #C72F36;
            font-size: 16px;
            background-color: rgba(237,173,175, 0.3);
            padding: 3px;
            border-radius: 5px;
            border: 1px solid #C72F36;
          }
        </style>
</head>
<body style="background-color:white">
  <h2>MANAGER</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <?php 
        if ($id == 0) {
          echo '<tr><td colspan="2"><span class="warning">Observación: para crear la ficha de manager, primero debe crear el usuario y la oficina</span></td></tr>';
        }
       ?>
      <tr>
        <td><label for="">Usuario</label></td>
        <td><input list="usuLista" id="usuarioLista" name="usuarioNombre" autocomplete="off" placeholder="Ingrese el nombre de usuario" onkeyup="buscarListaQ(['usuario'], this.value,'usuario', 'usuario', 'usuLista', 'usuario', 'asignado', 'NO') " class="campos-ingreso">
        <datalist id="usuLista">
          <option value=""></option>
        </datalist>
        <input type="hidden" name="usuario" id="usuario"></td>
      </tr>
      <tr>
        <td><label for="">Nombre</label></td>
        <td><input type="text" name="nombrefull" id="nombrefull" value="" readonly="readonly" placeholder="Ingrese su nombre" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td> <label for="">Apellido</label> </td>
        <td> <input type="text" name="apellido" id='apellido' value="" readonly="readonly" placeholder="Ingrese su apellido" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Oficina</label></td>
         <td>
        <input list="ofiLista" id="oficinaLista" name="oficinaNombre" autocomplete="off" placeholder="Ingrese el nombre de la oficina" onkeyup="buscarListaQ(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'ofiLista', 'oficina', ['estado', 'tipo', 'dsc_manager'], ['ACTIVO', 'RE/MAX', '']) " class="campos-ingreso">
        <datalist id="ofiLista">
          <option value=""></option>
        </datalist>
      <input type="hidden" name="oficina" id="oficina">

      <input type="hidden" name="oficina_anterior" id="oficina_anterior">
    </td>
      </tr>
      <tr>
        <td><label for="">Comisión sobre operaciones</label></td>
        <td><input type="number" name="porcentaje_opera" id="porcentaje_opera" placeholder="Ingrese el porcentaje sobre las operaciones" step="any" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha Ingreso</label></td>
        <td><input type="date" name="fe_ingreso" id="fe_ingreso" value="" class="campos-ingreso"></td>
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
  <input name="volver" type="button" value="Volver" onclick = "location='manager_panel.php';"  class="boton-formulario">
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


  if (isset($_POST['nombrefull'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['nombrefull'])){
        $nombrefull =trim($_POST['nombrefull']);
        $apellido =trim($_POST['apellido']);
        $oficina =trim($_POST['oficina']);
        $oficina_anterior = trim($_POST['oficina_anterior']);
        $porcentaje_opera =trim($_POST['porcentaje_opera']);
        $fe_ingreso =trim($_POST['fe_ingreso']);
        $obs =trim($_POST['obs']);
        $usuario_id =trim($_POST['usuario']);
        $idForm=$_POST['Idformulario'];
        //$creador    ="UsuarioLogin";
        $campos = array('nombrefull','oficina_id','porcentaje_opera','fe_ingreso','obs','usuario_id','apellido');//,'creador' );
        $camposOfi = array('nombrefull');
        $valores="'".$nombrefull."','".$oficina."','".$porcentaje_opera."','".$fe_ingreso."','".$obs."','".$usuario_id."','".$apellido."'";
        $valoresOfi="'".$nombrefull."'";
        //echo "$valores";
        //print_r($campos);

        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('manager',$campos,$valores,'id',$idForm);
            if($oficina != $oficina_anterior)
              $inserta_Datos->modificarDatoQ('oficina', ['dsc_manager'],[' '],'id',$oficina_anterior);

            $inserta_Datos->modificarDatoQ('oficina', ['dsc_manager'],[$nombrefull.' '.$apellido],'id',$oficina);


        }else{
            $inserta_Datos->insertarDato('manager',$campos,$valores);
            $inserta_Datos->modificarDatoQ('oficina', ['dsc_manager'],[$nombrefull.' '.$apellido],'id',$oficina);
            $inserta_Datos->modificarDatoQ('usuario', ['asignado'], ['SI'], 'id', $usuario_id);
        }
    }
}
?>
<script type="text/javascript">

    let idForm = '<?php echo $id ?>';
    if(idForm != 0){
      document.getElementById('usuarioLista').setAttribute('readonly', 'readonly');
      console.log(idForm);
    }

    document.getElementById('usuarioLista').addEventListener('focusout', (e) => {
    idUsuario = document.getElementById('usuario').value;
    obtenerDatosCallBackQuery(`SELECT nombre, apellido FROM usuario WHERE id = ${idUsuario}`, resultado => {
      document.getElementById('nombrefull').value = resultado[0][0];
      document.getElementById('apellido').value = resultado[0][1];
    });
  });

//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if($('#nombrefull').val() == ""){
      popup('Advertencia','Es necesario ingresar el nombre del manager!!') ;
      return false ;
    }else if($("#apellido").val()==""){
      popup('Advertencia','Es necesario ingresar el apellido del manager!!') ;
      return false ;
    }else if($("#oficina").val()==""){
      popup('Advertencia','Es necesario ingresar de la oficina correspondiente!!') ;
      return false ;
    }else if($("#usuario").val()==""){
      popup('Advertencia','Es necesario ingresar el usuario del manager!!') ;
      return false ;
    }else if($("#porcentaje_opera").val()==""){
      popup('Advertencia','Es necesario ingresar la comisión sobre las operaciones!!') ;
      return false ;
    }else if($("#porcentaje_opera").val() > 100 ){
      popup('Advertencia','El porcentaje de la comisión no puede ser mayor a 100!!') ;
      return false ;
    }else if($("#fe_ingreso").val() == "" ){
      popup('Advertencia','Debe ingresar la fecha de ingreso!!') ;
      return false ;
    }else if (parseInt($("#porcentaje_opera").val())>10) {
      popup('Advertencia','Debe ingresar valor menores o iguales a 10!!') ;
      return false ;
    }else{
      return true;
    }
	}

  </script>

</html>
