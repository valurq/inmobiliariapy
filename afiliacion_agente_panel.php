<!DOCTYPE html>
<?php
session_start();
include("Parametros/conexion.php");
$consultas = new Consultas();
include("Parametros/verificarConexion.php");
echo $_SESSION['idUsu'];
$manager=$consultas->consultarDatos(['count(*)'],'manager','','usuario_id',$_SESSION['idUsu']);
$manager=$manager->fetch_array(MYSQLI_NUM);
$manager=$manager[0]; // lo mismo hacer para broker
$broker=$consultas->consultarDatos(['count(*)'],'brokers','','usuario_id',$_SESSION['idUsu']);
$broker=$broker->fetch_array(MYSQLI_NUM);
$broker=$broker[0];
$agente=$consultas->consultarDatos(['count(*)'],'vendedor','','usuario_id',$_SESSION['idUsu']);
$agente=$agente->fetch_array(MYSQLI_NUM);
$broker=$broker[0];
$idOficina;
$idVendedor;
if ($manager > 0) {
  $idOficina=$consultas->consultarDatos(array('oficina_id'),'manager','','usuario_id',$_SESSION['idUsu']);
  $idOficina=$idOficina->fetch_array(MYSQLI_NUM);
  $idOficina=$idOficina[0];
//  echo $idOficina;
}elseif ($broker >0) {
  $idOficina=$consultas->consultarDatos(array('oficina_id'),'brokers','','usuario_id',$_SESSION['idUsu']);
  $idOficina=$idOficina->fetch_array(MYSQLI_NUM);
  $idOficina=$idOficina[0];
  //echo $idOficina;
}elseif ($agente) {
  $idVendedor=$consultas->consultarDatos(array('id'),'vendedor','','usuario_id',$_SESSION['idUsu']);
  $idVendedor=$idVendedor->fetch_array(MYSQLI_NUM);
  $idVendedor=$idVendedor[0];
  //echo "vendedor".$idVendedor;
}
//verificar si es broker (['count(*)'],'broker','usuario_id',$idusuario)
// DATOS
$cabecera=['Vendedor','Fecha vto','Importe','Estado','Fecha de pago','Nro comprobante','Concepto'];
$campos=['(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id)','fe_vto','importe','estado','fe_pago','nro_comprob','substr(concepto,1,30)'];
// test

function crearContenidoTabla2($resultadoConsulta){
     /*
         METODO PARA PODER CREAR LOS DATOS DENTRO DE UNA TABLA
         $objetoConsultas->crearContenidoTabla(<Resultado de consulta a la base de datos>);
     */
     echo "<tbody id='datosPanel'>";

     while($datos=$resultadoConsulta->fetch_array(MYSQLI_NUM)){
         echo "<tr class='datos-tabla' onclick='seleccionarFila($datos[0])' id='".$datos[0]."'>";
         array_shift($datos);
         foreach( $datos as $valor ){
             echo "<td>".$valor." </td>";
         }
         echo "</tr>";
     }
     echo"</tbody>";
 }

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
            var campos=['(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id)','fe_vto','importe','estado','fe_pago','nro_comprob','substr(concepto,1,30)'];
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
            <input type="text" name="buscador" id="buscador" onkeyup="buscarTablaPaneles(campos, this.value ,'afiliacion_agente','(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id)')">
            <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:300px; z-index:1">
                <font color="#808080" class="ws12"><B>PANEL DE CUENTAS AGENTES</B></font>
            </div>

            <input type="button" class="boton_panel" name="Editar" value="Ver" onclick="editar('afiliacion_agente_form.php')">
            <input type="button" class="boton_panel" name="Eliminar" value="Cobrar"
            id="eliminarTest" onclick="editar('cobros_agentes_form.php')">
            <!--<input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="eliminar('categoria')">-->
        </div>

        <div class="mostrar-tabla">
          <table id='tablaPanel' cellspacing='0' style='width:100%'>

            <?php
            // echo "select (SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id),fe_vto,importe,estado,fe_pago,nro_comprob,substr(concepto,1,30)
            //  from afiliacion_agente where vendedor_id in (select id from vendedor where oficina_id = $idOficina ";
            if (empty($idVendedor)) {
              $datoTabla=$consultas->conexion->query("select id,(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id),fe_vto,importe,estado,fe_pago,nro_comprob,substr(concepto,1,30)
              from afiliacion_agente where vendedor_id in (select id from vendedor where oficina_id = $idOficina )");
              //echo "select (SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id),fe_vto,importe,estado,fe_pago,nro_comprob,substr(concepto,1,30)  from afiliacion_agente where vendedor_id in (select id from vendedor where oficina_id = $idOficina )";
              // code...
            }else{
              $datoTabla=$consultas->conexion->query("select id,(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id),fe_vto,importe,estado,fe_pago,nro_comprob,substr(concepto,1,30) from afiliacion_agente where vendedor_id = $idVendedor ");
            //  echo "select id,(SELECT dsc_vendedor FROM vendedor WHERE id=vendedor_id),fe_vto,importe,estado,fe_pago,nro_comprob,substr(concepto,1,30) from afiliacion_agente where vendedor_id = $idVendedor )";

            }

             //$consultas->crearTabla($cabecera,$campos,'afiliacion_agente');
             $consultas->crearCabeceraTabla($cabecera);
            crearContenidoTabla2($datoTabla);
            ?>
          </table>
        </div>
    </body>

</html>
