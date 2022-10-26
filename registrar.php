<?php

require ("conexion.php");

if (isset($_POST['registrar']) && !empty ($_POST['registrar']) ){

    $mail = $_POST['mail'];
    $contrasenia =sha1($_POST['contrasenia']);
    $nickname = $_POST['nick'];

    $verificarMail=mysqli_query($conexion,"SELECT email FROM usuarios WHERE email='$mail' LIMIT 1");
    
    if(mysqli_num_rows($verificarMail)>0){    
        
    header("location:singup.php?error=3"); 

    }else{


    

    $consulta = mysqli_query ($conexion, "INSERT INTO usuarios (idusuario, nickname, email, contrasenia, idestado) VALUES (00,'$nickname','$mail', '$contrasenia', 1)");

    $idusuario = mysqli_insert_id($conexion);

    $insert_rol_usuarios = mysqli_query ($conexion, "INSERT INTO rol_usuarios (idrol, idusuario) VALUES (2, $idusuario)");
    //$insert_inventario =mysqli_query ($conexion, "INSERT INTO inventarios (idinventario, idusuario, moneda) VALUES (00, $idusuario, 0)");

        header ("location: index.php");
        
    }
}

?>