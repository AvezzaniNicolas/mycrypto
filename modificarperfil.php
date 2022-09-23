<?php
require ('conexion.php');
session_start();

if(isset($_POST['Guardar']) && !empty($_POST['Guardar'])){

$nick = $_POST['nick'];
$email = $_POST['email'];
$idusuario = $_SESSION['logueado'];
$descripcion = $_POST['descripcion']; 
$twitter = $_POST['twitter'];
$instagram = $_POST['instagram'];
$facebook = $_POST['facebook'];

$consulta = mysqli_query($conexion, "UPDATE usuarios SET nickname='$nick', email='$email', descripcion='$descripcion', twitter='$twitter', instagram='$instagram', facebook='$facebook' WHERE idusuario=$idusuario");

    header('location: perfil.php');
    
}

?>