<?php


$title="Modificar Tienda";
/* Llamar la Cadena de Conexion*/ 
require "../conexion.php";
require "../vendor/autoload.php";
use BenMajor\ImageResize\Image;

function imagen(){
    require "../conexion.php";

    if (isset($_POST['update'])) {
        $idtienda=$_POST['id'];
        $consulta= "SELECT imagen_tienda from tienda where idtienda='$idtienda'";
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

                $image->output("../img/tienda");
                $image2->output("../img/tienda2"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

                # Renombrar la imagen genereda por el metodo output

                rename($image->getOutputFilename(), "../img/tienda/".$name);
                rename($image2->getOutputFilename(), "../img/tienda2/".$name2);
                }

                if (empty($errores)==true) {
                    move_uploaded_file($image, "../img/tienda/".$name);
                    move_uploaded_file($image2, "../img/tienda2/".$name2);
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

    $image->output("../img/tienda");
    $image2->output("../img/tienda2"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

    # Renombrar la imagen genereda por el metodo output

    rename($image->getOutputFilename(), '../img/tienda/'.$name);
    rename($image2->getOutputFilename(), '../img/tienda2/'.$name2);
    }

    if (empty($errores)==true) {
        move_uploaded_file($image, "../img/tienda/".$name);
        move_uploaded_file($image2, "../img/tienda2/".$name2);
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
$nombre_red=$_POST['nombre_tienda'];
$insert=mysqli_query($conexion,"INSERT INTO tienda (nombre_tienda,imagen_tienda, idestado,orden) values ('$nombre_tienda','$imagen','$idestado','$orden')");


header("location:tiendalist.php");

}

if(isset($_POST['update']) && !empty ($_POST['update'])){

    $imagen=imagen();
    $idtienda=$_POST['idtienda'];
    $orden=$_POST['orden'];
    $idestado=$_POST['estado'];
    $nombre_tienda=$_POST['nombre_tienda'];
    if (!is_null($imagen)) {
        $update=mysqli_query($conexion,"UPDATE tienda SET nombre_tienda='$nombre_tienda', imagen_tienda='$imagen', idestado='$idestado', orden='$orden' WHERE idtienda='$idtienda'");

        header("location:tiendalist.php");
    }else{
        $update=mysqli_query($conexion,"UPDATE tienda SET nombre_tienda='$nombre_tienda',  idestado='$idestado', orden='$orden' WHERE idtienda='$idtienda'");

        header("location:tiendalist.php");
    }
}








?>