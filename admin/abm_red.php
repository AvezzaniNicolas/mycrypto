<?php
session_start();
include("../conexion.php");

if(isset($_POST['insert'])) {
    // Configuración para subir imágenes
    $target_dir = "../img/redes/";
    if(!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Validar y procesar la imagen
    $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid().'.'.$imageFileType;
    $target_file = $target_dir.$new_filename;
    
    // Verificar si es una imagen real
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if($check === false) {
        die("El archivo no es una imagen válida.");
    }

    // Verificar tamaño del archivo (2MB máximo)
    if ($_FILES["imagen"]["size"] > 2000000) {
        die("El archivo es demasiado grande. Máximo 2MB permitidos.");
    }

    // Permitir ciertos formatos
    $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
    if(!in_array($imageFileType, $allowed_types)) {
        die("Solo se permiten archivos JPG, JPEG, PNG & GIF.");
    }

    // Mover el archivo subido
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        // Recoger y sanitizar datos del formulario
        $nombre_red = mysqli_real_escape_string($conexion, $_POST['nombre_red']);
        $orden = intval($_POST['orden']);
        $estado = intval($_POST['estado']);
        
        // Insertar en la base de datos
        $sql = "INSERT INTO redes (nombre_red, orden, idestado, imagen_red) 
                VALUES ('$nombre_red', $orden, $estado, '$new_filename')";
        
        if(mysqli_query($conexion, $sql)) {
            header("Location: redeslist.php?success=1");
            exit();
        } else {
            // Eliminar la imagen si falla la inserción
            if(file_exists($target_file)) {
                unlink($target_file);
            }
            die("Error al guardar: ".mysqli_error($conexion));
        }
    } else {
        die("Hubo un error al subir la imagen. Verifica los permisos del directorio.");
    }
}
?>