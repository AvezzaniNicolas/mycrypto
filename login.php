<?php

require ("conexion.php");

session_start();



if (isset($_POST['ingresar']) && !empty ($_POST['ingresar']) ){

    $mail = $_POST['mail'];
    $contrasenia = sha1($_POST['contrasenia']);

    $consulta = mysqli_query ($conexion, "SELECT * FROM usuarios WHERE email = '$mail' AND contrasenia = '$contrasenia' LIMIT 1");

    

    if ($respuesta=mysqli_fetch_assoc($consulta)){

        

        if ($respuesta['email']==$mail && $respuesta['contrasenia']==$contrasenia){
            
            $selectrol=mysqli_query($conexion,"SELECT idrol FROM rol_usuarios WHERE idusuario='{$respuesta['idusuario']}'");              
               while($r=mysqli_fetch_array($selectrol)){                  
                   $idrol=$r['idrol'];              

                }
            $_SESSION['rol'] = $idrol;
            $_SESSION['logueado'] = $respuesta['idusuario'];
                 
            header ("location: inicio.php");



        }
        }else{

            
            header("location:index.php");
    }

    

        
    
}



?>