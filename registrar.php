<?php

require ("conexion.php");

if (isset($_POST['registrar']) && !empty($_POST['registrar'])) {

    $mail = trim($_POST['mail']);
    $contrasenia = trim($_POST['contrasenia']);
    $nickname = trim($_POST['nick']);

    // Validación del formato de email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header("location:singup.php?error=4"); // Error: Formato de email inválido
        exit();
    }

    // Validación de la contraseña
    if (strlen($contrasenia) < 8) {
        header("location:singup.php?error=5"); // Error: Contraseña demasiado corta
        exit();
    }

    if (!preg_match('/[A-Z]/', $contrasenia)) {
        header("location:singup.php?error=6"); // Error: Falta mayúscula en contraseña
        exit();
    }

    if (!preg_match('/[0-9]/', $contrasenia)) {
        header("location:singup.php?error=7"); // Error: Falta número en contraseña
        exit();
    }

    // Verificar si el email ya existe
    $verificarMail = mysqli_query($conexion, "SELECT email FROM usuarios WHERE email='$mail' LIMIT 1");

    if(mysqli_num_rows($verificarMail) > 0) {
        header("location:singup.php?error=3"); // Error: Email ya registrado
        exit();
    }

    // Si pasa todas las validaciones, proceder con el registro
    $contrasenia_hash = sha1($contrasenia);

    $consulta = mysqli_query($conexion, "INSERT INTO usuarios (idusuario, nickname, email, contrasenia, idestado) 
                                        VALUES (00, '$nickname', '$mail', '$contrasenia_hash', 1)");

    $idusuario = mysqli_insert_id($conexion);

    $insert_rol_usuarios = mysqli_query($conexion, "INSERT INTO rol_usuarios (idrol, idusuario) VALUES (2, $idusuario)");

    header("location: index.php");
    exit();
}

?>
NUEVO


Enviar mensaje a @Eigus
