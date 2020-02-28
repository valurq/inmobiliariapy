<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
    session_start();
    include("Parametros/conexion.php");
    $consulta= new Consultas();
    include("Parametros/verificarConexion.php");
    $perfil=$_SESSION['perfil'];

    $nombreUsuario = $consulta->consultarDatosQ(['nombre ','apellido'], 'usuario', '','id', $_SESSION['idUsu']);
    $nombreUsuario = $nombreUsuario->fetch_array(MYSQLI_NUM);
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

        <div class="cabecera">
                <div id="logo">
                    <img src="Imagenes/letra_remax.svg" width="230" height="100">
                </div>

                <div id="titulo">GESTION DE OPERACIONES</div>
                
                <div class="dropdown">
                    <button class="btndrop">
                       <span><?php echo $nombreUsuario[0].'<br />'.$nombreUsuario[1].' &#x25BC' ?></span>

                       <div class="dropdownContent">
                            <a href="#" onclick="document.getElementById('miPerfil').submit();accionConf()">Mi perfil</a>    
                            <a href="#" onclick="">Acerca de</a>
                            <a href="#" onclick="abrirIframe('contrasenha_form.php');accionConf()">Cambiar contraseña</a>
                            <a href="#" onclick="cerrarSesion()">Cerrar sesión</a>
                       </div>
                    </button>
                </div>
        </div> 

        <div class="content">
            <div class="lateral">

                <ul class="lista">
                        <?php   $cont=0; $menu=crearMenuAgrupador($perfil);?>
                </ul>

                <div class="footer">
                    <div id='texto'>Desarrollado por Valurq </div>
                </div>

            </div>
                
            <div class="workArea">
                <iframe src="" frameborder="0" name="frame-trabajo" id="frame-trabajo" width="560" height="315" scrolling="auto" allowfullscreen></iframe>
            </div>
        </div>

    </body>
    <script type="text/javascript">
        let nombre

        function abrirSubMenu(grupo, etiqueta){
            document.getElementById('grupoSel').value=grupo;
            document.getElementById('form-menu').submit();

            if(document.getElementsByClassName('current')[0]){
                document.getElementsByClassName('current')[0].setAttribute('class', '');
            }
            etiqueta.parentElement.className = 'current';
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
        function abrirIframe(url){
            window.open(url,"frame-trabajo");
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
            //echo $sql;
            $resultado=$consulta->conexion->query($sql);

            while ($fila=mysqli_fetch_array($resultado)) {
                    echo "<li><a data-hover='$fila[0]' onclick='abrirSubMenu(".$fila[1].", this)'>$fila[0] </a></li>";
                    $cont++;
            }
        }

        //$menu=consultarMenu($_SESSION['perfil']);
    ?>
</html>
