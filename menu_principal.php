<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
    session_start();
    include("Parametros/conexion.php");
    $consulta= new Consultas();
    include("Parametros/verificarConexion.php");

 ?>
    <head>
        <script>
            var cont=1;
        </script>

        <script
              src="https://code.jquery.com/jquery-3.4.0.js"
              integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
              crossorigin="anonymous">
        </script>

        <script type="text/javascript" src="Js/funciones.js"></script>


        <link rel="stylesheet" href="CSS/menu.css">
        <meta charset="utf-8">
        <title>SGD-VALURQ SRL</title>
    </head>

    <body style="">
        <form id='form-menu' target="frame-trabajo" action="submenu_principal.php" method="POST">
            <input type="hidden" name="grupoSel" id='grupoSel'>
        </form>
        <form target='frame-trabajo' id='miPerfil' action="perfil_info.php" method="post">
            <input type="hidden" name="seleccionado" value=<?php echo $_SESSION['idUsu'];?>>
        </form>
        <div class="menu-contenedor">
            <div class="lateral-izquierdo">
                <div id="logo"></div>
                <div id="menu-items">
                    <?php   $cont=0; $menu=crearMenuAgrupador(2);?>

                </div>
            </div>
            <div class="superior">
                <div id="titulo-sistema">GESTION DE OPERACIONES</div>
                <div id="usuario" onclick="accionConf()">
                    <div id='usuario-ico'>
                    </div>
                </div>
                <div class="opciones" id='opciones'>
                    <table style="width:100%">
                        <tr class='opciones-conf' onclick="document.getElementById('miPerfil').submit();accionConf()"><td>Mi perfil</td></tr>
                        <tr class='opciones-conf'><td>Acerca de</td></tr>
                        <tr class='opciones-conf'><td>Cambiar Contraseña</td></tr>
                        <tr class='opciones-conf' onclick="cerrarSesion()"><td>Cerrar Sesión</td></tr>
                    </tr>
                </table>
                </div>
            </div>
            <div class="area-trabajo">
                <iframe src="" frameborder="0" name="frame-trabajo" id="frame-trabajo"></iframe>
            </div>
        </div>


    </body>
    <script type="text/javascript">
        function abrirSubMenu(grupo){
            document.getElementById('grupoSel').value=grupo;
            document.getElementById('form-menu').submit();
        }
        function accionConf(){
            var obj=document.getElementById('opciones');
            var display=obj.style.display;
            console.log("display:"+display);
            if(display!="block"){
                console.log("blocked");
                document.getElementById('opciones').style.display="block";
            }else {
                console.log("prueba52");
                document.getElementById('opciones').style.display="none";
            }

        }
        function cerrarSesion(){
            window.location='cerrarSesion.php'
        }

    </script>
    <?php
        function crearMenuAgrupador($perfil){
            global $consulta;
            global $cont;

            /*
                METODO PARA PODER CONSULTAR DATOS REFERENTES AL MENU
                $objetoConsultas->consultarMenu(<ID de usuario>)
            */
            $sql="SELECT
            (SELECT (SELECT descripcion FROM grupo_menu WHERE id=grupo_menu_id) FROM menu_opcion WHERE id=menu_opcion_id GROUP BY grupo_menu_id) as Descripcion,
            (SELECT grupo_menu_id FROM menu_opcion WHERE id=menu_opcion_id GROUP BY grupo_menu_id) as G_id
            FROM acceso WHERE perfil_id = $perfil AND habilita = 'SI'
            GROUP BY Descripcion";

            $resultado=$consulta->conexion->query($sql);

            while ($fila=mysqli_fetch_array($resultado)) {
                    echo "<div id='b+".$cont."' class='menu-opcion ' onclick='abrirSubMenu(".$fila[1].")'>
                            <div class='titulo-opcion' id='d+".$cont."' >$fila[0] </div>
                        </div>
                    ";
                    $cont++;
            }
        }

        //$menu=consultarMenu($_SESSION['perfil']);
    ?>
</html>
