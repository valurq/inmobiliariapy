<!DOCTYPE html>
<?php
session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
    include("Parametros/verificarConexion.php");

// DATOS
$cabecera=['Nombre', 'Apellido' ,'Nro de C.I.', 'Teléfono<br />Particular', 'Teléfono<br />Celular','Fecha de ingreso','Estado Civil','Estado', 'Experiencia en<br />Bienes Raices'];
$campos=['nombrefull', 'apellido', 'nro_doc', 'telefono1', 'telefono2','fec_ingreso','est_civil','estado', 'sededico'];


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
            var campos=['nombrefull', 'apellido', 'nro_doc', 'telefono1', 'telefono2','fec_ingreso','est_civil','estado', 'sededico'];
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

    <body style="background-color:white">
<!--============================================================================= -->
      <!--CAMPO OCULTO UTILIZADO PARA LA EDICION -->
<!--============================================================================= -->
        <form id="formularioMultiuso" action="" method="post">
            <input type="hidden" name="seleccionado" id="seleccionado" value="0">
        </form>
<!--============================================================================= -->

        <div class="menu-panel" >

            <br><br>
            <!--campo buscador en el panel -->
            <input type="text" name="buscador" id="buscador" placeholder="Buscar por nombre" onkeyup="buscarTablaPaneles(campos, this.value ,'personal','nombrefull')">
            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:50%; height:22px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE SOLICITUD DE ALTA CANDIDATO</B></font>
            </div>

            <input type="button" class="boton_panel" name="Nuevo" onclick = "location='personal_form.php';" value="Nuevo">
            <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('personal_form.php')">
            <input type="button" class="boton_panel" name="Eliminar" value="Dar de baja" onclick="popupC('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles', () => {cambiarEstado()})">
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar"
            id="eliminarTest" onclick="popupC('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles',function (){eliminar('personal')},'personal')">-->
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
            <?php
             $consultas->crearTabla($cabecera,$campos,'personal', '', '', ['10%','10%','11%','11%','11%','11%','11%','14%','10%']);

            ?>
        </div>
    </body>
    
    <script>
    	function cambiarEstado() {
            var sel=document.getElementById('seleccionado').value;
               if((sel=="")||(sel==' ')||(sel==0)){
                   popup('Advertencia',"DEBE SELECCIONAR UN ELEMENTO PARA PODER ELIMINARLO");
               }else {
              		popup('Advertencia','Esta seguro de que desea eliminar? los cambios son irreversibles');
                   //metodo,url destino, nombre parametros y valores a enviar, nombre con el que recibe la consulta
                   $.post("Parametros/modificarDatos.php", {campos: new Array('estado'), tabla: 'personal', valores: new Array('INACTIVO'), campoCondicion: 'id', valorCondicion: sel}, function(msg) {
                       console.log(msg);
                       if(msg==0){
                           document.getElementById('seleccionado').value="";
                           location.reload();
                       }else{
                           popup('Error',"ERROR EN LA ELIMINACION DEL REGISTRO");
                       }
                    });
               }
            }
    </script>

</html>
