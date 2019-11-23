<?php
    session_start();
    include("Parametros/conexion.php");
    //include("Parametros/verificarConexion.php");
    $consultas=new Consultas();
    $asuntos_list = array(array("id" => -1, "asunto" => "Todos"));

    // ========================================================================
    //Seteo de cabecera y campos en el mismo orden para tomar de la $tabla
    // ========================================================================
    $asunto = "(SELECT asunto FROM asuntos asu WHERE asuntos_id = asu.id)"; 
    $cabecera=['ID','Fecha Creación','Asunto','Tipo','Criticidad','Solicitante','Estado'];
    $campos=['id','fecreacion',$asunto,'tipo','criticidad','solicitante','estado'];

    //obtencion de los asuntos para usarlos como filtros
    $aux = $consultas->consultarDatos(array('id','asunto'),'asuntos');
    if(gettype($aux)!="boolean"){
      while($row = $aux->fetch_assoc()){
        array_push($asuntos_list,$row);
      }
    }
    
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
      <title>Módulo de Tickets</title>
      <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/paneles.css">
      <script src="JS/jquery-3.4.0.js"></script>
      <script src="JS/funciones.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script type="text/javascript">
         // para busqueda en paneles
         var asunto = "(SELECT asunto FROM asuntos asu WHERE asuntos_id = asu.id)";
         var campos=['id','fecreacion',asunto,'tipo','criticidad','solicitante','estado'];
      </script> 
        <style media="screen">
            .menu-panel{
                width: 100%
            }
            .mostrar-tabla{
                width: 100%;
            }
        </style>
    </head>
    <body class="container-fluid" style="background-color:white">
      <!--============================================================================= -->
            <!--CAMPO OCULTO UTILIZADO PARA LA EDICION -->
      <!--============================================================================= -->
        <form id="formularioMultiuso" action="" method="post">
            <input type="hidden" name="seleccionado" id="seleccionado" value="0">
        </form>
      <!--============================================================================= -->

     <div class="menu-panel" >
        <div id="resultadoBusqueda">
        <br><br>
        <!---TITULO DEL PANEL-->
        <div class="wpmd" id="text1" style="position:absolute; overflow:hidden; left:10px; top:10px; width:540px; height:22px; z-index:1">
            <font color="#808080" class="ws12"><B>PANEL DE TICKETS</B></font>
        </div>
        <div class="row mb-3">
            <!--FILTROS DEL PANEL-->   
            <div class="col-sm-2">        
                <label for="asunto">Buscar:</label>     
                <select class="form-control form-control-sm" name="asunto" id="asunto" onchange="buscar();">
                    <?php foreach($asuntos_list as $element): ?>
                        <option value="<?php echo $element['id']; ?>">
                            <?php echo $element['asunto']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-2">    
                <label for="tipo">Tipos:</label>
                <select class="form-control form-control-sm" name="tipo" id="tipo" onchange="buscar();">
                    <option value="Todos">Todos</option>
                    <option value="Consulta">Consulta</option>
                    <option value="Reclamo">Reclamo</option>
                    <option value="Queja">Queja</option>
                    <option value="Servicio">Solicitud de Servicio</option>
                    <option value="Sugerencia">Sugerencia</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>
            <div class="col-sm-2">    
                <label for="criticidad">Criticidad:</label>
                <select class="form-control form-control-sm" name="criticidad" id="criticidad" onchange="buscar();">
                    <option value="Todos">Todos</option>
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                    <option value="Urgente">Urgente</option>
                </select>
            </div>
            <div class="col-sm-2">    
                <label for="estado">Estados:</label>
                <select class="form-control form-control-sm" name="estado" id="estado" onchange="buscar();">
                    <option value="Todos">Todos</option>    
                    <option value="Nuevo">Nuevo</option>
                    <option value="Asignado">Asignado</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Resuelto">Resuelto</option>
                    <option value="Cerrado">Cerrado</option>
                    <option value="Eliminado">Eliminado</option>
                </select>
            </div>
            <div class="col-sm-2">    
                <label for="fecha_desde">Desde:</label>
                <input class="form-control form-control-sm" name="fecha_desde" id="fecha_desde" type="date" onchange="buscar();" onkeydown="buscar();">
            </div>
            <div class="col-sm-2"> 
                <label for="fecha_hasta">Hasta:</label>
                <input class="form-control form-control-sm" name="fecha_hasta" id="fecha_hasta" type="date" onchange="buscar();" onkeydown="buscar();">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-12 text-right">
                <!--ACCIONES DEL PANEL-->
                <input type="button" class="boton_panel" name="Limpiar" onclick="limpiarFiltros();"  value="Limpiar Filtros">
                <input type="button" class="boton_panel" name="Nuevo" onclick = "location='ticket_form.php';"  value="Nuevo">
                <input type="button" class="boton_panel" name="Editar" value="Editar" onclick="editar('ticket_form.php')" >
                <input type="button" class="boton_panel" name="Eliminar" value="Eliminar" onclick="updateTicketStatus();" >
            </div>
        </div>
    </div>

        <div class="mostrar-tabla">
            <?php  $consultas->crearTabla($cabecera,$campos,'ticket');?>
        </div>
    </body>
     
    <script>
        function buscar(){
            //Inicializacion de Variables{
                var where = "WHERE";
                var c = 0;
                var asunto = document.getElementById("asunto");
                var tipo = document.getElementById("tipo");
                var criticidad = document.getElementById("criticidad");
                var estado = document.getElementById("estado");
                var fecha_desde = document.getElementById("fecha_desde");
                var fecha_hasta = document.getElementById("fecha_hasta");
            //}

            //Formacion de la clausula where{
                if(asunto.value != -1){
                    where += " asuntos_id ="+asunto.value
                    c++; 
                }
                if(tipo.value != "Todos"){
                    if(c > 0){
                        where += " AND tipo='"+tipo.value+"'";
                    }else{
                        where += " tipo='"+tipo.value+"'";
                    } 
                    c++;
                }
                if(criticidad.value != "Todos"){
                    if(c > 0){
                        where += " AND criticidad='"+criticidad.value+"'";
                    }else{
                        where += " criticidad='"+criticidad.value+"'";
                    }
                    c++; 
                }
                if(estado.value != "Todos"){
                    if(c > 0){
                        where += " AND estado='"+estado.value+"'";
                    }else{
                        where += " estado='"+estado.value+"'";
                    }
                    c++; 
                }else{
                    if(c > 0){
                        where += " AND estado!='Eliminado'";
                    }else{
                        where += " estado!='Eliminado'";
                    }
                    c++;  
                }
                
                if(fecha_desde.value != null && fecha_desde.value != ""){
                    //if(validarFechaPattern(fecha_desde)){
                        if(c > 0){
                            where += " AND fecha>='"+fecha_desde.value+"'";
                        }else{
                            where += " fecha>='"+fecha_desde.value+"'";
                        } 
                    /*}else{
                        console.log("Fecha desde es invalida --> "+fecha_desde.value);
                    }*/
                    c++;
                }
                if(fecha_hasta.value != null && fecha_hasta.value != ""){
                    //if(validarFechaPattern(fecha_hasta)){
                        if(c > 0){
                            where += " AND fecha<='"+fecha_hasta.value+"'";
                        }else{
                            where += " fecha<='"+fecha_hasta.value+"'";
                        } 
                    /*}else{
                        console.log("Fecha hasta es invalida --> "+fecha_hasta.value);
                    }*/
                }
                   
            //}
            
            buscarTablaPanelesCustom(campos,'ticket',where);

        }

        buscar(); //se le llama para filtrar por defecto los tickes en estado "Eliminado"

        function updateTicketStatus(){
            var seleccionado = document.getElementById("seleccionado"); //el id del ticket
            var campos = ["estado"];
            var valores = ["Eliminado"];
            $.post("Parametros/modificarDatos.php",
                 { tabla: "ticket" ,campos:campos, valores:valores, valorCondicion:seleccionado.value
                 ,campoCondicion: "id" }, function(resultado) {
                    console.log(resultado);
                    if(resultado=="0"){
                        popup("Informacion","El ticket se ha eliminado satisfactoriamente");
                    }else{
                        popup("Error","No se ha podido eliminar el ticket");
                    }
                    buscar();
                 }
            );
        }

        function limpiarFiltros(){
            var asunto = document.getElementById("asunto");
            var tipo = document.getElementById("tipo");
            var criticidad = document.getElementById("criticidad");
            var estado = document.getElementById("estado");
            var fecha_desde = document.getElementById("fecha_desde");
            var fecha_hasta = document.getElementById("fecha_hasta");

            asunto.selectedIndex = 0;
            tipo.selectedIndex = 0;
            criticidad.selectedIndex = 0;
            estado.selectedIndex = 0;
            fecha_desde.value = "";
            fecha_hasta.value = "";

            buscar();


        }

    </script>

</html>
