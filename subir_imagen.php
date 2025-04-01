<?php
session_start();
require ("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen_perfil'])) {
    $usuarioId = $_SESSION['logueado'];
    $archivo = $_FILES['imagen_perfil'];
    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $nombreTemp = $archivo['tmp_name'];
        $nombreOriginal = basename($archivo['name']);
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
        $extensionesValidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($extension, $extensionesValidas)) {
            echo "Formato de imagen no permitido.";
            exit;
        }
        $nombreFinal = uniqid("img_") . "." . $extension;
        $rutaDestino = "img/logos/" . $nombreFinal;
        if (move_uploaded_file($nombreTemp, $rutaDestino)) {            
            $sql = "UPDATE usuarios SET imagen = '".$nombreFinal."' WHERE idusuario = ".$usuarioId;
            $result = mysqli_query($conexion, $sql);
            header("Location: perfil.php?imagen_subida=ok");
            exit;
        } else {
            echo "Error al mover el archivo.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
} else {
    echo "Acceso no permitido.";
}