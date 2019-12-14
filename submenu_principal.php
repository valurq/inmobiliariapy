<?php
    session_start();
    include("Parametros/conexion.php");
    $consulta= new Consultas();
    include("Parametros/verificarConexion.php");
    $grupo=$_POST['grupoSel'];
    //$grupo='2';
    $perfil=$_SESSION['perfil']
    //$perfil=2;


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <style media="screen">
        .contenedor{

            height: 100vh;
            width: 100%;
            display: grid;
            /*grid-template-columns: repeat(6, [col-start] 150px);*/
            grid-template-columns: repeat( auto-fit, 120px );
            /*grid-auto-columns: 150px;*/
            grid-auto-rows: 150px;
            /*grid-auto-rows: auto;*/
            grid-gap: 30px;
            padding: 30px;
            box-sizing: border-box;
            }
            .subMenu{
                display: flex;
                flex-direction: column;
                box-sizing: border-box;
                /*padding: 20px 10px 10px 10px;*/
                align-items: center;
            }
            .subMenu:hover{
                cursor:pointer;
                box-shadow: 5px 10px 10px #9d9d9d;
            }
            .icono{
                width: 50%;
                height: 80px;
                float: left;
                clear: both;
                background-size: 100% 100%;
                background-repeat: no-repeat;

            }
            .titulo{
                float: left;
                clear: both;
                margin-top: 5px;
                text-align: center;
                font-family: Arial;
            }
        </style>
        <title></title>
    </head>
    <body>
        <div class="contenedor">
        <?php
        $sql="SELECT titulo_menu,icono,link_acceso FROM `menu_opcion` WHERE grupo_menu_id =$grupo AND id IN (SELECT menu_opcion_id FROM acceso WHERE perfil_id=$perfil AND habilita = 'SI' )";
        $resultado=$consulta->conexion->query($sql);
        while ($fila=mysqli_fetch_array($resultado)) {
            $imagen="'".$fila[1]."'";
            $titulo=$fila[0];
            $link="'".$fila[2]."'";
            echo '
            <div class="subMenu" onclick="window.location='.$link.'">
                <div class="icono" style="background-image:url('.$imagen.')"></div>
                <div class="titulo">
                    '.$titulo.'
                </div>
            </div>

            ';
        }
         ?>
        </div>
    </body>
</html>
