<?php

require ("conexion.php");
session_start();

// Obtener datos del formulario
$idproducto = isset($_POST['idproducto']) ? intval($_POST['idproducto']) : 0;
$nombre = $_POST['nombre_producto'];
$precio = floatval($_POST['precio']);
$idestado = intval($_POST['idestado']);
$idcategoria = intval($_POST['idcategoria']);
$descripcion = $_POST['descripcion'];
$destacado = intval($_POST['destacado']);

// Procesar imagen si se subió una nueva
$nombreImagen = '';

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['imagen']['tmp_name'];
    $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
    $nombreImagen = uniqid("prod_") . "." . $ext;
    if($idcategoria == 2){
        $destino = "img/marcos/" . $nombreImagen;
        $nombreImagen = "marcos/".$nombreImagen;
    }else if($idcategoria == 3){
        $destino = "img/banners/" . $nombreImagen;
        $nombreImagen = "banners/".$nombreImagen;
    }else{
        $destino = "img/logos/" . $nombreImagen;
        $nombreImagen = "logos/".$nombreImagen;
    }
    move_uploaded_file($tmpName, $destino);
}

// INSERT o UPDATE
if ($idproducto > 0) {
    // UPDATE
    if ($nombreImagen != '') {
        // Si se subió una nueva imagen, actualizarla también
        $sql = "UPDATE productos SET nombre_producto=?, imagen=?, precio=?, idestado=?, idcategoria=?, descripcion=?, destacado=? WHERE idproducto=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssddisii", $nombre, $nombreImagen, $precio, $idestado, $idcategoria,$descripcion, $destacado,  $idproducto );
    } else {
        // No se subió nueva imagen, mantener la anterior
        $sql = "UPDATE productos SET nombre_producto=?, precio=?, idestado=?, idcategoria=?, descripcion=?, destacado=? WHERE idproducto=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sddisii", $nombre, $precio, $idestado, $idcategoria,$descripcion, $destacado, $idproducto);
    }
    $stmt->execute();
    $stmt->close();
} else {
    // INSERT
    $sql = "INSERT INTO productos (nombre_producto, imagen, precio, idestado, idcategoria, destacado , descripcion) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdiiis", $nombre, $nombreImagen, $precio, $idestado, $idcategoria, $destacado, $descripcion);
    $stmt->execute();
    $stmt->close();
}

$conexion->close();

// Redirigir a la lista de productos
header("Location: productos.php");
exit;
