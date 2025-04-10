<?php
session_start();
require 'conexion.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: perfil.php");
    exit;
}

$userId = intval($_GET['id']);
$userQuery = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario = $userId");
$user = mysqli_fetch_assoc($userQuery);

if (!$user) {
    header("Location: perfil.php");
    exit;
}

// Obtener redes sociales del usuario
$redes_sociales = [];
$query_redes = mysqli_query($conexion, "SELECT * FROM usuario_redes WHERE idusuario = $userId");
while ($red = mysqli_fetch_assoc($query_redes)) {
    $redes_sociales[] = $red;
}

// Obtener favoritos del usuario
$favoritos = [];
$query_favoritos = mysqli_query($conexion, "SELECT * FROM usuario_favoritos WHERE idusuario = $userId");
while ($fav = mysqli_fetch_assoc($query_favoritos)) {
    $favoritos[] = $fav;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de <?php echo $user['nombre']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="admin/css/perfil.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="admin/css/EstilosAdicionalesABM.css" rel="stylesheet">
</head>
<body>

<?php include("header_usuario.php"); ?>

<?php 
    if(isset($_SESSION['logueado']) && $_SESSION['logueado'] > 0) {
        $idrol = $_SESSION['rol'];
        $permiso = mysqli_query($conexion, "SELECT p.descripcion, pr.idpermiso FROM permisos AS p, permiso_roles AS pr WHERE p.idpermiso = pr.idpermiso AND pr.idrol = $idrol;");

        while($r = mysqli_fetch_array($permiso)) {
            $nombre_permiso = $r['descripcion'];
            
            switch($nombre_permiso) {
                case 'alta proyecto': ?>
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <a href='add_proyecto.php' class="btn btn-default">
                                <span class="glyphicon glyphicon-plus"></span> Modificar Perfil del usuario
                            </a>
                        </div>
                    </div>
                    <?php 
                    break;
            }
        }
    }
    ?>

<div class="container">
    <div class="profile-section">
        <h2>Perfil de Usuario</h2>
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <img src="uploads/perfiles/<?php echo $user['foto']; ?>" alt="Foto de perfil" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
            <div>
                <h3><?php echo $user['nombre'] . ' ' . $user['apellido']; ?></h3>
                <p>Usuario: <?php echo $user['nickname']; ?></p>
            </div>
        </div>
    </div>
    
    <!-- Sección de redes sociales -->
    <div class="profile-section">
        <h2>Redes Sociales</h2>
        <ul class="social-media-list">
            <?php if (empty($redes_sociales)): ?>
                <li>Este usuario no ha agregado redes sociales.</li>
            <?php else: ?>
                <?php 
                $iconos_redes = [
                    'Facebook' => 'facebook',
                    'Twitter' => 'twitter',
                    'Instagram' => 'instagram',
                    'LinkedIn' => 'linkedin',
                    'YouTube' => 'youtube',
                    'TikTok' => 'tiktok',
                    'GitHub' => 'github',
                    'Otra' => 'share-alt'
                ];
                
                foreach ($redes_sociales as $red): 
                    $tipo_red = $red['tipo_red'] ?? 'Otra';
                    $clase_icono = $iconos_redes[$tipo_red] ?? 'share-alt';
                ?>
                    <li>
                        <div>
                            <i class="fab fa-<?php echo $clase_icono; ?> social-icon"></i>
                            <?php echo htmlspecialchars($tipo_red); ?>: 
                            <a href="<?php echo htmlspecialchars($red['url_red'] ?? '#'); ?>" target="_blank">
                                <?php echo htmlspecialchars($red['url_red'] ?? 'URL no disponible'); ?>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    
    <!-- Sección de favoritos -->
    <div class="profile-section">
        <h2>Criptomonedas Favoritas</h2>
        <ul class="favorites-list">
            <?php if (empty($favoritos)): ?>
                <li>Este usuario no tiene criptomonedas favoritas.</li>
            <?php else: ?>
                <?php foreach ($favoritos as $fav): ?>
                    <li>
                        <span><?php echo htmlspecialchars($fav['crypto_nombre']); ?></span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
</div>




<script src="js/perfil/main.js"></script>
<script src="js/perfil/darkModeModule.js"></script>

</body>



</html>