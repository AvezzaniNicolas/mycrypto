<?php


$title="modificar item";
/* Llamar la Cadena de Conexion*/ 
require "../conexion.php";
require "../vendor/autoload.php";
use BenMajor\ImageResize\Image;

function imagen(){
    require "../conexion.php";

    if (isset($_POST['update'])) {
        $iditem=$_POST['iditem'];
        $consulta= "SELECT imagen_item from items where iditem='$iditem'";
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

                $image->output("../img/item");
                $image2->output("../img/item2"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

                # Renombrar la imagen genereda por el metodo output

                rename($image->getOutputFilename(), "../img/item/".$name);
                rename($image2->getOutputFilename(), "../img/item2/".$name2);
                }

                if (empty($errores)==true) {
                    move_uploaded_file($image, "../img/item/".$name);
                    move_uploaded_file($image2, "../img/item2/".$name2);
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

    $image->output("../img/item");
    $image2->output("../img/item2"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

    # Renombrar la imagen genereda por el metodo output

    rename($image->getOutputFilename(), '../img/item/'.$name);
    rename($image2->getOutputFilename(), '../img/item2/'.$name2);
    }

    if (empty($errores)==true) {
        move_uploaded_file($image, "../img/item/".$name);
        move_uploaded_file($image2, "../img/item2/".$name2);
        return $name;
    }
    else{

        print_r($errores);

    }


}


if(isset($_POST['insert']) && !empty ($_POST['insert'])){
//Insert un nuevo producto
$imagen=imagen();

$nombre_item=$_POST['nombre_item'];
$idestado=$_POST['idestado'];
$precio=$_POST['precio'];
$imagen_item=$_POST['imagen_item'];
$idtienda=$_POST['nombre_tienda'];

$insert=mysqli_query($conexion,"INSERT INTO items (nombre_item, precio, imagen_item, idtienda, idestado) values ('$nombre_item','$precio','$imagen','$idtienda','$idestado')");

header("location:itemlist.php");

}

if(isset($_POST['update']) && !empty ($_POST['update'])){

    $imagen=imagen();
    
    $iditem=$_POST['iditem'];
    $nombre_item=$_POST['nombre_item'];
    $idestado=$_POST['idestado'];
    $precio=$_POST['precio'];
    $imagen_item=$_POST['imagen_item'];
    $idtienda=$_POST['idtienda'];
   
 
    if (!is_null($imagen)) {
        $update = mysqli_query($conexion, "UPDATE items SET nombre_item='$nombre_item', idestado='$idestado', precio='$precio', imagen_item='$imagen', idtienda='$idtienda' WHERE iditem='$iditem'");

        header("location:itemlist.php");
    } else {
        $update = mysqli_query($conexion, "UPDATE items SET nombre_item='$nombre_item', idestado='$idestado', precio='$precio', idtienda='$idtienda' WHERE iditem='$iditem'");

        header("location:itemlist.php");
    }
}