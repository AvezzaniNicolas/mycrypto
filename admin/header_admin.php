<?php

include("../conexion.php");
$active_config = "active";
$active_banner = "active";

$idusuario = $_SESSION['logueado'];
$consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario = $idusuario");

while($respuesta = mysqli_fetch_assoc($consulta)) {
    $nick = $respuesta['nickname'];
    $email = $respuesta['email'];
    $nombre = $respuesta['nombre'];
    $apellido = $respuesta['apellido'];
    $foto = $respuesta['foto'] ?? 'default.jpg';
    $rol = $_SESSION['rol'];
}
?>


<link href="css/perfil.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> 
<link href="css/proyectlist.css" rel="stylesheet"> 
<link href="css/dark-mode.css" rel="stylesheet">

<div class="navbar">
    <a href="../inicio.php" class="active">Inicio</a>
    <a href="redeslist.php">REDES</a>
    <a href="proyectoslist.php">PROYECTOS</a>
    <a href="../tienda.php">TIENDA</a>
    <a href="https://es.cointelegraph.com/tags/games">NOTICIAS</a>
    <a href="../perfil.php">PERFIL</a>
    
    <div class="user-info">
        <span>Bienvenido, <?php echo $nick; ?></span>
        <span>(ID ROL:<?php echo $rol; ?>)</span>
        <a href="../logout.php" style="color:rgb(0, 0, 0);">Cerrar Sesión</a>

        <label class="toggle-switch">
                <input type="checkbox" id="dark-mode-toggle">
                <span class="slider"></span>
                </label>
                <span>Luces</span>
    </div>
</div>