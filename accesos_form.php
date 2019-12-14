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
        $consultas=new Consultas();
        include("Parametros/verificarConexion.php");
        $id=$_POST['seleccionado'];
        $perfil=$consultas->consultarDatos(array('perfil'),'perfil','','id',$id);
        $perfil=$perfil->fetch_array(MYSQL_NUM);
        $perfil=$perfil[0];
        $cabecera=['Titulo','Grupo','Habilita'];
        $campos=['titulo_menu','(SELECT descripcion FROM grupo_menu WHERE id=grupo_menu_id) as Grupo',"(SELECT habilita FROM acceso WHERE menu_opcion_id=menu_opcion.id AND perfil_id = $id ) as Habilita"];
    ?>
    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">

      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/paneles.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>
</head>
<body style="background-color:white" >
<h2 class="titulo-formulario">CONTROL DE ACCESO</h2>
<h5 class="titulo-formulario">PERFIL: <?php echo $perfil;?></h5>
  <!-- DISEÑO DEL FORMULARIO, CAMPOS -->
<form name="perfilForm" method="POST" onsubmit="return verificar()" style="margin:0px" >
  <!-- Campo oculto para controlar EDICION DEL REGISTRO -->
    <input type="hidden" name="idformulario" id="idformulario" value=<?php echo $id;?> >
    <input type="hidden" name="Idformulario" id='Idformulario' value=<?php echo $id;?>>
    <div class="mostrar-tabla">
        <table id='tablaPanel' cellspacing='0' style='width:100%'>
            <?php
                $consultas->crearCabeceraTabla($cabecera);
                array_unshift($campos,'id');
                $resultadoConsulta=$consultas->consultarDatos($campos,'menu_opcion');
                echo "<tbody id='datosPanel'>";

                while($datos=$resultadoConsulta->fetch_array(MYSQLI_NUM)){
                    //echo "<script>datos=new Array('".$datos[0]."','$id',".(($datos[3]=="")?"'0'":"'1'").");tabla.push(datos)</script>";
                    echo "<tr class='datos-tabla' id='".$datos[0]."'>";
                    echo "<td>".$datos[1]."</td>";
                    echo "<td>".$datos[2]."</td>";
                    echo "<td>"."<input type='checkbox' ".((($datos[3]=="NO")||(is_null($datos[3])))?"":"checked='on'")."</td>";

                    echo "</tr>";
                }
                echo"</tbody>";

             ?>
        </table>
    </div>

  <!-- BOTONES -->
  <input name="guardar"  id="guardar" type="button" value="Guardar" class="boton-formulario guardar" onclick='guardarDatos();this.disabled=true'>
  <input name="volver" type="button" value="Volver" class="boton-formulario" onclick = "location='perfil_panel.php';" >
</form>


</body>

<script type="text/javascript">
    var tabla=new Array();

//======================================================================
// FUNCION QUE VALIDA EL FORMULARIO Y LUEGO ENVIA LOS DATOS A GRABACION
//======================================================================
    function guardarDatos(){
		document.getElementById('guardar').style.display='none' ;
        var datos=document.getElementById("datosPanel");
        var id,perfil,habilita,pack;
        perfil=document.getElementById('Idformulario').value;
        $.post("Parametros/eliminarGenerico.php", {id : perfil , tabla : 'acceso',campoIdentificador:'perfil_id'}, function(msg) {
            console.log(msg);
            if(msg!=1){
                popup('Error',"ERROR EN LA ELIMINACION DEL REGISTRO");
            }
        });
        for (var i = 0; i < datos.childElementCount; i++) {
            id=datos.childNodes[i].id
            habilita=(datos.childNodes[i].childNodes[2].childNodes[0].checked==false)?'NO':'SI';

            pack=new Array(id,perfil,habilita);
            tabla.push(pack);
        }
        setTimeout(function (){
        for (var filaReal of tabla) {
            var fila=filaReal.slice();
            console.log(fila+"\n");

            insertar('acceso',new Array('menu_opcion_id','perfil_id','habilita'),fila);
        }},400);
        // setTimeout(function (){window.location='perfil_panel.php'},800);
    }

    function insertar(tabla,campos,valores){
        $.post("Parametros/insertarDatos.php",{campos:campos,tabla:tabla,valores:valores}, function(resultado) {
            console.log(resultado);
            res=resultado;
         });
    }
  </script>

</html>
