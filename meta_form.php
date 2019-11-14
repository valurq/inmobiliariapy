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
        @$oficina=$_POST['idOfi'];
        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos=array( 'oficina_id', 'meta_usd', 'meta_gs', 'ano');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */

            $resultado=$inserta_Datos->consultarDatos($campos,'metas',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            $oficina=$resultado[1];
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('meta_usd', 'meta_gs', 'ano');
        }
    ?>


    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script>
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>
</head>
<body style="background-color:white">
  <h2>METAS</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <input type="hidden" name="idOfi" id='idOfi' value=<?php echo $oficina;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
          <td><label for="">Meta en dolares</label></td>
          <td><input type="number" name="meta_usd" id="meta_usd" class="campos-ingreso"></td>
      </tr>
      <tr>
          <td><label for="">Meta en guaranies</label></td>
          <td><input type="number" name="meta_gs" id="meta_gs" class="campos-ingreso"></td>
      </tr>
      <tr>
          <td><label for="">Año</label></td>
          <td><input type="number" name="ano" id="ano" class="campos-ingreso"></td>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "window.close();"  class="boton-formulario">
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


if (isset($_POST['meta_usd'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['meta_usd'])){
        $meta_usd =trim($_POST['meta_usd']);
        $meta_gs =trim($_POST['meta_gs']);
        $ano =trim($_POST['ano']);
        $idForm=$_POST['Idformulario'];
        $idOfi=$_POST['idOfi'];
        $creador    ="UsuarioLogin";
        $campos = array( 'oficina_id', 'meta_usd', 'meta_gs', 'ano', 'creador');
        $valores="'".$idOfi."', '".$meta_usd."', '".$meta_gs."', '".$ano."', '".$creador."'";
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('metas',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('metas',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
		// if($("#vigencia_hasta").val()==""){
  //     popup('Advertencia','Es necesario ingresar una fecha de vigencia!!') ;
  //     return false ;
  //   }else if($("#fee_adm").val()==""){
  //     popup('Advertencia','Es necesario ingresar un pago mensual!!') ;
  //     return false ;
	 //  }else if($("#fee_operaciones").val()==""){
  //     popup('Advertencia','Es necesario ingresar un porcentaje sobre operaciones!!') ;
  //     return false ;
  //   }else if($("#fee_marketing").val()==""){
  //     popup('Advertencia','Es necesario ingresar un pago mensual de marketing!!') ;
  //     return false ;
  //   }else if($("#fee_afiliacion").val()==""){
  //     popup('Advertencia','Es necesario ingresar el campo pago afiliación!!') ;
  //     return false ;
  //   }
  </script>

</html>
