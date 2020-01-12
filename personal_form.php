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
        require "Parametros/Mailer.php";
        $mailer = new Mailer();


        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */

        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos = array( 'nombrefull', 'direccion', 'nro_doc', 'dias_prueba', 'fec_nacim', 'barrio', 'telefono1', 'telefono2','fec_ingreso','obs','(SELECT dsc_ciudad FROM ciudad WHERE id=ciudad_id)','sexo','est_civil','estado','tipo_doc','aprobacion');
            //CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
                $resultado=$inserta_Datos->consultarDatos($campos,'personal',"","id",$id );
                $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */

            $camposIdForm=array( 'nombrefull', 'direccion', 'nro_doc', 'dias_prueba', 'fecha_nacim', 'barrio', 'tel1', 'tel2','fec_ingreso','obs','ciudad','ciudadLista');
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
  <h2>DEFINICIÓN DE PERSONAL</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Nombre</label></td>
        <td><input type="text" name="nombrefull" id="nombrefull" value="" placeholder="Ingrese el nombre del personal" class="campos-ingreso"></td>

        <td><label for="">Tipo de documento</label></td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[14],'tipo_doc',array('Cedula','Pasaporte','Otros'))?></td>
      </tr>
      <tr>
        <td><label for="">Ciudad</label></td>
        <td><input list="ciuLista" id="ciudadLista" name="propiedades" autocomplete="off" onkeyup="buscarLista(['dsc_ciudad'], this.value,'ciudad', 'dsc_ciudad', 'ciuLista', 'ciudad') " class="campos-ingreso">
        <datalist id="ciuLista">
          <option value=""></option>
        </datalist>
      <input type="hidden" name="ciudad" id="ciudad"></td>

      <td><label for="">Numero de documento</label></td>
      <td><input type="text" name="nro_doc" id="nro_doc" value="" placeholder="Ingrese el numero de documento" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td> <label for="">Direccion</label> </td>
        <td> <input type="text" name="direccion" id="direccion" value="" placeholder="Ingrese su direccion" class="campos-ingreso"></td>

        <td><label for="">Dias de Prueba</label></td>
        <td><input type="number" name="dias_prueba" id="dias_prueba" value="" placeholder="Ingrese la cantidad de dias" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha de Nacimiento</label></td>
        <td><input type="date" name="fecha_nacim" id="fecha_nacim" value=""  class="campos-ingreso"></td>

        <td> <label for="">Barrio</label> </td>
        <td> <input type="text" name="barrio" id="barrio" value="" placeholder="Ingrese su barrio" class="campos-ingreso"> </td>
      </tr>
      <tr>
        <td><label for="">Fecha de ingreso</label></td>
        <td><input type="date" name="fec_ingreso" id="fec_ingreso" value=""  class="campos-ingreso"></td>

        <td><label for="">Sexo</label></td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[11],'sexo',array('Masculino','Femenino'))?></td>
      </tr>
      <tr>
        <td><label for="">Teléfono</label></td>
        <td><input type="text" name="tel1" id="tel1" value="" placeholder="Ingrese numero del teléfono" class="campos-ingreso"></td>

        <td><label for="">Celular</label></td>
        <td><input type="text" name="tel2" id="tel2" value="" placeholder="Ingrese numero del teléfono" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td> <label for="">Estado Civil</label> </td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[12],'est_civil',array('Soltero','Casado','Divorciado','Viudo','Otros'))?></td>

        <td> <label for="">Estado</label> </td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[14],'estado',array('Universidad','Agente RE/MAX Paraguay','Agente RE/MAX Internacional'))?></td>
      </tr>
      <tr>
        <td><label for="">Observación</label></td>
        <td><textarea name="obs" id="obs" class="campos-ingreso"></textarea></td>

        <td><label for="">Aprobacion</label></td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[15],'aprobacion',array('Aprobado','Pendiente','Rechazado'))?></td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location= 'personal_panel.php';"  class="boton-formulario">
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
        $tipo_doc =trim($_POST['tipo_doc']);
        $ciudad =trim($_POST['ciudad']);
        $direccion =trim($_POST['direccion']);
        $nro_doc =trim($_POST['nro_doc']);
        $dias_prueba =trim($_POST['dias_prueba']);
        $fecha_nacim =trim($_POST['fecha_nacim']);
        $barrio =trim($_POST['barrio']);
        $fec_ingreso =trim($_POST['fec_ingreso']);
        $sexo =trim($_POST['sexo']);
        $tel1 =trim($_POST['tel1']);
        $tel2 =trim($_POST['tel2']);
        $est_civil =trim($_POST['est_civil']);
        $estado =trim($_POST['estado']);
        $obs =trim($_POST['obs']);
        $aprobacion =(@$_POST['aprobacion']==null)?"":trim($_POST['aprobacion']);
        $idForm=$_POST['Idformulario'];
        $creador ="UsuarioLogin";
        $moneda_id= $inserta_Datos->consultarDatos(array("id"),"moneda","","tipo","Local");
        $moneda_id=$moneda_id->fetch_array(MYSQLI_NUM);
        $moneda_id=$moneda_id[0];
        $usuarioP= $inserta_Datos->consultarDatos(array("id"),"usuario","","usuario","*PROVISORIO*");
        $usuarioP=$usuarioP->fetch_array(MYSQLI_NUM);
        $usuarioP=$usuarioP[0];
        $oficinaProvisorio=$inserta_Datos->consultarDatos(array("id"),"oficina","","dsc_oficina","*PROVISORIO*");
        $oficinaProvisorio=$oficinaProvisorio->fetch_array(MYSQLI_NUM);
        $oficinaProvisorio=$oficinaProvisorio[0];
        $vendedorProvisorio=$inserta_Datos->consultarDatos(array("count(id)"),"vendedor","","nro_doc",$nro_doc);
        $vendedorProvisorio=$vendedorProvisorio->fetch_array(MYSQLI_NUM);
        $vendedorProvisorio=$vendedorProvisorio[0];

        $mail_ti=$inserta_Datos->consultarDatos(array("mail_ti"),"parametros","","","");
        $mail_ti=$mail_ti->fetch_array(MYSQLI_NUM);
        $mail_ti=$mail_ti[0];

        $campos = array( 'nombrefull','tipo_doc', 'ciudad_id', 'direccion', 'nro_doc', 'dias_prueba', 'fec_nacim', 'barrio', 'telefono1', 'telefono2','fec_ingreso','sexo','est_civil','estado','obs','aprobacion','creador');
        $valores="'".$nombrefull."', '".$tipo_doc."', '".$ciudad."', '".$direccion."', '".$nro_doc."', '".$dias_prueba."', '".$fecha_nacim."', '".$barrio."','".$tel1."','".$tel2."','".$fec_ingreso."','".$sexo."','".$est_civil."','".$estado."','".$obs."','".$aprobacion."','".$creador."'";
        $camposV = array( 'dsc_vendedor','nro_doc', 'usuario_id', 'cod_denver', 'oficina_id', 'cod_iconnect', 'moneda_id', 'mail', 'telefono1', 'telefono2','fe_ingreso_py','categoria','fe_ingreso_int','tipo','fe_cumple','fee_mensual','fe_finprueba','obs','fee_afiliacion','curso_acm','curso_fireUP','curso_succeed','creador');
        $valoresV="'".$nombrefull."','".$nro_doc."','".$usuarioP."','','".$oficinaProvisorio."','','".$moneda_id."','','".$tel1."','".$tel2."','".$fec_ingreso."','','','','".$fecha_nacim."','','','','','','','','".$creador."'";

        //echo "$valores";
        //print_r($campos);
        /*
            VER0IFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if($aprobacion =='Aprobado' && ($vendedorProvisorio==0)){
          $inserta_Datos->insertarDato('vendedor',$camposV,$valoresV);
        }
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('personal',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('personal',$campos,$valores);
            $destinatarios = array($mail_ti);
            $contenido = 'Nombre: '.$nombrefull.'<br>'.'Tipo Doc: '.$tipo_doc.'<br>'.'Numero Doc: '.$nro_doc.'<br>'.'Fecha de ingreso: '.$fec_ingreso;
            $asunto = 'NUEVO: ficha de personal para revision de documentos';
            if (!empty($destinatarios) and $destinatarios != false and isset($contenido, $asunto,$destinatarios)) {
              if ($mailer->loadRemoteConfig()) {
                $estado = $mailer->sendMsj(
                    $destinatarios,
                    $contenido,
                    $asunto
                );
              }
            }
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if($("#nombrefull").val()==""){
      popup('Advertencia','Es necesario ingresar el nombre !!') ;
      return false ;
    }else if($("#tipo_doc").val()==""){
      popup('Advertencia','Es necesario ingresar el tipo de documento!!') ;
      return false ;
    }else if($("#nro_doc").val()==""){
      popup('Advertencia','Es necesario ingresar el numero de documento!!') ;
      return false ;
    }else if($("#tipo_doc").val()==""){
      popup('Advertencia','Es necesario ingresar el tpo de documento!!') ;
      return false ;
    }else if($("#fec_ingreso").val()==""){
      popup('Advertencia','Es necesario ingresar la fecha de ingreso!!') ;
      return false ;
    }
  }
  function inicializar(){
    var perfil=<?php $tPerfil=$inserta_Datos->consultarDatos(array("tipo"),"perfil",'','id',$_SESSION['perfil']);$tPerfil=$tPerfil->fetch_array(MYSQLI_NUM);echo "'".$tPerfil[0]."'";?>;
    console.log(perfil);
    if(perfil!='TI'){
      $("#aprobacion").attr("disabled","");
    }
  }
  $(document).ready(function (){inicializar()});
  </script>

</html>
