<?php

require ("conexion.php");

session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');


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
            // Asignar monedas al usuario que inició sesión
            $usuarioID = $respuesta['idusuario'];

            // Obtener la cantidad de monedas actual del usuario y la última fecha de asignación desde la base de datos
            $sql = "SELECT moneda, ultima_asignacion FROM inventarios WHERE idusuario = '$usuarioID'";
            $result = mysqli_query($conexion, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $cantidadMonedas = $row['moneda'];
                $ultimaAsignacion = $row['ultima_asignacion'];
            } else {
                // Si el usuario no tiene un registro en la tabla de inventarios, asignar un valor predeterminado
                $cantidadMonedas = 0;
                $ultimaAsignacion = null;
            }

            // Obtener la fecha actual
            $fechaActual = date('Y-m-d');

            // Verificar si la última asignación es distinta a la fecha actual
            if ($ultimaAsignacion != $fechaActual) {
                $cantidadMonedas += 100;

                // Actualizar la cantidad de monedas y la última fecha de asignación en la base de datos
                $updateSQL = "UPDATE inventarios SET moneda = '$cantidadMonedas', ultima_asignacion = '$fechaActual' WHERE idusuario = '$usuarioID'";
                if (mysqli_query($conexion, $updateSQL)) {
                    echo "Se agregaron 100 monedas al usuario con ID $usuarioID<br>";
                } else {
                    echo "Error al actualizar las monedas del usuario con ID $usuarioID: " . mysqli_error($conexion);
                }
            } else {
                echo "Ya se han asignado monedas hoy<br>";
            }


            $_SESSION['rol'] = $idrol;
            $_SESSION['logueado'] = $respuesta['idusuario'];       
            header ("location: inicio.php");
        }
    }else{
         header("location:index.php?error=1");
    }
}
?>