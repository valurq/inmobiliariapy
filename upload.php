
<?php

///    NUEVO ARCHIVO UPLOAD.PHP
echo '<pre>';
$img = $_FILES['img'];

if(!empty($img))
{
    $img_desc = reArrayFiles($img);
    // print_r($img_desc);

    foreach($img_desc as $val)
    {
        $newname = 'nery_'.mt_rand().'.jpg';
        echo $newname ."<br>";
        move_uploaded_file($val['tmp_name'],'./almacen_digital/'.$newname);
    }
}


?>
