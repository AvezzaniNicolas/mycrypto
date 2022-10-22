<?php


$title="Modificar Red";
/* Llamar la Cadena de Conexion*/ 
require "../conexion.php";
require "../vendor/autoload.php";
use BenMajor\ImageResize\Image;

function imagen(){
    require "../conexion.php";

    if (isset($_POST['update'])) {
        $idred=$_POST['id'];
        $consulta= "SELECT imagen_red from redes where idred='$idred'";
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

                $image->output("../img/Redes");
                $image2->output("../img/Redes2"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

                # Renombrar la imagen genereda por el metodo output

                rename($image->getOutputFilename(), "../img/Redes/".$name);
                rename($image2->getOutputFilename(), "../img/Redes2/".$name2);
                }

                if (empty($errores)==true) {
                    move_uploaded_file($image, "../img/Redes/".$name);
                    move_uploaded_file($image2, "../img/Redes2/".$name2);
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

    $image->output("../img/Redes");
    $image2->output("../img/Redes2"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

    # Renombrar la imagen genereda por el metodo output

    rename($image->getOutputFilename(), '../img/Redes/'.$name);
    rename($image2->getOutputFilename(), '../img/Redes2/'.$name2);
    }

    if (empty($errores)==true) {
        move_uploaded_file($image, "../img/Redes/".$name);
        move_uploaded_file($image2, "../img/Redes2/".$name2);
        return $name;
    }
    else{

        print_r($errores);

    }


}


if(isset($_POST['insert']) && !empty ($_POST['insert'])){
//Insert un nuevo producto
$imagen=imagen();

$orden=$_POST['orden'];
$idestado=$_POST['estado'];
$nombre_red=$_POST['nombre_red'];
$insert=mysqli_query($conexion,"INSERT INTO redes (nombre_red,imagen_red, idestado,orden) values ('$nombre_red','$imagen','$idestado','$orden')");


header("location:redeslist.php");

}

if(isset($_POST['update']) && !empty ($_POST['update'])){

    $imagen=imagen();
    $idred=$_POST['idred'];
    $orden=$_POST['orden'];
    $idestado=$_POST['estado'];
    $nombre_red=$_POST['nombre_red'];
    if (!is_null($imagen)) {
        $update=mysqli_query($conexion,"UPDATE redes SET nombre_red='$nombre_red', imagen_red='$imagen', idestado='$idestado', orden='$orden' WHERE idred='$idred'");

        header("location:redeslist.php");
    }else{
        $update=mysqli_query($conexion,"UPDATE redes SET nombre_red='$nombre_red',  idestado='$idestado', orden='$orden' WHERE idred='$idred'");

        header("location:redeslist.php");
    }
}








?>