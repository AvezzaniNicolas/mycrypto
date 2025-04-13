<?php
session_start();
include("../conexion.php");

// Verificar sesión
//if (!isset($_SESSION['usuario'])) {
   // header("Location: login.php");
  //  exit();
//}

// Función para sanitizar datos
function sanitizeInput($conexion, $data) {
    return mysqli_real_escape_string($conexion, trim($data));
}

// Función para manejar la subida de imágenes
function handleImageUpload($fileInput, $targetDir) {
    // Verificar si se subió un archivo
    if (!isset($fileInput['name']) || empty($fileInput['name'])) {
        return ['success' => false, 'error' => 'No se seleccionó ninguna imagen'];
    }

    // Verificar errores de subida
    if ($fileInput['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Error al subir el archivo: ' . $fileInput['error']];
    }

    // Verificar si es una imagen válida
    $check = getimagesize($fileInput['tmp_name']);
    if ($check === false) {
        return ['success' => false, 'error' => 'El archivo no es una imagen válida'];
    }

    // Verificar tamaño (2MB máximo)
    if ($fileInput['size'] > 2000000) {
        return ['success' => false, 'error' => 'El archivo es demasiado grande. Máximo 2MB permitidos'];
    }

    // Permitir ciertos formatos
    $imageFileType = strtolower(pathinfo($fileInput['name'], PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        return ['success' => false, 'error' => 'Solo se permiten archivos JPG, JPEG, PNG & GIF'];
    }

    // Generar nombre único para el archivo
    $newFilename = uniqid() . '.' . $imageFileType;
    $targetFile = $targetDir . $newFilename;

    // Mover el archivo subido
    if (move_uploaded_file($fileInput['tmp_name'], $targetFile)) {
        return ['success' => true, 'filename' => $newFilename];
    } else {
        return ['success' => false, 'error' => 'Hubo un error al mover el archivo subido'];
    }
}

// Procesar inserción de nuevo proyecto
if (isset($_POST['insert'])) {
    $targetDir = "../img/proyectos/";
    
    // Manejar la subida de la imagen
    $imageUpload = handleImageUpload($_FILES['imagen'], $targetDir);
    if (!$imageUpload['success']) {
        die($imageUpload['error']);
    }

    // Sanitizar todos los inputs
    $nombre_proyecto = sanitizeInput($conexion, $_POST['nombre_proyecto']);
    $moneda_proyecto = sanitizeInput($conexion, $_POST['moneda_proyecto']);
    $precio_proyecto = sanitizeInput($conexion, $_POST['precio_proyecto']);
    $nombre_red = sanitizeInput($conexion, $_POST['nombre_red']);
    $estado = sanitizeInput($conexion, $_POST['estado']);
    $tipo_proyecto = sanitizeInput($conexion, $_POST['tipo_proyecto']);
    $estado_proyecto = sanitizeInput($conexion, $_POST['estado_proyecto']);
    $descripcion_proyecto = sanitizeInput($conexion, $_POST['descripcion_proyecto']);
    $pagina_proyecto = sanitizeInput($conexion, $_POST['pagina_proyecto']);
    $whitepaper_proyecto = sanitizeInput($conexion, $_POST['whitepaper_proyecto']);
    $descripcion2_proyecto = sanitizeInput($conexion, $_POST['descripcion2_proyecto']);

    // Insertar en la base de datos
    $sql = "INSERT INTO proyectos (
            nombre_proyecto, moneda_proyecto, precio_proyecto, idred, idestado, 
            tipo_proyecto, estado_proyecto, descripcion_proyecto, pagina_proyecto, 
            whitepaper_proyecto, descripcion2_proyecto, imagen_proyecto
            ) VALUES (
            '$nombre_proyecto', '$moneda_proyecto', '$precio_proyecto', '$nombre_red', '$estado',
            '$tipo_proyecto', '$estado_proyecto', '$descripcion_proyecto', '$pagina_proyecto',
            '$whitepaper_proyecto', '$descripcion2_proyecto', '{$imageUpload['filename']}'
            )";

    if (mysqli_query($conexion, $sql)) {
        header("Location: proyectoslist.php?success=1");
        exit();
    } else {
        // Eliminar la imagen subida si falla la inserción
        unlink($targetDir . $imageUpload['filename']);
        die("Error al guardar: " . mysqli_error($conexion));
    }
}

