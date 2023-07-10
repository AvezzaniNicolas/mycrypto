<?php
// archivo agregar_al_inventario.php

// Verificar si se recibió la solicitud mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la ruta de la imagen enviada desde la solicitud AJAX
    $imagen = $_POST["imagen"];

    // Realizar las operaciones necesarias para agregar la imagen al inventario del usuario
    // Por ejemplo, puedes insertar un nuevo registro en la tabla de inventario con la ruta de la imagen y el ID del usuario

    // Conectar a la base de datos
    require("conexion.php");
    session_start();
    $idusuario = $_SESSION['logueado'];

    // Verificar si el usuario ya tiene la imagen en su inventario
    $consulta = mysqli_query($conexion, "SELECT * FROM inventarios WHERE idusuario=$idusuario AND imagen='$imagen'");
    if (mysqli_num_rows($consulta) > 0) {
        // El usuario ya tiene la imagen en su inventario, puedes mostrar un mensaje o realizar alguna acción apropiada
        echo "La imagen ya está en tu inventario";
    } else {
        // Agregar la imagen al inventario del usuario
        $sql = "INSERT INTO inventarios (idusuario, imagen) VALUES ('$idusuario', '$imagen')";
        if (mysqli_query($conexion, $sql)) {
            // La imagen se agregó al inventario correctamente, puedes mostrar un mensaje o realizar alguna acción apropiada
            echo "Imagen agregada al inventario";
        } else {
            // Ocurrió un error al agregar la imagen al inventario, puedes mostrar un mensaje de error o realizar alguna acción apropiada
            echo "Error al agregar la imagen al inventario: " . mysqli_error($conexion);
        }
    }
} else {
    // Si la solicitud no fue mediante POST, redirigir o mostrar un mensaje de error
    echo "Acceso no válido";
}
?>
