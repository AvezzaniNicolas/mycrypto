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
$idestado=$_POST['estado_proyecto'];
$moneda_proyecto=$_POST['moneda_proyecto'];
$precio_proyecto=$_POST['precio_proyecto'];
$imagen_proyecto=$_POST['imagen_proyecto'];
//$sqlidred=mysqli_query($conexion,"SELECT idred FROM redes WHERE idred=$idred");
//$sqlidestado=mysqli_query($conexion,"SELECT idestado FROM estados WHERE idestado=$idestado");
$insert=mysqli_query($conexion,"INSERT INTO proyectos (nombre_proyecto, moneda_proyecto, precio_proyecto, imagen_proyecto, idred, idestado) values ('$nombre_proyecto','$moneda_proyecto','$precio_proyecto','$imagen','$idred','$idestado')");


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
    //$sqlidestado=mysqli_query($conexion,"SELECT idestado FROM estados WHERE idestado=$idestado");
    //$sqlidred=mysqli_query($conexion,"SELECT idred FROM redes WHERE idred=$idred");
    $nombre_proyecto=$_POST['nombre_proyecto'];
    if (!is_null($imagen)) {
        $update=mysqli_query($conexion,"UPDATE proyectos SET nombre_proyecto='$nombre_proyecto', moneda_proyecto='$moneda_proyecto', precio_proyecto='$precio_proyecto', imagen_proyecto='$imagen', idred='$idred', idestado='$idestado' WHERE idproyecto='$id_proyecto'");

        header("location:proyectoslist.php");
    }else{
        $update=mysqli_query($conexion,"UPDATE proyectos SET nombre_proyecto='$nombre_proyecto', moneda_proyecto='$moneda_proyecto', precio_proyecto='$precio_proyecto', idred='$idred', idestado='$idestado' WHERE idproyecto='$id_proyecto'");

        header("location:proyectoslist.php");
    }
}