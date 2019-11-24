<?php
     //INICIALIZACION DE VARIABLES
      session_start();
      include("Parametros/conexion.php");
      //include("Parametros/verificarConexion.php");
      $consultas = new Consultas();
      $asunto_ticket_id = 0;
      $asunto_ticket_campos = array();
      $btn_label = "Crear Asunto de Ticket";

       /*
      SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
      ========================================================================
      */
      if(isset($_POST['seleccionado'])){
        $asunto_ticket_id=$_POST['seleccionado'];
        $campos = array('asunto','obs');
        $inputsId = array('asunto','obs');
        $inputsVal = array();

        $tmpdatos = $consultas->consultarDatos($campos,'asuntos',"","id",$asunto_ticket_id);
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
          $btn_label = "Modificar Asunto de Ticket";
        }
      }

      if(isset($_POST['idformulario'])){
        if($_POST['idformulario']!=0){
          $btn_label = "Modificar Asunto de Ticket";
        }
      }

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Módulo de Asuntos de Tickets</title>
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
    <h5 class="text-left mt-3 mb-3 text-muted">Crear Nuevo Asunto de Ticket</h5>

    <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
    <form name="TICKET_FORM" method="POST" onsubmit="return verificar();" >

    <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="idformulario" id="idformulario" value=<?php echo $asunto_ticket_id;?> >
    <!-- Campos del Formulario-->
      <div class="input-group input-group-sm">
        <div class="input-group-prepend"> 
          <span class="input-group-text border border-0 bg-white">Asunto:
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </span>
        </div>
        <input class="form-control form-control-sm" name="asunto" id="asunto" type="text" maxlength="100">
        <div class="valid-feedback">Correcto.</div>
        <div class="invalid-feedback">Debe indicar el asunto.</div>
      </div>
      <div class="input-group input-group-sm mt-3">
        <div class="input-group-prepend"> 
          <span class="input-group-text border border-0 bg-white">Observaciones:</span>
        </div>
        <textarea  class="form-control" name="obs" id="obs" rows="2"></textarea>
      </div>
      <!--Fin campos de formulario-->
      
      <!--Botones del formulario-->
      <div class="row ml-1 mt-2">
        <div class="col-sm-6 mt-3 text-center">
          <input type="submit" class="btn btn-sm btn-info" value="<?php echo $btn_label; ?>" name="submit_asunto_ticket">
        </div>
        <div class="col-sm-6 mt-3 text-center" onclick="location='asuntos_ticket_panel.php';">
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

        //validacion del asunto del ticket
        if( (asunto.value =='' || asunto.length>=100)  ){
          esInvalido(asunto);
          ok = false;
        }else{
          esValido(asunto);
        }

        return ok;

      }

  </script>

</html>

<?php
      //var_dump($_POST);

  //cuando el id es distinto de cero el form fue llamado para edicion, cargar campos entonces
  if(($asunto_ticket_id!=0 and !empty($inputsVal))){
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
if(isset($_POST['submit_asunto_ticket'])){
      //parametros de insercion/modificacion
      $asunto  = $_POST["asunto"];
      $obs  = $_POST["obs"];
      $creador  = 'usuarioLogin'; //debe ser via $_SESSION
      
      //solo usado para las modificaciones
      $idForm = $_POST['idformulario'];

      $campos = array( 'asunto','obs');
      $valores="'$asunto','$obs'";
      
      //update o insert dependiend de las circunstancias
      if( isset($idForm) && ($idForm!=0) ){
        $consultas->modificarDato('asuntos',$campos,$valores,'id',$idForm);
      }else{
        $consultas->insertarDato('asuntos',$campos,$valores);
      }
  //echo "<script>window.location='ticket_panel.php'</script>" ;
}
?>