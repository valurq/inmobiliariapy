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

        @$usuarioLogeado = $_SESSION['idUsu'] ;

        $resultado=$inserta_Datos->consultarDatos(array('perfil_id'),'usuario',"","id",$usuarioLogeado );
        $perfilIdUsuario=$resultado->fetch_array(MYSQLI_NUM);

        $resultado=$inserta_Datos->consultarDatos(array('tipo'),'perfil',"","id",$perfilIdUsuario[0] );
        $tipoPerfil=$resultado->fetch_array(MYSQLI_NUM);


        $resultado=$inserta_Datos->consultarDatos(array('nombre'),'usuario',"","id",$usuarioLogeado);
        $nombreUsuario=$resultado->fetch_array(MYSQLI_NUM);

        $resultado=$inserta_Datos->consultarDatos(array('apellido'),'usuario',"","id",$usuarioLogeado);
        $apellidoUsuario=$resultado->fetch_array(MYSQLI_NUM);

        $user = "";
        $resultado=array('');
        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos = array('(SELECT idpropiedad_remax FROM dco WHERE id = dco_id)','dco_id','fecha', 'motivo', 'autoriza_por', 'con_reserva');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'caida_operacion',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('propiedades','propiedades_hidden','fecha', 'motivo', 'autoriza_por');

            $user = $resultado[4];
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
        img:hover{
          cursor: pointer;
        }
      </style>
</head>
<body style="background-color:white">
  <h2>OPERACIONES CAIDAS</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">ID Propiedad REMAX</label></td>
        <td>
          <input list="id_propiedades" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscarLista(['idpropiedad_remax'], this.value,'dco', 'idpropiedad_remax', 'id_propiedades', 'propiedades_hidden')" >
          <datalist id="id_propiedades">
            <option value=""></option>
          </datalist>
        </td>
        <td>
          <input type="hidden" name="propiedades_hidden" id="propiedades_hidden">
        </td>
      </tr>
      <tr>
        <td><label for="">Fecha</label></td>
        <td>
          <input type="date" name="fecha" id="fecha" class="campos-ingreso" />
        </td>
      </tr>
      <tr>
        <td><label for="">Motivo</label></td>
        <td>
          <textarea name="motivo" id="motivo" class="campos-ingreso"></textarea>
        </td>
      </tr>
      <tr>
        <td><label for="">Autorizado por</label></td>
        <td>
          <input type="text" name="autoriza_por" id="autoriza_por" readonly class="campos-ingreso">
        </td>
        <td>
          <img src='Imagenes/pencil.png' width='25px' height='25px' alt='Añadir' title='Añadir' onclick='cambiarEstado()'>
        </td>
        <?php
          if ($user != "") {
            echo "<td><img src='Imagenes/borrador.png' width='25px' height='25px' alt='Borrar' title='Borrar' onclick='borrarEstado()'></td>";
          }
        ?>
      </tr>
      <tr>
        <td><label for="">Caída con Reserva?</label></td>
        <td style="display: flex; justify-content: flex-start;">

          <input type="checkbox" name="con_reserva" id="con_reserva" value="SI" class="campos-ingreso" style="width: 20px; margin: 0px;" />
          <?php 
            if((count($resultado)>0) &&(@$resultado[5]=="SI")){
              echo "<script>document.getElementById('con_reserva').checked=true</script>";
            }
          ?>
        </td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='caida_operacion_panel.php';"  class="boton-formulario">
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


if (isset($_POST['propiedades'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['propiedades'])){
        $propiedades =trim($_POST['propiedades']);
        $id_dco = trim($_POST['propiedades_hidden']);
        $fecha =trim($_POST['fecha']);
        $motivo = trim($_POST['motivo']);
        $autoriza_por = trim($_POST['autoriza_por']);
        $con_reserva = trim(((isset($_POST['con_reserva']))?"SI":"NO"));
        $idForm=$_POST['Idformulario'];
        $creador ="UsuarioLogin";
        $campos = array('dco_id','fecha', 'motivo', 'autoriza_por', 'con_reserva', 'creador');

        $valores="'".$id_dco."', '".$fecha."', '".$motivo."', '".$autoriza_por."', '".$con_reserva."', '".$creador."'";
        //print_r($campos);
        //echo $valores;
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('caida_operacion',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('caida_operacion',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">

  //FUNCION QUE ES LLAMADA POR EL CAMPO DE BUSQUEDA PARA REALIZAR CONSULTAS A LA BASE DE DATOS Y MOSTRAR EN LA TABLA CORRESPONDIENTE
//PARAMETROS : OBJETO (EL INPUT BUSCADOR)   ;  TABLA: TABLA CORRESPONDIENTE A LA BASE DE DATOS DONDE SE REALIZARA LA BUSQUEDA
  function buscarLista(camposResultado,valor,tabla,campo, idLista, idListaAux) {
      $.post("Parametros/buscadorGenerico.php", {camposResultado: camposResultado ,dato:valor,tabla:tabla,campoBusqueda:campo}, function(resultado) {
          //$("#resultadoBusqueda").html(resultado);
          var i;
          //console.log(resultado);

          $("#id_propiedades").empty();

          console.log(resultado);
          resultado=JSON.parse(resultado);
          for(i=1 ; i<resultado.length;i++){
              cargarData(resultado[i],idLista, idListaAux);
          }
       });
  }

  function cargarData(datos, listaID, listaIDAux){
      let lista = document.getElementById(listaID);
      let option = document.createElement('option');
      option.setAttribute('value',datos[1]);
      let data = document.createTextNode(datos[1]);
      option.appendChild(data);
      lista.appendChild(option);
      document.getElementById('propiedades_hidden').setAttribute('value', datos[0]);
  }

  function cambiarEstado(){
    var tipo = "<?php echo $tipoPerfil[0]?>";
    var nombre = "<?php echo $nombreUsuario[0]?>";
    var apellido = "<?php echo $apellidoUsuario[0]?>";

    if(tipo != "Agente" && document.getElementById('autoriza_por').value == ""){
      document.getElementById('autoriza_por').value= nombre+ " " +apellido;
    }else if(tipo == "Agente"){
      popup('Error','Error, usuario denegado') ;
    }
  }

  function borrarEstado(){
    var tipo = "<?php echo $tipoPerfil[0]?>";

    if(tipo != "Agente" && document.getElementById('autoriza_por').value != "")
      document.getElementById('autoriza_por').value="";
    else if(tipo == "Agente")
      popup('Error','Error, usuario denegado') ;
  }

//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if($("#propiedades").val()==""){
      popup('Advertencia','Es necesario ingresar el campo Id Propiedades!!') ;
      return false ;
    }else if($("#fecha").val()==""){
      popup('Advertencia','Es necesario ingresar una fecha!!') ;
      return false ;
    }else if($("#motivo").val()==""){
      popup('Advertencia','Es necesario ingresar un motivo!!') ;
      return false ;
    }

	}
  </script>

</html>