<?php
     //INICIALIZACION DE VARIABLES
      session_start();
      include("Parametros/conexion.php");
      //include("Parametros/verificarConexion.php");
      $consultas = new Consultas();
      $ticket_id = 0;
      $ticket_campos = array();
      $btn_label = "Crear Ticket";
      $asuntos_list = array();

       /*
      SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
      ========================================================================
      */
      if(isset($_POST['seleccionado'])){
          $ticket_id=$_POST['seleccionado'];
          $campos = array('fecha','asuntos_id','explica','tipo','criticidad','estado','solucion',
          'solicitante','solic_mail');
          $inputsId = array('fecha','asuntos_id','explica','tipo','criticidad','estado','solucion',
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

    //obtención de asuntos predefinidos 
    $aux = $consultas->consultarDatos(array('id','asunto'),'asuntos');
    if(gettype($aux)!="boolean"){
      while($row = $aux->fetch_assoc()){
        array_push($asuntos_list,$row);
      }
    }

    //por si no hubiesen asuntos definidos
    if(count($asuntos_list)<=0){
      $asuntos_list = array(
        array(
          "id" => -1,
          "asunto" => "INDEFINIDO"
        )
      );
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
      <div class="input-group input-group-sm mt-3">
        <div class="input-group-prepend"> 
          <span class="input-group-text border border-0 bg-white">
            Asunto:
            &nbsp;&nbsp;&nbsp;&nbsp;
          </span>
        </div>
        <select class="form-control" name="asuntos_id" id="asuntos_id">
          <?php foreach($asuntos_list as $element): ?>
            <option value="<?php echo $element['id']; ?>">
              <?php echo $element['asunto']; ?>
            </option>
          <?php endforeach; ?>
        </select>
        <div class="valid-feedback">Correcto.</div>
        <div class="invalid-feedback">No existen asuntos definidos.</div>
      </div>
      <div class="input-group input-group-sm mt-3">
        <div class="input-group-prepend"> 
          <span class="input-group-text border border-0 bg-white">
            Explicación:
          </span>
        </div>
        <textarea  class="form-control" name="explica" id="explica" rows="1"></textarea>
        <div class="valid-feedback">Correcto.</div>
        <div class="invalid-feedback">Por favor, agregue una explicación.</div>
      </div>
      <?php if($btn_label=="Modificar Ticket"): ?> 
        <div class="input-group input-group-sm mt-3">
          <div class="input-group-prepend"> 
            <span class="input-group-text border border-0 bg-white">
              Solución:
              &nbsp;&nbsp;
            </span>
          </div>
          <textarea  class="form-control" name="solucion" id="solucion" rows="1"></textarea>
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">Por favor, agregue una explicación.</div>
        </div>
      <?php endif; ?>
      
      <?php if($btn_label=="Modificar Ticket"): ?><!--Cuando se entra a modificar, estado se muestra al 
      lado de fecha-->
        <div class="row">
          <div class="col-sm-6 mt-3">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend"> 
                <span class="input-group-text border border-0 bg-white">
                  Fecha:
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>
              </div>
              <input class="form-control" name="fecha" id="fecha" type="date">
              <div class="valid-feedback">Correcto.</div>
              <div class="invalid-feedback">Por favor, ingrese una fecha valida.</div>
            </div>
          </div>
          <div class="col-sm-6 mt-3">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend"> 
                <span class="input-group-text border border-0 bg-white">
                  Estado:
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>
              </div>
              <select class="form-control" name="estado" id="estado">
                <option value="Nuevo">Nuevo</option>
                <option value="Asignado">Asignado</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Resuelto">Resuelto</option>
                <option value="Cerrado">Cerrado</option>
                <option value="Eliminado">Eliminado</option>
              </select>
            </div>
          </div>
        </div>
      <?php else: ?> <!--Cuando se entra a crear la fecha abarca todo el ancho-->
        <div class="input-group input-group-sm mt-3">
          <div class="input-group-prepend"> 
            <span class="input-group-text border border-0 bg-white">
              Fecha:
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
          </div>
          <input class="form-control" name="fecha" id="fecha" type="date">
          <div class="valid-feedback">Correcto.</div>
          <div class="invalid-feedback">Por favor, ingrese una fecha valida.</div>
        </div>
      <?php endif; ?>
      
      <div class="row">
        <div class="col-sm-6 mt-3">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend"> 
              <span class="input-group-text border border-0 bg-white">
                Tipo:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </span>
            </div>
            <select class="form-control" name="tipo" id="tipo">
              <option value="Consulta">Consulta</option>
              <option value="Reclamo">Reclamo</option>
              <option value="Queja">Queja</option>
              <option value="Servicio">Solicitud de Servicio</option>
              <option value="Sugerencia">Sugerencia</option>
              <option value="Otros">Otros</option>
            </select>
          </div>
        </div>
        <div class="col-sm-6 mt-3">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend"> 
              <span class="input-group-text border border-0 bg-white">
                Criticidad:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
              </span>
            </div>
            <select class="form-control" name="criticidad" id="criticidad">
              <option value="Baja">Baja</option>
              <option value="Media">Media</option>
              <option value="Alta">Alta</option>
              <option value="Urgente">Urgente</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6 mt-3">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend"> 
              <span class="input-group-text border border-0 bg-white">
                Solicitante: 
              </span>
            </div>
            <input class="form-control" name="solicitante" id="solicitante" type="text" maxlength="30">
            <div class="valid-feedback">Correcto.</div>
            <div class="invalid-feedback">Por favor, rellene este campo.</div>
          </div>
        </div>
        <div class="col-sm-6 mt-3">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend"> 
              <span class="input-group-text border border-0 bg-white">
                Correo del Solicitante:
              </span>
            </div>
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
        var asuntos_id = document.getElementById("asuntos_id");
        var explicacion = document.getElementById("explica");
        var solicitante = document.getElementById("solicitante");
        var email = document.getElementById("solic_mail");
        var fecha = document.getElementById("fecha");

        //validacion del asunto del ticket
        if( (asuntos_id.options[0].text == 'INDEFINIDO') ){
          esInvalido(asuntos_id);
          ok = false;
        }else{
          esValido(asuntos_id);
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
      $asuntos_id  = $_POST["asuntos_id"];
      $explica  = $_POST["explica"];
      $tipo  = $_POST["tipo"];
      $criticidad  = $_POST["criticidad"];
      $solicitante  = $_POST["solicitante"];
      $solic_mail = $_POST['solic_mail'];
      
      //formateo de fecha, solo para asegurarse de que se formatee como YYYY-MM-DD
      $fecha = Date("Y-m-d",strtotime($fecha));

      //solo usado para las modificaciones
      $idForm = $_POST['idformulario'];

      if(isset($idForm) and $idForm!=0){
        //campos exclusivos al momento de actualizar
        $estado = $_POST["estado"];
        $solucion = $_POST["solucion"];

        $campos = array( 'fecha','asuntos_id','explica','tipo','criticidad','estado',
        'solicitante','solic_mail','solucion');
        $valores="'$fecha',$asuntos_id,'$explica','$tipo','$criticidad','$estado',".
        "'$solicitante','$solic_mail','$solucion'";

        $consultas->modificarDato('ticket',$campos,$valores,'id',$idForm);

      }else{
        //campos exclusivos al momento de la creacion
        $usuario_id = 1; //debe ser obtenido de $_SESSION
        $estado = "Nuevo"; //por defecto un ticket se deve crear en estado "Nuevo"
        $creador  = 'usuarioLogin'; //debe ser obtenido de $_SESSION

        $campos = array( 'fecha','asuntos_id','explica','tipo','criticidad','estado',
        'solicitante','solic_mail','usuario_id','creador');
        $valores="'$fecha',$asuntos_id,'$explica','$tipo','$criticidad','$estado',".
        "'$solicitante','$solic_mail',$usuario_id,'$creador'";

        $consultas->insertarDato('ticket',$campos,$valores);
      }
      

  //echo "<script>window.location='ticket_panel.php'</script>" ;
}
?>