// Procesar actualización de proyecto
if (isset($_POST['update'])) {
    $targetDir = "../img/proyectos/";
    $idproyecto = sanitizeInput($conexion, $_POST['idproyecto']);
    
    // Inicializar variables para la actualización
    $image_update = '';
    $newFilename = '';
    
    // Manejar la subida de nueva imagen si existe
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imageUpload = handleImageUpload($_FILES['imagen'], $targetDir);
        if (!$imageUpload['success']) {
            die($imageUpload['error']);
        }
        
        $newFilename = $imageUpload['filename'];
        $image_update = ", imagen_proyecto = '{$imageUpload['filename']}'";
        
        // Obtener y eliminar la imagen anterior
        $sql_old = "SELECT imagen_proyecto FROM proyectos WHERE idproyecto = '$idproyecto'";
        $result = mysqli_query($conexion, $sql_old);
        
        if ($result && $row = mysqli_fetch_assoc($result)) {
            if (!empty($row['imagen_proyecto']) && file_exists($targetDir . $row['imagen_proyecto'])) {
                unlink($targetDir . $row['imagen_proyecto']);
            }
        }
    }

    // Sanitizar todos los inputs
    $nombre_proyecto = sanitizeInput($conexion, $_POST['nombre_proyecto']);
    $moneda_proyecto = sanitizeInput($conexion, $_POST['moneda_proyecto']);
    $precio_proyecto = sanitizeInput($conexion, $_POST['precio_proyecto']);
    $nombre_red = sanitizeInput($conexion, $_POST['idred']);
    $estado = sanitizeInput($conexion, $_POST['estado']);
    $tipo_proyecto = sanitizeInput($conexion, $_POST['tipo_proyecto']);
    $estado_proyecto = sanitizeInput($conexion, $_POST['estado_proyecto']);
    $descripcion_proyecto = sanitizeInput($conexion, $_POST['descripcion_proyecto']);
    $pagina_proyecto = sanitizeInput($conexion, $_POST['pagina_proyecto']);
    $whitepaper_proyecto = sanitizeInput($conexion, $_POST['whitepaper_proyecto']);
    $descripcion2_proyecto = sanitizeInput($conexion, $_POST['descripcion2_proyecto']);

    // Actualizar en la base de datos
    $sql = "UPDATE proyectos SET 
            nombre_proyecto = '$nombre_proyecto', 
            moneda_proyecto = '$moneda_proyecto', 
            precio_proyecto = '$precio_proyecto', 
            idred = '$nombre_red', 
            idestado = '$estado',
            tipo_proyecto = '$tipo_proyecto', 
            estado_proyecto = '$estado_proyecto', 
            descripcion_proyecto = '$descripcion_proyecto', 
            pagina_proyecto = '$pagina_proyecto',
            whitepaper_proyecto = '$whitepaper_proyecto', 
            descripcion2_proyecto = '$descripcion2_proyecto'
            $image_update
            WHERE idproyecto = '$idproyecto'";

    if (mysqli_query($conexion, $sql)) {
        header("Location: proyectoslist.php?success=1");
        exit();
    } else {
        // Eliminar la nueva imagen si falla la actualización
        if (!empty($newFilename) && file_exists($targetDir . $newFilename)) {
            unlink($targetDir . $newFilename);
        }
        die("Error al actualizar: " . mysqli_error($conexion));
    }
}

// Cerrar conexión
mysqli_close($conexion);
?>