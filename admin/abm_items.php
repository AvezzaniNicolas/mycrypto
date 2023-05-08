<?php


$title="Modificar Proyecto";
/* Llamar la Cadena de Conexion*/ 
require "../conexion.php";
require "../vendor/autoload.php";
use BenMajor\ImageResize\Image;

function imagen(){
    require "../conexion.php";

    if (isset($_POST['update'])) {
        $idproyecto=$_POST['id_proyecto'];
        $consulta= "SELECT imagen_proyecto from proyectos where idproyecto='$idproyecto'";
        $query=mysqli_query($conexion,$consulta);
       //     $imgBD=$query->fetch_array(MYSQL_ASSOC);

        if (empty($_FILES['imagen'])) {
            return $imgBD['imagen'];
        }else{
            if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {

                $errores=0;

                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $name = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
                $mimeType = $_FILES['imagen']['type'];

                $extension2 = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $name2 = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
                $mimeType2 = $_FILES['imagen']['type'];

                # Generate a new image resize object using a upload image:
                $image = new Image($_FILES['imagen']['tmp_name']);
                $image2 = new Image($_FILES['imagen']['tmp_name']);

                
                # Set the background to white:
                $image->setBackgroundColor('#212121');

                # Contain the image:
                $image->contain(300);

                $image->output("../img/Proyectos");
                $image2->output("../img/Proyectos2"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

                # Renombrar la imagen genereda por el metodo output

                rename($image->getOutputFilename(), "../img/Proyectos/".$name);
                rename($image2->getOutputFilename(), "../img/Proyectos2/".$name2);
                }

                if (empty($errores)==true) {
                    move_uploaded_file($image, "../img/Proyectos/".$name);
                    move_uploaded_file($image2, "../img/Proyectos2/".$name2);
                    return $name;
                }
                else{

                    print_r($errores);

                }
            }


    }   



if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {


    $errores=0;

    $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $name = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
    $mimeType = $_FILES['imagen']['type'];

    $extension2 = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $name2 = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
    $mimeType2 = $_FILES['imagen']['type'];

    # Generate a new image resize object using a upload image:
    $image = new Image($_FILES['imagen']['tmp_name']);
    $image2 = new Image($_FILES['imagen']['tmp_name']);

    
    


    # Set the background to white:
    $image->setBackgroundColor('#212121');

    # Contain the image:
    $image->contain(300);

    $image->output("../img/Proyectos");
    $image2->output("../img/Proyectos2"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

    # Renombrar la imagen genereda por el metodo output

    rename($image->getOutputFilename(), '../img/Proyectos/'.$name);
    rename($image2->getOutputFilename(), '../img/Proyectos2/'.$name2);
    }

    if (empty($errores)==true) {
        move_uploaded_file($image, "../img/Proyectos/".$name);
        move_uploaded_file($image2, "../img/Proyectos2/".$name2);
        return $name;
    }
    else{

        print_r($errores);

    }


}


if(isset($_POST['insert']) && !empty ($_POST['insert'])){
//Insert un nuevo producto
$imagen=imagen();

$nombre_proyecto=$_POST['nombre_proyecto'];
$idred=$_POST['nombre_red'];
$idestado=$_POST['estado'];
$moneda_proyecto=$_POST['moneda_proyecto'];
$precio_proyecto=$_POST['precio_proyecto'];
$imagen_proyecto=$_POST['imagen_proyecto'];
$tipo_proyecto=$_POST['tipo_proyecto'];
$estado_proyecto=$_POST['estado_proyecto'];
$descripcion_proyecto=$_POST['descripcion_proyecto'];
$pagina_proyecto=$_POST['pagina_proyecto'];
$whitepaper_proyecto=$_POST['whitepaper_proyecto'];
$descripcion2_proyecto=$_POST['descripcion2_proyecto'];

$insert=mysqli_query($conexion,"INSERT INTO proyectos (nombre_proyecto, moneda_proyecto, precio_proyecto, imagen_proyecto, idred, idestado, tipo_proyecto, estado_proyecto, descripcion_proyecto, pagina_proyecto, whitepaper_proyecto, descripcion2_proyecto) values ('$nombre_proyecto','$moneda_proyecto','$precio_proyecto','$imagen','$idred','$idestado','$tipo_proyecto','$estado_proyecto','$descripcion_proyecto','$pagina_proyecto','$whitepaper_proyecto','$descripcion2_proyecto')");

//echo 'nombre: '. $nombre_proyecto; echo 'nombre: '. $moneda_proyecto; echo 'nombre: '. $precio_proyecto; echo 'nombre: '. $imagen; echo 'nombre: '. $idred; echo 'nombre: '. $estado; echo 'nombre: '. $tipo_proyecto;  echo 'nombre: '. $estado_proyecto; echo 'nombre: '. $descripcion_proyecto; echo 'nombre: '. $pagina_proyecto; echo 'nombre: '. $whitepaper_proyecto;  echo 'nombre: '. $descripcion2_proyecto; 
header("location:proyectoslist.php");

}

if(isset($_POST['update']) && !empty ($_POST['update'])){

    $imagen=imagen();
    $idred=$_POST['idred'];
    $id_proyecto=$_POST['idproyecto'];
    $moneda_proyecto=$_POST['moneda_proyecto'];
    $precio_proyecto=$_POST['precio_proyecto'];
    $imagen_proyecto=$_POST['imagen_proyecto'];
    $idestado=$_POST['estado'];
    $tipo_proyecto=$_POST['tipo_proyecto'];
    $estado_proyecto=$_POST['estado_proyecto'];
    $descripcion_proyecto=$_POST['descripcion_proyecto'];
    $pagina_proyecto=$_POST['pagina_proyecto'];
    $whitepaper_proyecto=$_POST['whitepaper_proyecto'];
    $descripcion2_proyecto=$_POST['descripcion2_proyecto'];
   
    $nombre_proyecto=$_POST['nombre_proyecto'];
    if (!is_null($imagen)) {
        $update=mysqli_query($conexion,"UPDATE proyectos SET nombre_proyecto='$nombre_proyecto', moneda_proyecto='$moneda_proyecto', precio_proyecto='$precio_proyecto', imagen_proyecto='$imagen', idred='$idred', idestado='$idestado',tipo_proyecto ='$tipo_proyecto',estado_proyecto ='$estado_proyecto',descripcion_proyecto ='$descripcion_proyecto',pagina_proyecto ='$pagina_proyecto',whitepaper_proyecto ='$whitepaper_proyecto',descripcion2_proyecto ='$descripcion2_proyecto' WHERE idproyecto='$id_proyecto'");

        header("location:proyectoslist.php");
    }else{
        $update=mysqli_query($conexion,"UPDATE proyectos SET nombre_proyecto='$nombre_proyecto', moneda_proyecto='$moneda_proyecto', precio_proyecto='$precio_proyecto', idred='$idred', idestado='$idestado',tipo_proyecto ='$tipo_proyecto',estado_proyecto ='$estado_proyecto',descripcion_proyecto ='$descripcion_proyecto',pagina_proyecto ='$pagina_proyecto',whitepaper_proyecto ='$whitepaper_proyecto',descripcion2_proyecto ='$descripcion2_proyecto' WHERE idproyecto='$id_proyecto'");

        header("location:proyectoslist.php");
    }
}