<?php
    session_start();
    include("Parametros/conexion.php");
    $consulta= new Consultas();
    include("Parametros/verificarConexion.php");
    $grupo=$_POST['grupoSel'];
    //$grupo='2';
    //$perfil=$_SESION['perfil']
    $perfil=2;


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <style media="screen">
        .contenedor{

            height: 100vh;
            display: grid;
            grid-template-columns: repeat(6, [col-start] 150px);
            grid-auto-rows: 200px;
            /*grid-auto-rows: auto;*/
            grid-gap: 30px;
            padding: 30px;
            box-sizing: border-box;
            }
            .subMenu{
                box-sizing: border-box;
                padding: 20px 10px 10px 10px;
            }
            .icono{
                width: 100%;
                height: 130px;
                background-size: 100% 100%;
                background-repeat: no-repeat;
            }
            .titulo{
                margin-top: 5px;
                text-align: center;
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
