<?php
     //INICIALIZACION DE VARIABLES
      session_start();
      include("Parametros/conexion.php");
      //include("Parametros/verificarConexion.php");
      $consultas = new Consultas();
      $ticket_id = 0;
      $ticket_campos = array();
      $btn_label = "Crear Ticket";

       /*
      SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
      ========================================================================
      */
      if(isset($_POST['seleccionado'])){
          $ticket_id=$_POST['seleccionado'];
          $campos = array('fecha','asunto','explica','tipo','criticidad','estado','creador',
          'solicitante','solic_mail');
          $inputsId = array('fecha','asunto','explica','tipo','criticidad','estado','creador',
          'solicitante','solic_mail');
          $inputsVal = array();

          //echo "ID ". $ticket_id;
          $tmpdatos = $consultas->consultarDatos($campos,'ticket',"","id",$ticket_id);
          //ver de controlar mejor este caso
          if(gettype($tmpdatos)!="boolean"){
            $inputsVal = $tmpdatos->fetch_array(MYSQLI_NUM);
          }else{
            //echo "Vacio como el corazon de ella";
          }
      }

      //para el label del boton
      if(isset($_POST['seleccionado'])){

        if($_POST['seleccionado']!=0){ 
          $btn_label = "Modificar Ticket";
        }
      }

      if(isset($_POST['idformulario'])){
        if($_POST['idformulario']!=0){
          $btn_label = "Modificar Ticket";
        }
      }

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Módulo de Tickets</title>
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
    <h5 class="text-left mt-3 mb-3 text-muted">Crear Nuevo Ticket</h5>

    <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
    <form name="TICKET_FORM" method="POST" onsubmit="return verificar();" >

    <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="idformulario" id="idformulario" value=<?php echo $ticket_id;?> >
    <!-- Campos del Formulario-->
      <div class="ml-3 form-group">
        <label for="asunto">Asunto:</label>
        <input class="form-control" name="asunto" id="asunto" type="text" maxlength="100">
        <div class="valid-feedback">Correcto.</div>
        <div class="invalid-feedback">Indique el motivo del ticket.</div>
      </div>
      <div class="ml-3 form-group">
        <label for="explica">Explicación:</label>
        <textarea  class="form-control" name="explica" id="explica" rows="3"></textarea>
        <div class="valid-feedback">Correcto.</div>
        <div class="invalid-feedback">Por favor, agregue una explicación.</div>
      </div>
      <?php if($btn_label=="Modificar Ticket"): ?>
        <div class="ml-3 form-group">
          <label for="asunto">Creador:</label>
          <input class="form-control" name="creador" id="creador" type="text" readonly>
        </div>
      <?php endif; ?>
      <div class="row ml-1">
        <div class="col-sm-6 mt-3">
          <div class="form-group">
            <label for="solicitante">Fecha:</label>
            <input class="form-control" name="fecha" id="fecha" type="date">
            <div class="valid-feedback">Correcto.</div>
            <div class="invalid-feedback">Por favor, ingrese una fecha valida.</div>
          </div>
        </div>
        <?php if($btn_label=="Modificar Ticket"): ?>
          <div class="col-sm-6 mt-3">
            <div class="form-group">
              <label for="tipo">Estado:</label>
              <select class="form-control" name="estado" id="estado">
                <option value="Nuevo">Nuevo</option>
                <option value="Asignado">Asignado</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Resuelto">Resuelto</option>
                <option value="Cerrado">Cerrado</option>
              </select>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="row ml-1">
        <div class="col-sm-6 mt-2">
          <label for="tipo">Tipo:</label>
          <select class="form-control" name="tipo" id="tipo">
            <option value="Consulta">Consulta</option>
            <option value="Reclamo">Reclamo</option>
            <option value="Queja">Queja</option>
            <option value="Servicio">Solicitud de Servicio</option>
            <option value="Sugerencia">Sugerencia</option>
            <option value="Otros">Otros</option>
          </select>
        </div>
        <div class="col-sm-6 mt-2">
          <label for="criticidad">Criticidad:</label>
          <select class="form-control" name="criticidad" id="criticidad">
            <option value="Baja">Baja</option>
            <option value="Media">Media</option>
            <option value="Alta">Alta</option>
            <option value="Urgente">Urgente</option>
          </select>
        </div>
      </div>
      <div class="row ml-1">
        <div class="col-sm-6 mt-3">
          <div class="form-group">
            <label for="solicitante">Solicitante:</label>
            <input class="form-control" name="solicitante" id="solicitante" type="text" maxlength="30">
            <div class="valid-feedback">Correcto.</div>
            <div class="invalid-feedback">Por favor, rellene este campo.</div>
          </div>
        </div>
        <div class="col-sm-6 mt-3">
          <div class="form-group">
            <label for="solic_mail">Correo del Solicitante:</label>
            <input class="form-control" name="solic_mail" id="solic_mail" type="text" maxlength="60">
            <div class="valid-feedback">Correcto.</div>
            <div class="invalid-feedback">Por favor, rellene apropiadamente este campo.</div>
          </div>
        </div>
      </div>
      <!--Fin campos de formulario-->

      <!--Botones del formulario-->
      <div class="row ml-1 mt-2">
        <div class="col-sm-6 mt-3 text-center">
          <input type="submit" class="btn btn-sm btn-info" value="<?php echo $btn_label; ?>" name="submit_ticket">
        </div>
        <div class="col-sm-6 mt-3 text-center" onclick="location='ticket_panel.php';">
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
      function verificar(){
        var ok = true;
        var asunto = document.getElementById("asunto");
        var explicacion = document.getElementById("explica");
        var solicitante = document.getElementById("solicitante");
        var email = document.getElementById("solic_mail");
        var fecha = document.getElementById("fecha");

        //validacion del asunto del ticket
        if( (asunto.value =='' || asunto.length>=100)  ){
          esInvalido(asunto);
          ok = false;
        }else{
          esValido(asunto);
        }	

        //validacion de la explicación del ticket
        if( (explicacion.value =='')  ){
          esInvalido(explicacion);
          ok = false;
        }else{
          esValido(explicacion);
        }	

        //validacion del nombre de solicitante
        if( (solicitante.value =='')  ){
          esInvalido(solicitante);
          ok = false;
        }else{
          esValido(solicitante);
        }	

        //validacion del correo del solicitante
        if( !validateEmail(email.value) || email.value == '' ){
          esInvalido(email)
          ok = false;
        }else{
          esValido(email)
        }	

        //validacion de la fecha
        if( fecha.value == '' ){
          esInvalido(fecha)
          ok = false;
        }else{
          esValido(fecha)
        }	

        return ok;

      }


  </script>

