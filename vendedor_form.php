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
            $campos=array( 'dsc_vendedor','nro_doc','cod_denver','cod_iconnect', 'mail', 'telefono1', 'telefono2', 'fe_ingreso_py', 'categoria','fe_ingreso_int','fe_cumple','fee_mensual','fe_finprueba','obs','tipo','fee_afiliacion','usuario_id','(SELECT usuario FROM usuario WHERE id=usuario_id)','oficina_id','(SELECT dsc_oficina FROM oficina WHERE id=oficina_id)','moneda_id','curso_acm','curso_fireUP','curso_succeed');
            //CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
                $resultado=$inserta_Datos->consultarDatos($campos,'vendedor',"","id",$id );
                $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
          $camposIdForm=array( 'vendedor', 'nro_doc', 'cod_denver', 'cod_iconnect', 'mail','tel1', 'tel2', 'fe_ingreso_py', 'categoria', 'fe_ingreso_int','fe_cumple','fee_mensual','fe_finprueba','obs','tipo','fee_afiliacion','usuario','usuarioLista','oficina','oficinaLista');
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
  <h2>DEFINICIÓN DE VENDEDORES</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="CATEGORIA" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
  <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
  <table class="tabla-fomulario">
    <tbody>
      <tr>
        <td><label for="">Vendedor</label></td>
        <td><input type="text" name="vendedor" id="vendedor" value="" placeholder="Ingrese el nombre del vendedor" class="campos-ingreso"></td>

        <td><label for="">Numero de documento</label></td>
        <td><input type="text" name="nro_doc" id="nro_doc" value="" placeholder="Ingrese el numero de documento" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Usuario</label></td>
        <td><input list="usuLista" id="usuarioLista" name="propiedades" autocomplete="off" onkeyup="buscarLista(['usuario'], this.value,'usuario', 'usuario', 'usuLista', 'usuario') " class="campos-ingreso">
        <datalist id="usuLista">
          <option value=""></option>
        </datalist>
        <input type="hidden" name="usuario" id="usuario"></td>
           <td><label for="">Codigo Denver </label></td>
           <td><input type="text" name="cod_denver" id="cod_denver" value=""  placeholder="Ingrese el codigo Denver" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Oficina</label></td>
        <td>
          <input list="ofiLista" id="oficinaLista" name="propiedades" autocomplete="off" onkeyup="buscarLista(['dsc_oficina'], this.value,'oficina', 'dsc_oficina', 'ofiLista', 'oficina') " class="campos-ingreso">
          <datalist id="ofiLista">
            <option value=""></option>
          </datalist>
        <input type="hidden" name="oficina" id="oficina">
        </td>
        <td><label for="">Codigo Iconnect</label></td>
        <td><input type="text" name="cod_iconnect" id="cod_iconnect" value="" placeholder="Ingrese el codigo" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Moneda</label></td>
        <td><?php
         if(!(count($resultado)>0)){
             $inserta_Datos->crearMenuDesplegable('moneda','id','dsc_moneda','moneda');
         }else{
             $inserta_Datos->DesplegableElegido(@$resultado[20],'moneda','id','dsc_moneda','moneda');
         }

         ?></td>

        <td><label for="">Email</label></td>
        <td><input type="email" name="mail" id="mail" value="" placeholder="Ingrese el email" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Teléfono</label></td>
        <td><input type="text" name="tel1" id="tel1" value="" placeholder="Ingrese numero del teléfono" class="campos-ingreso"></td>

        <td><label for="">Celular</label></td>
        <td><input type="text" name="tel2" id="tel2" value="" placeholder="Ingrese numero del teléfono" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha fin Capacitacion</label></td>
        <td><input type="date" name="fe_finprueba" id="fe_finprueba" value=""  class="campos-ingreso"></td>

        <td><label for="">Categoria (%)</label></td>
        <td><input type="text" name="categoria" id="categoria" value="" placeholder="Ingrese el categoria" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha ingreso Paraguay</label></td>
        <td><input type="date" name="fe_ingreso_py" id="fe_ingreso_py" value="" class="campos-ingreso"></td>

        <td><label for="">Tipo</label></td>
        <td><?php $inserta_Datos->DesplegableElegidoFijo(@$resultado[14],'tipo',array('Individual','Team Member','Team Lider'))?></td>
      </tr>
      <tr>
        <td><label for="">Fecha ingreso internacional</label></td>
        <td><input type="date" name="fe_ingreso_int" id="fe_ingreso_int" value="" class="campos-ingreso"></td>

        <td><label for="">Fee. Mensual</label></td>
        <td><input type="number" name="fee_mensual" id="fee_mensual" value="" step="any" placeholder="Ingrese el Fee" class="campos-ingreso"></td>
      </tr>
      <tr>
        <td><label for="">Fecha cumpleaños</label></td>
        <td><input type="date" name="fe_cumple" id="fe_cumple" value=""  class="campos-ingreso"></td>

        <td> <label for="">Curso ACM</label></td>
        <td> <input type="checkbox" name="curso_acm" id="curso_acm" value="" class="campos-ingreso"></td>
        <?php
          if((count($resultado)>0) &&(@$resultado[21]=="SI")){
            echo "<script>document.getElementById('curso_acm').checked=true</script>";
          }
        ?>
      </tr>
      <tr>
        <td><label for="">Fee Afliacion</label></td>
        <td><input type="number" name="fee_afiliacion" id="fee_afiliacion" value="" step="any" placeholder="Ingrese el Fee" class="campos-ingreso"></td>

        <td><label for="">Curso FIRE UP</label></td>
        <td> <input type="checkbox" name="curso_fireUP" id="curso_fireUP" value="" class="campos-ingreso"></td>
        <?php
          if((count($resultado)>0) &&(@$resultado[22]=="SI")){
            echo "<script>document.getElementById('curso_fireUP').checked=true</script>";
          }
        ?>
      </tr>
      <tr>
        <td><label for="">Observación</label></td>
        <td><textarea name="obs" id="obs" class="campos-ingreso"></textarea></td>

        <td><label for="">Curso SUCCEED</label></td>
        <td> <input type="checkbox" name="curso_succeed" id="curso_succeed" value="" class="campos-ingreso"></td>
        <?php
          if((count($resultado)>0) &&(@$resultado[23]=="SI")){
            echo "<script>document.getElementById('curso_succeed').checked=true</script>";
          }
        ?>
      </tr>
    </tbody>
  </table>
