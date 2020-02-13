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
            $campos = array( '(SELECT dsc_ciudad FROM ciudad WHERE id = ciudad_id)', 'ciudad_id','nombrefull', 'nro_doc', 'direccion', 'barrio', 'telefono1', 'telefono2', 'est_civil', 'sexo', 'fec_nacim', 'estado', 'obs', 'apellido','ruc','link_social','link_social2', '(SELECT dsc_oficina FROM oficina WHERE id = oficina_id)', 'oficina_id','sededico');
            //CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
                $resultado=$inserta_Datos->consultarDatos($campos,'personal',"","id",$id );
                $resultado=$resultado->fetch_array(MYSQLI_NUM);

                $checkbox = $resultado[19];
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */

            $camposIdForm=array( 'ciudad', 'ciudad_id', 'nombrefull', 'nro_doc', 'direccion', 'barrio', 'telefono1', 'telefono2','est_civil','sexo','fec_nacim','estado', 'obs', 'apellido', 'ruc', 'link_social', 'link_social2', 'oficina', 'oficina_id');
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
  <h2>SOLICITUD DE ALTA CANDIDATO</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Nombre</label></td>
        <td><input type="text" name="nombrefull" id="nombrefull" value="" placeholder="Ingrese el nombre del candidato" class="campos-ingreso"></td>

        <td><label for="">Ciudad</label></td>
        <td>
          <input list="ciudadLista" id="ciudad" name="ciudad" placeholder="Ingrese la ciudad correspondiente" autocomplete="off" onkeyup="buscarLista(['dsc_ciudad'], this.value, 'ciudad', 'dsc_ciudad', 'ciudadLista', 'ciudad_id')" class="campos-ingreso">

          <datalist id="ciudadLista">
            <option value=""></option>
          </datalist>
          <input type="hidden" name="ciudad_id" id="ciudad_id">
        </td>

      </tr>
      <tr>
        <td><label for="">Apellido</label></td>
        <td><input type="text" name="apellido" id="apellido" value="" placeholder="Ingrese el apellido del candidato" class="campos-ingreso"></td>

        <td><label for="">RUC</label></td>
        <td><input type="text" name="ruc" id="ruc" value="" placeholder="Ingrese el numero de RUC" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Nro C.I.</label></td>
        <td><input type="text" name="nro_doc" id="nro_doc" value="" placeholder="Ingrese el numero de documento" class="campos-ingreso"></td>

        <td> <label for="">Dirección</label> </td>
        <td> <input type="text" name="direccion" id="direccion" value="" placeholder="Ingrese su direccion" class="campos-ingreso"></td>

      </tr>
      <tr>
        <td><label for="">Fecha de Nacimiento</label></td>
        <td><input type="date" name="fec_nacim" id="fec_nacim" value=""  class="campos-ingreso"></td>

        <td> <label for="">Barrio</label> </td>
        <td> <input type="text" name="barrio" id="barrio" value="" placeholder="Ingrese su barrio" class="campos-ingreso"> </td>
      </tr>
      <tr>

        <td><label for="">Sexo</label></td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[11],'sexo',array('Masculino','Femenino'))?></td>

        <td> <label for="">Estado Civil</label> </td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[12],'est_civil',array('Soltero','Casado','Divorciado','Viudo','Otros'))?></td>
      </tr>
      <tr>

        <td><label for="">Oficina</label></td>
        <td>
          <input list="lista_ofi" id="oficina" name="oficina" autocomplete="off" placeholder="Ingrese el nombre de la oficina relaciona" class="campos-ingreso" onkeyup="buscarListaQ(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'lista_ofi', 'oficina_id', 'estado', 'ACTIVO','','')" >
          <datalist id="lista_ofi">
            <option value=""></option>
          </datalist>
        </td>


        <td> <label for="">Estado</label> </td>
        <td><?php

        		if(@$resultado[11] != 'INACTIVO'){
        		$inserta_Datos->DesplegableElegidoFijo(@$resultado[11],'estado',array('Universidad','Agente RE/MAX Paraguay','Agente RE/Internacional'));}
        		else{
        			$inserta_Datos->DesplegableElegidoFijo(@$resultado[11],'estado',array('INACTIVO', 'Universidad','Agente RE/MAX Paraguay','Agente RE/Internacional'));}



        	?></td>

        <td>
          <input type="hidden" name="oficina_id" id="oficina_id">
        </td>
      </tr>
      <tr>

        <td><label for="">Teléfono particular</label></td>
        <td><input type="text" name="telefono1" id="telefono1" value="" placeholder="Ingrese número del teléfono" class="campos-ingreso"></td>


        <td><label for="">Red Social 1</label></td>
        <td><input type="text" name="link_social" id="link_social" value="" placeholder="Ingrese el link del perfil" class="campos-ingreso"></td>

      </tr>
      <tr>

        <td><label for="">Teléfono celular</label></td>
        <td><input type="text" name="telefono2" id="telefono2" value="" placeholder="Ingrese número del celular" class="campos-ingreso"></td>

        <td><label for="">Red Social 2</label></td>
        <td><input type="text" name="link_social2" id="link_social2" value="" placeholder="Ingrese el link del perfil" class="campos-ingreso"></td>
      </tr>

      <tr>
        <td></td>

      </tr>
      <tr>


        <td><label for="">Observación</label></td>
        <td><textarea name="obs" id="obs" class="campos-ingreso"></textarea></td>

        <td style="text-align: center;"><label>¿Se dedicó alguna vez a<br /> bienes raices?</label></td>
        <td><input type="checkbox" name="sededico" id="sededico">
        <span id="disclaimer" style="display: none; background-color: #f8d7da; color: #721c24; padding: 5px; border-radius: 5px; border: 1px solid  #721c24;">Favor adjuntar disclaimer</span></td>
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
        $apellido =trim($_POST['apellido']);
        $tipo_doc = "CEDULA";
        $nro_doc =trim($_POST['nro_doc']);
        $fec_nacim =trim($_POST['fec_nacim']);
        $sexo =trim($_POST['sexo']);
        $tel1 =trim($_POST['telefono1']);
        $tel2 =trim($_POST['telefono2']);
        $ciudad_id =trim($_POST['ciudad_id']);
        $ruc =trim($_POST['ruc']);
        $direccion =trim($_POST['direccion']);
        $barrio =trim($_POST['barrio']);
        $est_civil =trim($_POST['est_civil']);
        $estado =trim($_POST['estado']);
        $link_social =trim($_POST['link_social']);
        $link_social2 =trim($_POST['link_social2']);
        @$sededico = ($_POST['sededico']) ? "SI" : "NO";
        $dias_prueba = "15";
        $fec_ingreso = date("Y")."-".date("m")."-".date("d");
        $fec_ingreso = date("Y-m-d",strtotime($fec_ingreso));
        $obs =trim($_POST['obs']);
        $aprobacion = "" ;
        $oficina_id = trim($_POST['oficina_id']);
        $idForm=$_POST['Idformulario'];
        $creador =$_SESSION['usuario'];
        /*$moneda_id= $inserta_Datos->consultarDatos(array("id"),"moneda","","tipo","Local");
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
        $vendedorProvisorio=$vendedorProvisorio[0];*/

        $mail_ti=$inserta_Datos->consultarDatos(array("mail_ti"),"parametros","","","");
        $mail_ti=$mail_ti->fetch_array(MYSQLI_NUM);
        $mail_ti=$mail_ti[0];

        $campos = array( 'ciudad_id', 'nombrefull','tipo_doc', 'nro_doc', 'direccion', 'dias_prueba', 'barrio', 'telefono1', 'telefono2','fec_ingreso','est_civil', 'sexo', 'fec_nacim', 'estado','obs','aprobacion', 'apellido', 'ruc', 'link_social', 'link_social2', 'sededico', 'oficina_id', 'creador');
        $valores="'".$ciudad_id."', '".$nombrefull."', '".$tipo_doc."', '".$nro_doc."', '".$direccion."', '".$dias_prueba."', '".$barrio."', '".$tel1."','".$tel2."','".$fec_ingreso."','".$est_civil."','".$sexo."','".$fec_nacim."','".$estado."','".$obs."','".$aprobacion."','".$apellido."','".$ruc."','".$link_social."','".$link_social2."','".$sededico."','".$oficina_id."','".$creador."'";
        /*$camposV = array( 'dsc_vendedor','nro_doc', 'usuario_id', 'cod_denver', 'oficina_id', 'cod_iconnect', 'moneda_id', 'mail', 'telefono1', 'telefono2','fe_ingreso_py','categoria','fe_ingreso_int','tipo','fe_cumple','fee_mensual','fe_finprueba','obs','fee_afiliacion','curso_acm','curso_fireUP','curso_succeed','creador');
        $valoresV="'".$nombrefull."','".$nro_doc."','".$usuarioP."','','".$oficinaProvisorio."','','".$moneda_id."','','".$tel1."','".$tel2."','".$fec_ingreso."','','','','".$fecha_nacim."','','','','','','','','".$creador."'";*/

        //echo "$valores";
        //print_r($campos);
        /*
            VER0IFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */

        if(isset($idForm)&&($idForm!=0)){
           $inserta_Datos->modificarDato('personal',$campos,$valores,'id',$idForm);
        }
        else{

          $nombreOfi = $inserta_Datos->consultarDatos(array("dsc_oficina"),"oficina",'','id',$oficina_id);
          $nombreOfi = $nombreOfi->fetch_array(MYSQLI_NUM);
          $nombreOfi = $nombreOfi[0];

           $inserta_Datos->insertarDato('personal',$campos,$valores);

            $destinatarios = array($mail_ti);
            $contenido = 'Nombre: '.$nombrefull.'<br>'.'Apellido: '.$apellido.'<br>'.'Tipo Doc: '.$tipo_doc.'<br>'.'Numero Doc: '.$nro_doc.'<br>'.'Fecha de ingreso: '.$fec_ingreso.'<br>'.'Oficina relacionada: '.$nombreOfi;
            $asunto = 'NUEVO: ficha de solicitud candidato para revision de documentos';
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

        /*if($aprobacion =='Aprobado' && ($vendedorProvisorio==0)){
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
        }*/
    }
}
?>
<script type="text/javascript">

  $(() => {
    let checkbox = "<?php echo (isset($checkbox)) ? $checkbox : "" ?>";

    if(checkbox == "SI"){
      document.getElementById("sededico").setAttribute("checked", "checked");
      jQuery('#disclaimer').slideToggle('fast');
    }

  });

  $('#sededico').on('change', (e) => {
    jQuery('#disclaimer').slideToggle('fast');
  })


  $('#sexo').on('change', (e) => {
    var sexo = e.target.value;
    var est_civil = document.getElementById('est_civil');

    if(sexo == "Femenino"){
        est_civil.childNodes[0].value = "Soltera";
        est_civil.childNodes[0].innerHTML = "Soltera";
        est_civil.childNodes[1].value = "Casada";
        est_civil.childNodes[1].innerHTML = "Casada";
        est_civil.childNodes[2].value = "Divorciada";
        est_civil.childNodes[2].innerHTML = "Divorciada";
        est_civil.childNodes[3].value = "Viuda";
        est_civil.childNodes[3].innerHTML = "Viuda";
    }else{
      est_civil.childNodes[0].value = "Soltero";
        est_civil.childNodes[0].innerHTML = "Soltero";
        est_civil.childNodes[1].value = "Casado";
        est_civil.childNodes[1].innerHTML = "Casado";
        est_civil.childNodes[2].value = "Divorciado";
        est_civil.childNodes[2].innerHTML = "Divorciado";
        est_civil.childNodes[3].value = "Viudo";
        est_civil.childNodes[3].innerHTML = "Viudo";
    }
  });


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

  // function inicializar(){
  //   var perfil=<?php $tPerfil=$inserta_Datos->consultarDatos(array("tipo"),"perfil",'','id',$_SESSION['perfil']);$tPerfil=$tPerfil->fetch_array(MYSQLI_NUM);echo "'".$tPerfil[0]."'";?>;
  //   console.log(perfil);
  //   if(perfil!='TI'){
  //     $("#aprobacion").attr("disabled","");
  //   }
  // }

  //$(document).ready(function (){inicializar()});
  </script>

</html>
