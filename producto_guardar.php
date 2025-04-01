<?php

require ("conexion.php");
session_start();

// Obtener datos del formulario
$idproducto = isset($_POST['idproducto']) ? intval($_POST['idproducto']) : 0;
$nombre = $_POST['nombre_producto'];
$precio = floatval($_POST['precio']);
$idestado = intval($_POST['idestado']);
$idcategoria = intval($_POST['idcategoria']);

// Procesar imagen si se subió una nueva
$nombreImagen = '';

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['imagen']['tmp_name'];
    $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
    $nombreImagen = uniqid("prod_") . "." . $ext;
    if($idcategoria == 2){
        $destino = "img/marcos/" . $nombreImagen;
        $nombreImagen = "marcos/".$nombreImagen;
    }else{
        $destino = "img/banners/" . $nombreImagen;
        $nombreImagen = "banners/".$nombreImagen;
    }
    move_uploaded_file($tmpName, $destino);
}

// INSERT o UPDATE
if ($idproducto > 0) {
    // UPDATE
    if ($nombreImagen != '') {
        // Si se subió una nueva imagen, actualizarla también
        $sql = "UPDATE productos SET nombre_producto=?, imagen=?, precio=?, idestado=?, idcategoria=? WHERE idproducto=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssddii", $nombre, $nombreImagen, $precio, $idestado, $idcategoria, $idproducto);
    } else {
        // No se subió nueva imagen, mantener la anterior
        $sql = "UPDATE productos SET nombre_producto=?, precio=?, idestado=?, idcategoria=? WHERE idproducto=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sddii", $nombre, $precio, $idestado, $idcategoria, $idproducto);
    }
    $stmt->execute();
    $stmt->close();
} else {
    // INSERT
    $sql = "INSERT INTO productos (nombre_producto, imagen, precio, idestado, idcategoria) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdii", $nombre, $nombreImagen, $precio, $idestado, $idcategoria);
    $stmt->execute();
    $stmt->close();
}

$conexion->close();

// Redirigir a la lista de productos
header("Location: productos.php");
exit;
