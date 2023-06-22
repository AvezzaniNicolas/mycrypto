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
                // Asignar monedas al usuario que inició sesión
            $idusuario = $respuesta['idusuario'];

            // Obtener la cantidad de monedas actual del usuario desde la base de datos
            $sql = "SELECT moneda FROM inventarios WHERE idusuario = '$idusuario'";
            $result = mysqli_query($conexion, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $cantidadMonedas = $row['moneda'];
            } else {
                // Si el usuario no tiene un registro en la tabla de inventarios, asignar un valor predeterminado
                $cantidadMonedas = 0;
            }

            // Verificar si la cantidad de monedas es 0 y agregar 100 monedas al usuario
            if ($cantidadMonedas == 0) {
                $cantidadMonedas += 100;

                // Actualizar la cantidad de monedas en la base de datos
                $updateSQL = "UPDATE inventarios SET moneda = '$cantidadMonedas' WHERE idusuario = '$idusuario'";
                if (mysqli_query($conexion, $updateSQL)) {
                    echo "Se agregaron $cantidadMonedas monedas al usuario con ID $idusuario<br>";
                } else {
                    echo "Error al actualizar las monedas del usuario con ID $idusuario: " . mysqli_error($conexion);
                }
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