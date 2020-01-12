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
            $campos=array('(SELECT id_remax FROM propiedades WHERE id = propiedades_id)','propiedades_id', 'moneda_id', 'fecha', 'importe', 'referencia', 'cotizacion', 'fecha_vto', 'nombre', 'nro_ci', 'email', 'estado');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'reservas',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array( 'propiedades_lista', 'propiedades_id','moneda','fecha','importe','referencia','cotizacion','fecha_vto','nombre','nro_ci','email');
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
  <h2>RESERVAS</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">ID Propiedad REMAX</label></td>
        <td>
          <input list="propiedad" id="propiedades_lista" name="propiedades_lista" autocomplete="off" placeholder="Ingrese el código de la propiedad" class="campos-ingreso" onkeyup="buscarListaQ(['id_remax'], this.value,'propiedades', 'id_remax', 'propiedad', 'propiedades_id', 'estado', '')" >
          <datalist id="propiedad">
            <option value=""></option>
          </datalist>
        </td>
        <td>
          <input type="hidden" name="propiedades_id" id="propiedades_id">
        </td>
      </tr>
      <tr>
          <td><label for="">Moneda</label></td>
          <td>
              <?php
            //name, campoId, campoDescripcion, tabla
              if(!(count($resultado)>0)){
               $inserta_Datos->crearMenuDesplegable('moneda','id','dsc_moneda','moneda');
              }else{
                  $inserta_Datos->DesplegableElegido(@$resultado[2],'moneda','id','dsc_moneda','moneda');
              }
            ?>
          </td>
        </tr>
      <tr>
        <td><label for="">Fecha</label></td>
        <td>
          <input type="date" name="fecha" id="fecha" class="campos-ingreso" />
        </td>
      </tr>
      <tr>
            <td><label for="">Importe</label></td>
            <td><input type="text" data-type="currency" name="importe" id="importe" maxlength="12" class="campos-ingreso" placeholder="Ingrese un monto" class="campos-ingreso"  onkeyup="formatoMoneda($(this))" onblur="formatoMoneda($(this), 'blur')"/></td>
            <td>
              <input type="hidden" name="cotizacion" id="cotizacion">
            </td>
      </tr>
      <tr>
            <td><label for="">Referencia</label></td>
            <td><input type="text" name="referencia" id="referencia" placeholder="Ingrese una referencia" class="campos-ingreso" /></td>
      </tr>
      <tr>
        <td><label for="">Fecha de vencimiento</label></td>
        <td>
          <input type="date" name="fecha_vto" id="fecha_vto" class="campos-ingreso" />
        </td>
      </tr>
      <tr>
        <td><label for="">Nombre</label></td>
        <td>
          <input type="text" name="nombre" id="nombre" placeholder="Ingrese un nombre" class="campos-ingreso" />
        </td>
      </tr>
      <tr>
        <td><label for="">C.I.</label></td>
        <td>
          <input type="number" name="nro_ci" id="nro_ci" placeholder="Ingrese el número de documento" class="campos-ingreso" />
        </td>
      </tr>
      <tr>
        <td><label for="">Email</label></td>
        <td>
          <input type="email" name="email" id="email" placeholder="Ingrese el correo electrónico" class="campos-ingreso" />
        </td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='reserva_panel.php';"  class="boton-formulario">
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


if (isset($_POST['propiedades_id'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['propiedades_id'])){
        $propiedades_id =trim($_POST['propiedades_id']);
        $moneda =trim($_POST['moneda']);
        $fecha =trim($_POST['fecha']);
        $importe = implode("",explode(",",trim($_POST['importe'])));
        $referencia =trim($_POST['referencia']);
        $cotizacion =trim($_POST['cotizacion']);
        $fecha_vto =trim($_POST['fecha_vto']);
        $nombre =trim($_POST['nombre']);
        $nro_ci =trim($_POST['nro_ci']);
        $email =trim($_POST['email']);
        $estado = "PENDIENTE";
        $buscador = trim($_POST['propiedades_lista']) . $nombre;
        $idForm=$_POST['Idformulario'];
        $creador ="UsuarioLogin";
        $campos = array( 'propiedades_id', 'moneda_id', 'fecha', 'importe', 'referencia', 'cotizacion', 'fecha_vto', 'nombre', 'nro_ci', 'email', 'estado', 'buscador', 'creador');
        $valores="'".$propiedades_id."', '".$moneda."', '".$fecha."', '".$importe."', '".$referencia."', '".$cotizacion."', '".$fecha_vto."', '".$nombre."', '".$nro_ci."', '".$email."', '".$estado."', '".$buscador."', '".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
           $inserta_Datos->modificarDato('reservas',$campos,$valores,'id',$idForm);
        }else{
           $inserta_Datos->insertarDato('reservas',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">
  $( () => {
    formatoMoneda($("input[data-type='currency']"));
    obtenerDatosCallBack(['cotiz_compra'], 'cotizacion', 'moneda_id', $('#moneda').val(), 'order by id desc', asignarCotizacion);
  });

  $("#moneda").on('change', () => {
    obtenerDatosCallBack(['cotiz_compra'], 'cotizacion', 'moneda_id', $('#moneda').val(), 'order by id desc', asignarCotizacion);
  });

  function asignarCotizacion(resultado){
    $('#cotizacion').val(resultado[0]);
  }

//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if( (document.getElementById('propiedades_lista').value =='') ){
      popup('Advertencia','Es necesario ingresar todos los campos') ;
		  return true ;

		}else{
        // Error - Advertencia - Informacion
            popup('Advertencia','Es necesario ingresar todos los campos') ;
            return false ;
		}
	}
  </script>

</html>
