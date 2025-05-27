<?php
session_start();
include("../conexion.php");

if(isset($_POST['insert'])) {
    // Validar que se haya subido una imagen
    if(!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] != UPLOAD_ERR_OK) {
        die("Debes seleccionar una imagen válida.");
    }

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

if(isset($_POST['update'])) {
    // Recoger y validar datos del formulario
    $idred = intval($_POST['idred']);
    $nombre_red = mysqli_real_escape_string($conexion, $_POST['nombre_red']);
    $orden = intval($_POST['orden']);
    $estado = intval($_POST['estado']);
    
    // Verificar que el estado exista en la tabla estados
    $check_estado = mysqli_query($conexion, "SELECT idestado FROM estados WHERE idestado = $estado");
    if(mysqli_num_rows($check_estado) == 0) {
        die("Error: El estado seleccionado no existe.");
    }
    
    // Obtener la imagen actual
    $sql_img = "SELECT imagen_red FROM redes WHERE idred = $idred";
    $result_img = mysqli_query($conexion, $sql_img);
    $row_img = mysqli_fetch_assoc($result_img);
    $imagen_actual = $row_img['imagen_red'];
    
    // Procesar nueva imagen si se subió
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../img/redes/";
        $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid().'.'.$imageFileType;
        $target_file = $target_dir.$new_filename;
        
        // Validaciones de imagen
        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if($check === false) {
            die("El archivo no es una imagen válida.");
        }
        
        if ($_FILES["imagen"]["size"] > 2000000) {
            die("El archivo es demasiado grande. Máximo 2MB permitidos.");
        }
        
        $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
        if(!in_array($imageFileType, $allowed_types)) {
            die("Solo se permiten archivos JPG, JPEG, PNG & GIF.");
        }
        
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            // Eliminar imagen anterior si existe
            if(!empty($imagen_actual) && file_exists($target_dir.$imagen_actual)) {
                unlink($target_dir.$imagen_actual);
            }
            $imagen_actual = $new_filename;
        } else {
            die("Error al subir la imagen. Verifica los permisos del directorio.");
        }
    }
    
    // Actualizar en la base de datos
    $sql = "UPDATE redes SET 
            nombre_red = '$nombre_red', 
            orden = $orden, 
            idestado = $estado, 
            imagen_red = '$imagen_actual' 
            WHERE idred = $idred";

    // Actualizar otros proyectos
    $sql2 = "UPDATE proyectos SET 
            idestado=$estado
            WHERE idred = $idred";
    
    if(mysqli_query($conexion, $sql,)&& mysqli_query($conexion, $sql2)) {
        header("Location: redeslist.php?success=1");
        exit();
    } else {
        // Revertir cambios en la imagen si falla la actualización
        if(isset($new_filename) && file_exists($target_dir.$new_filename)) {
            unlink($target_dir.$new_filename);
        }
        die("Error al actualizar: ".mysqli_error($conexion));
    }
}
?>