</html>

<?php
      //var_dump($_POST);

  //cuando el id es distinto de cero el form fue llamado para edicion, cargar campos entonces
  if(($ticket_id!=0 and !empty($inputsVal))){
      /*
          CONVERTIR LOS ARRAY A UN STRING PARA PODER ENVIAR POR PARAMETRO A LA FUNCION JS
      */
      //echo "enjoy the silence";
      //var_dump($inputsId);
      //var_dump($inputsVal);
      $inputsVal = implode(",",$inputsVal);
      $inputsId = implode(",",$inputsId);
      echo '<script>cargarCampos("'.$inputsId.'","'.$inputsVal.'")</script>';
  }else{
    //echo "are im a joke to you";
  }
//Creación o Modificación de Tickets en la BD
if(isset($_POST['submit_ticket'])){
      //parametros de insercion/modificacion
      $fecha = $_POST["fecha"]; //tiene que definirse bien la zona horaria php en el server
      $asunto  = $_POST["asunto"];
      $explica  = $_POST["explica"];
      $tipo  = $_POST["tipo"];
      $criticidad  = $_POST["criticidad"];
      $estado = "Nuevo";
      $creador  = 'usuarioLogin';
      $usuario_id = 1;
      $solicitante  = $_POST["solicitante"];
      $solic_mail = $_POST['solic_mail'];
      //solo usado para las modificaciones
      $idForm = $_POST['idformulario'];
      if(isset($idForm) and $idForm!=0){
        $estado = $_POST["estado"];
      }

      //formateo de fecha, solo para asegurarse de que se formatee como YYYY-MM-DD
      $fecha = Date("Y-m-d",strtotime($fecha));
      //echo "Nuevo formato: ".$fecha;

      $campos = array( 'fecha','asunto','explica','tipo','criticidad','estado','creador',
      'solicitante','solic_mail','usuario_id');
      $valores="'$fecha','$asunto','$explica','$tipo','$criticidad','$estado','$creador',".
      "'$solicitante','$solic_mail',$usuario_id";
      
      //update o insert dependiend de las circunstancias
      if( isset($idForm) && ($idForm!=0) ){
        $consultas->modificarDato('ticket',$campos,$valores,'id',$idForm);
      }else{

        $consultas->insertarDato('ticket',$campos,$valores);
      }
  //echo "<script>window.location='ticket_panel.php'</script>" ;
}
?>

