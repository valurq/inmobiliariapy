<!DOCTYPE html>
<?php
session_start();
include("Parametros/conexion.php");
$consultas=new Consultas();
include("Parametros/verificarConexion.php");
// ========================================================================
//Seteo de cabecera y campos en el mismo orden para tomar de la $tabla
// ========================================================================
$cabecera=['Usuario','Nombre','Apellido','Cargo','Perfil','F. Creación', '¿Esta asignado?'];
$campos=['usuario','nombre','apellido','cargo','(SELECT perfil FROM perfil WHERE id=perfil_id)','fecreacion', 'asignado'];

?>
<html lang="en" dir="ltr">

    <head>
          <link rel="stylesheet" href="CSS/popup.css">
          <link rel="stylesheet" href="CSS/paneles.css">
      <script
        src="https://code.jquery.com/jquery-3.4.0.js"
        integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
        crossorigin="anonymous">
    </script>
      <script type="text/javascript" src="Js/funciones.js"></script>

      <script type="text/javascript">
      // para busqueda en paneles
          var campos=['usuario','nombre','apellido','cargo','(SELECT perfil FROM perfil WHERE id=perfil_id)','fecreacion', 'asignado'];
      </script>

        <meta charset="utf-8">
        <style media="screen">
            .menu-panel{
                width: 100%
            }
            .mostrar-tabla{
                width: 100%;
            }
        </style>
        <title>VALURQ_SRL</title>
    </head>

    <body style="background-color:white" >
      <!--============================================================================= -->
      <!--CAMPO OCULTO UTILIZADO PARA LA EDICION -->
      <!--============================================================================= -->
              <form id="formularioMultiuso" action="" method="post">
                  <input type="hidden" name="seleccionado" id="seleccionado" value="0">
              </form>
      <!--============================================================================= -->
  <div class="menu-panel" >
      <!--campo buscador en el panel -->
        <h2 class='titulo-panel'>PANEL DE USUARIOS</h2>


            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='usuario_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('usuario_form.php')" >
            <input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="popupC('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles',function (){eliminar('usuario')},'usuario')" >
            <!-- <input type="button" class="boton_panel" name="Asignado" value="Cambiar asignacion" onclick="popupC('Advertencia','Esta seguro de que desea modificar la asignacion?', () => {cambiarEstado()})"> -->
        </div>

        <div class="mostrar-tabla">
            <?php  $consultas->crearTabla($cabecera,$campos,'usuario');?>
        </div>

    </body>
    <script>
      /*function cambiarEstado() {
        var sel=document.getElementById('seleccionado').value;
         if((sel=="")||(sel==' ')||(sel==0)){
             popup('Advertencia',"DEBE SELECCIONAR UN ELEMENTO PARA PODER MODIFICARLO");
         }else {
             //metodo,url destino, nombre parametros y valores a enviar, nombre con el que recibe la consulta
             $.post("Parametros/modificarDatos.php", {campos: new Array('asignado'), tabla: 'usuario', valores: new Array('NO'), campoCondicion: 'id', valorCondicion: sel}, function(msg) {
                 console.log(msg);
                 if(msg==0){
                     document.getElementById('seleccionado').value="";
                     location.reload();
                 }else{
                     popup('Error',"ERROR EN LA MODIFICACION DEL REGISTRO");
                 }
              });
         }
      }*/
    </script>
</html>
