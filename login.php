<?php
require("conexion.php");
session_start();

if (isset($_POST['ingresar']) && !empty($_POST['ingresar'])) {
    $mail = $_POST['mail'];
    $contrasenia = sha1($_POST['contrasenia']);

    // Consulta para obtener el usuario
    $consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email = '$mail' LIMIT 1");

    if ($respuesta = mysqli_fetch_assoc($consulta)) {
        // Verificar la contraseña
        if ($respuesta['contrasenia'] == $contrasenia) {
            // Almacenar datos en la sesión
            $_SESSION['logueado'] = $respuesta['idusuario'];

            // Obtener el rol del usuario desde la tabla rol_usuarios
            $idUsuario = $respuesta['idusuario'];
            $consultaRol = mysqli_query($conexion, "SELECT idrol FROM rol_usuarios WHERE idusuario = $idUsuario LIMIT 1");

            if ($rol = mysqli_fetch_assoc($consultaRol)) {
                $_SESSION['rol'] = $rol['idrol']; // Almacenar el rol en la sesión
            } else {
                die("No se pudo obtener el rol del usuario.");
            }

            // Redirigir al usuario
            header("location: inicio.php");
            exit();
        } else {
            // Contraseña incorrecta
            $_SESSION['error'] = "Contraseña incorrecta.";
            header("location: index.php");
            exit();
        }
    } else {
        // Usuario no encontrado
        $_SESSION['error'] = "Usuario no encontrado.";
        header("location: index.php");
        exit();
    }
}
?>