<!-- moneda,tipo,simbolo -->
  <!-- BOTONES -->
  <input name="guardar" type="submit" value="Guardar" class="boton-formulario guardar">
  <input name="volver" type="button" value="Volver" onclick = "location='vendedor_panel.php';"  class="boton-formulario">
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


if (isset($_POST['vendedor'])) {
    //======================================================================================
    // NUEVO REGISTRO
    //======================================================================================
    if(isset($_POST['vendedor'])){
        $vendedor =trim($_POST['vendedor']);
        $nro_doc =trim($_POST['nro_doc']);
        $usuario =trim($_POST['usuario']);
        $cod_denver =trim($_POST['cod_denver']);
        $oficina =trim($_POST['oficina']);
        $cod_iconnect =trim($_POST['cod_iconnect']);
        $moneda =trim($_POST['moneda']);
        $mail =trim($_POST['mail']);
        $tel1 =trim($_POST['tel1']);
        $tel2 =trim($_POST['tel2']);
        $fe_ingreso_py =trim($_POST['fe_ingreso_py']);
        $categoria =trim($_POST['categoria']);
        $fe_ingreso_int =trim($_POST['fe_ingreso_int']);
        $tipo =trim($_POST['tipo']);
        $fe_cumple =trim($_POST['fe_cumple']);
        $fee_mensual =trim($_POST['fee_mensual']);
        $fe_finprueba =trim($_POST['fe_finprueba']);
        $obs =trim($_POST['obs']);
        $fee_afiliacion =trim($_POST['fee_afiliacion']);
        $curso_acm =trim(((isset($_POST['curso_acm']))?"SI":"NO"));
        $curso_fireUP =trim(((isset($_POST['curso_fireUP']))?"SI":"NO"));
        $curso_succeed =trim(((isset($_POST['curso_succeed']))?"SI":"NO"));
        $idForm=$_POST['Idformulario'];
        $creador ="UsuarioLogin";
        $campos = array( 'dsc_vendedor','nro_doc', 'usuario_id', 'cod_denver', 'oficina_id', 'cod_iconnect', 'moneda_id', 'mail', 'telefono1', 'telefono2','fe_ingreso_py','categoria','fe_ingreso_int','tipo','fe_cumple','fee_mensual','fe_finprueba','obs','fee_afiliacion','curso_acm','curso_fireUP','curso_succeed','creador');
        $valores="'".$vendedor."', '".$nro_doc."', '".$usuario."', '".$cod_denver."', '".$oficina."', '".$cod_iconnect."', '".$moneda."', '".$mail."', '".$tel1."','".$tel2."','".$fe_ingreso_py."','".$categoria."','".$fe_ingreso_int."','".$tipo."','".$fe_cumple."','".$fee_mensual."','".$fe_finprueba."','".$obs."','".$fee_afiliacion."','".$curso_acm."','".$curso_fireUP."','".$curso_succeed."','".$creador."'";
        //echo "$valores";
        //print_r($campos);
        /*
            VERIFICAR SI LOS DATOS SON PARA MODIFICAR UN REGISTRO O CARGAR UNO NUEVO
        */
        if(isset($idForm)&&($idForm!=0)){
            $inserta_Datos->modificarDato('vendedor',$campos,$valores,'id',$idForm);
        }else{
            $inserta_Datos->insertarDato('vendedor',$campos,$valores);
        }
    }
}
?>
<script type="text/javascript">


//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
	function verificar(){
  
		if($("#oficina").val()==""){
      popup('Advertencia','Es necesario ingresar el nombre de la oficina!!') ;
      return false ;
    }else if($("#direccion").val()==""){
      popup('Advertencia','Es necesario ingresar la direccion!!') ;
      return false ;
    }else if($("#email").val()==""){
      popup('Advertencia','Es necesario ingresar el correo electronico!!') ;
      return false ;
    }
  }
  </script>

</html>
