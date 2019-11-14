<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <?php
        /*
        SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
        ========================================================================
        */
        session_start();
        include("Parametros/conexion.php");
        $consulta=new Consultas();
        include("Parametros/verificarConexion.php");
        $id=0;
        $resultado="" ;
        /*
            VALIDAR SI EL FORMULARIO FUE LLAMADO PARA LA MODIFICACION O CREACION DE UN REGISTRO
        */
        if(isset($_POST['seleccionado'])){
            $id=$_POST['seleccionado'];
            $campos=array('usuario','nombre','apellido','mail','cargo','obs','perfil_id');
            /*
                CONSULTAR DATOS CON EL ID PASADO DESDE EL PANEL CORRESPONDIENTE
            */
            $resultado=$consulta->consultarDatos($campos,'usuario',"","id",$id );
            $resultado=$resultado->fetch_array(MYSQLI_NUM);
            /*
                CREAR EL VECTOR CON LOS ID CORRESPONDIENTES A CADA CAMPO DEL FORMULARIO HTML DE LA PAGINA
            */
            $camposIdForm=array('usuario','nombre','apellido','correo','cargo','observacion');
        }
    ?>
    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">

      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>

</head>
<body style="background-color:white" >
<h2 class="titulo-formulario">USUARIO</h2>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="usuarioForm" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="idformulario" id="idformulario" value=<?php echo $id;?> >
    <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
    <table class="tabla-fomulario">
      <tbody>
        <tr>
          <td><label for="">Usuario</label></td>
          <td><input type="text" name="usuario" id="usuario" value="" class='campos-ingreso' readonly></td>
        </tr>
        <tr>
          <td><label for="">Perfil</label></td>
          <td><?php
                $idElegido=$resultado[6];
                $nombreLista='perfil';
                $campoID='id';
                $campoDescripcion='perfil';
                $tabla='perfil';
                $lista="<select name='".$nombreLista."' class='campos-ingreso' readonly>";
                $campos= array('id','perfil' );
                $res=$consulta->consultarDatos($campos,$tabla);
                $lista.=$consulta->OpcionesElegidas($res, $idElegido);
                $lista.="</select>";
                echo $lista;
           ?></td>
        </tr>
        <tr>
          <td><label for="">Nombre</label></td>
          <td><input type="text" name="nombre" id="nombre" value="" class='campos-ingreso' readonly></td>
        </tr>
        <tr>
          <td><label for="">Apellido</label></td>
          <td><input type="text" name="apellido" id="apellido" value="" class='campos-ingreso' readonly></td>
        </tr>
        <tr>
          <td><label for="">Cargo</label></td>
          <td><input type="text" name="cargo" id="cargo" value="" class='campos-ingreso' readonly></td>
        </tr>
        <tr>
          <td><label for="">Correo</label></td>
          <td><input type="email" name="correo" id="correo" value="" class='campos-ingreso' readonly></td>
        </tr>
        <tr>
          <td><label for="">Observacion</label></td>
          <td><textarea name="observacion" id='observacion' class='campos-ingreso' readonly></textarea> </td>
        </tr>
      </tbody>
    </table>
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
?>
</html>
