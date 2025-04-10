<?php
session_start();
include("../conexion.php");

if(isset($_POST['insert'])) {
    // Configuración para subir imágenes
    $target_dir = "../img/proyectos/";
    $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;
    $uploadOk = 1;

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
    if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        die("Solo se permiten archivos JPG, JPEG, PNG & GIF.");
    }

    // Mover el archivo subido
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        // Recoger datos del formulario
        $nombre_proyecto = mysqli_real_escape_string($conexion, $_POST['nombre_proyecto']);
        $moneda_proyecto = mysqli_real_escape_string($conexion, $_POST['moneda_proyecto']);
        $precio_proyecto = mysqli_real_escape_string($conexion, $_POST['precio_proyecto']);
        $nombre_red = mysqli_real_escape_string($conexion, $_POST['nombre_red']);
        $estado = mysqli_real_escape_string($conexion, $_POST['estado']);
        $tipo_proyecto = mysqli_real_escape_string($conexion, $_POST['tipo_proyecto']);
        $estado_proyecto = mysqli_real_escape_string($conexion, $_POST['estado_proyecto']);
        $descripcion_proyecto = mysqli_real_escape_string($conexion, $_POST['descripcion_proyecto']);
        $pagina_proyecto = mysqli_real_escape_string($conexion, $_POST['pagina_proyecto']);
        $whitepaper_proyecto = mysqli_real_escape_string($conexion, $_POST['whitepaper_proyecto']);
        $descripcion2_proyecto = mysqli_real_escape_string($conexion, $_POST['descripcion2_proyecto']);
        
        // Insertar en la base de datos (usando imagen_proyecto en lugar de imagen)
        $sql = "INSERT INTO proyectos (
                nombre_proyecto, moneda_proyecto, precio_proyecto, idred, idestado, 
                tipo_proyecto, estado_proyecto, descripcion_proyecto, pagina_proyecto, 
                whitepaper_proyecto, descripcion2_proyecto, imagen_proyecto
                ) VALUES (
                '$nombre_proyecto', '$moneda_proyecto', '$precio_proyecto', '$nombre_red', '$estado',
                '$tipo_proyecto', '$estado_proyecto', '$descripcion_proyecto', '$pagina_proyecto',
                '$whitepaper_proyecto', '$descripcion2_proyecto', '$new_filename'
                )";
        
        if(mysqli_query($conexion, $sql)) {
            header("Location: proyectoslist.php?success=1");
            exit();
        } else {
            die("Error al guardar: " . mysqli_error($conexion));
        }
    } else {
        die("Hubo un error al subir la imagen.");
    }
}
?>