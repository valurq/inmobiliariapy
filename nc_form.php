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
            $campos=array('importe','concepto','numero_nc','fecha','obs','moneda_id','oficina_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$inserta_Datos->consultarDatos($campos,'nota_credito',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('importe','concepto','numero_nc','fecha','obs');
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
  <h2>NOTA CRÉDITO</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Moneda</label></td>
        <td><?php
        if(!(count($resultado)>0)){
            $inserta_Datos->crearMenuDesplegable('moneda','id','dsc_moneda','moneda');
        }else{
            $inserta_Datos->DesplegableElegido(@$resultado[5],'moneda','id','dsc_moneda','moneda');
        }?></td>
      </tr>
      <tr>
        <td><label for="">Oficina</label></td>
        <td><input list="ofiLista" id="oficinaLista" name="propiedades" autocomplete="off" onkeyup="buscarLista(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'ofiLista', 'oficina')" class="campos-ingreso">
        <datalist id="ofiLista">
          <option value=""></option>
        </datalist>
      <input type="hidden" name="oficina" id="oficina"></td>
      </tr>
      <tr>
        <td><label for="">Importe</label></td>
        <td><input type="number" name="importe" id="importe" value="" step="any" placeholder="Ingrese su importe" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Concepto</label></td>
        <td><input type="text" name="concepto" id="concepto" value="" placeholder="Ingrese su concepto" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Número nota crédito</label></td>
        <td><input type="text" name="numero_nc" id="numero_nc" value="" placeholder="Ingrese numero de la nota de credito" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha</label></td>
        <td><input type="date" name="fecha" id="fecha" value="" class="campos-ingreso"></td>
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
  <input name="volver" type="button" value="Volver" onclick = "location='nc_panel.php';"  class="boton-formulario">
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


if (isset($_POST['moneda'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['moneda'])){
        $moneda =trim($_POST['moneda']);
        $oficina =trim($_POST['oficina']);
        $importe =trim($_POST['importe']);
        $concepto =trim($_POST['concepto']);
        $numero_nc =trim($_POST['numero_nc']);
        $fecha =trim($_POST['fecha']);
        $obs =trim($_POST['obs']);
        $idForm=$_POST['Idformulario'];
        $creador    =$_SESSION['usuario'];
        $campos =array('moneda_id','oficina_id','importe','concepto','numero_nc','fecha','obs','creador' );
        $valores="'".$moneda."','".$oficina."','".$importe."','".$concepto."','".$numero_nc."','".$fecha."','".$obs."','".$creador."'";
        //echo "$valores";
        //print_r($campos);

        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('nota_credito',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('nota_credito',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		if( (document.getElementById('nombre').value !='')&&(document.getElementById('cedula').value !='')  ){
		    return true ;

		}else{
        // Error - Advertencia - Informacion
            popup('Advertencia','Es necesario ingresar el nombre y la cedula') ;
            return false ;
		}
	}
  </script>

</html>
