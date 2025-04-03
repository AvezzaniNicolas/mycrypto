<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI PERFIL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="admin/css/perfil.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilos adicionales para el ABM */
        .profile-section {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .profile-section h2 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .social-media-list {
            list-style: none;
            padding: 0;
        }
        
        .social-media-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .social-media-list li:last-child {
            border-bottom: none;
        }
        
        .social-icon {
            margin-right: 10px;
            color: #555;
        }
        
        .social-actions a {
            margin-left: 10px;
            color: #555;
            text-decoration: none;
        }
        
        .social-actions a:hover {
            color: #0066cc;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .btn {
            background: #0066cc;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn:hover {
            background: #0055aa;
        }
        
        .btn-danger {
            background: #cc0000;
        }
        
        .btn-danger:hover {
            background: #aa0000;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 500px;
        }
        
        .close {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php 
require ('conexion.php');
$idusuario = $_SESSION['logueado'];
$consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario=$idusuario");
while($respuesta = mysqli_fetch_assoc($consulta)) {
    $nick = $respuesta['nickname'];
    $email = $respuesta['email'];
    $nombre = $respuesta['nombre'];
    $apellido = $respuesta['apellido'];
    $foto = $respuesta['foto'] ?? 'default.jpg';
    $rol = $_SESSION['rol'];
}

// Procesar formularios
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Agregar red social
    if (isset($_POST['agregar_red'])) {
        $tipo_red = mysqli_real_escape_string($conexion, $_POST['tipo_red']);
        $url_red = mysqli_real_escape_string($conexion, $_POST['url_red']);
        
        $query = "INSERT INTO usuario_redes (idusuario, tipo_red, url_red) VALUES ($idusuario, '$tipo_red', '$url_red')";
        mysqli_query($conexion, $query);
    }
    
    // Eliminar red social
    if (isset($_POST['eliminar_red'])) {
        $idred = intval($_POST['idred']);
        $query = "DELETE FROM usuario_redes WHERE idred=$idred AND idusuario=$idusuario";
        mysqli_query($conexion, $query);
    }
    
    // Actualizar perfil
    if (isset($_POST['actualizar_perfil'])) {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
        $email = mysqli_real_escape_string($conexion, $_POST['email']);
        
        // Procesar foto de perfil si se subió
        if (!empty($_FILES['foto']['name'])) {
            $target_dir = "uploads/perfiles/";
            $target_file = $target_dir . basename($_FILES["foto"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            // Verificar si es una imagen real
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check !== false) {
                // Mover el archivo subido
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $foto = basename($_FILES["foto"]["name"]);
                }
            }
        }
        
        $query = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', email='$email', foto='$foto' WHERE idusuario=$idusuario";
        mysqli_query($conexion, $query);
        
        // Actualizar variables de sesión si es necesario
        $_SESSION['nombre'] = $nombre;
    }
}

// Obtener redes sociales del usuario
$redes_sociales = [];
$query_redes = mysqli_query($conexion, "SELECT * FROM usuario_redes WHERE idusuario=$idusuario");
if (!$query_redes) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
while ($red = mysqli_fetch_assoc($query_redes)) {
    $redes_sociales[] = $red;
}



?>

<!-- Barra de navegación -->
<div class="navbar">
    <a href="inicio.php" class="active">Inicio</a>
    <a href="#criptomonedas">Criptomonedas</a>
    <a href="#favoritos">Favoritos</a>
    <a href="#comparar">Comparar</a>
    <a href="#perfil">Mi Perfil</a>
    
    <div class="user-info">
        <span>Bienvenido, <?php echo $nick; ?></span>
        <span>(<?php echo $rol; ?>)</span>
        <a href="logout.php" style="color:rgb(0, 0, 0);">Cerrar Sesión</a>
    </div>
</div>

<div class="container">
    <!-- Sección de perfil del usuario -->
    <div class="profile-section">
        <h2>Mi Perfil</h2>
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <img src="uploads/perfiles/<?php echo $foto; ?>" alt="Foto de perfil" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
            <div>
                <h3><?php echo $nombre . ' ' . $apellido; ?></h3>
                <p><?php echo $email; ?></p>
                <p>Usuario: <?php echo $nick; ?></p>
            </div>
        </div>
        
        <button id="editProfileBtn" class="btn">Editar Perfil</button>
    </div>
    
    <!-- Sección de redes sociales -->
    <div class="profile-section">
        <h2>Mis Redes Sociales</h2>



        

        <ul class="social-media-list">
    <?php if (empty($redes_sociales)): ?>
        <li>No has agregado ninguna red social aún.</li>
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
            // Verificación segura del tipo de red
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
                <div class="social-actions">
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="idred" value="<?php echo $red['idred'] ?? ''; ?>">
                        <button type="submit" name="eliminar_red" style="background: none; border: none; color: #cc0000; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>



        
        <button id="addSocialBtn" class="btn">Agregar Red Social</button>
    </div>
    
    <!-- Resto del contenido (criptomonedas) -->
    <header>
        <h1>Explorador de Criptomonedas</h1>
        <p>Consulta tus criptomonedas favoritas</p>
    </header>
    
    <div class="controls">
        <div class="search-box">
            <form method="GET" action="" style="display: flex; width: 100%;">
                <input type="text" name="moneda" id="moneda" placeholder="Ej: bitcoin, ethereum, solana..." required>
                <button type="submit">Buscar</button>
            </form>
        </div>
        
        <div class="toggle-container">
            <button id="favorites-btn" class="favorites-btn">Mis Favoritos</button>
            <button id="compare-btn" class="favorites-btn">Comparar</button>
            <label class="toggle-switch">
                <input type="checkbox" id="dark-mode-toggle">
                <span class="slider"></span>
            </label>
            <span>Modo Oscuro</span>
        </div>
    </div>

    <div class="crypto-grid">
        <?php
        if (isset($_GET['moneda'])) {
            $cripto_id = strtolower($_GET['moneda']);
            obtenerDatosCripto($cripto_id);
        }
        
        function obtenerDatosCripto($cripto_id) {
            $url = "https://api.coingecko.com/api/v3/coins/{$cripto_id}";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($ch);
            curl_close($ch);
            
            $data = json_decode($response, true);
            
            if (isset($data['error'])) {
                echo "<div class='error'>Error: Criptomoneda no encontrada. Intenta con 'bitcoin', 'ethereum', etc.</div>";
            } else {
                mostrarPerfilCripto($data);
            }
        }
        
        function mostrarPerfilCripto($data) {
            $id = $data['id'];
            $nombre = $data['name'];
            $simbolo = strtoupper($data['symbol']);
            $precio = number_format($data['market_data']['current_price']['usd'], 2);
            $market_cap = number_format($data['market_data']['market_cap']['usd'], 2);
            $volumen = number_format($data['market_data']['total_volume']['usd'], 2);
            $imagen = $data['image']['large'];
            $descripcion = $data['description']['es'] ?? $data['description']['en'];
            
            $change_24h = $data['market_data']['price_change_percentage_24h'];
            $change_class = ($change_24h >= 0) ? 'price-up' : 'price-down';
            $change_24h = number_format($change_24h, 2);
            
            echo "
            <div class='crypto-card' data-id='{$id}'>
                <div class='crypto-actions'>
                    <button class='favorite-btn' data-id='{$id}'>&#9733;</button>
                </div>
                
                <div class='crypto-header'>
                    <img src='{$imagen}' alt='{$nombre}' class='crypto-image'>
                    <div class='crypto-title'>
                        <h2>{$nombre}</h2>
                        <p>{$simbolo}</p>
                    </div>
                </div>
                
                <div class='crypto-details'>
                    <div class='detail-box'>
                        <h3>Precio actual</h3>
                        <p>\${$precio} USD</p>
                    </div>
                    
                    <div class='detail-box'>
                        <h3>Cambio (24h)</h3>
                        <p class='{$change_class}'>{$change_24h}%</p>
                    </div>
                    
                    <div class='detail-box'>
                        <h3>Capitalización</h3>
                        <p>\${$market_cap} USD</p>
                    </div>
                    
                    <div class='detail-box'>
                        <h3>Volumen (24h)</h3>
                        <p>\${$volumen} USD</p>
                    </div>
                </div>
                
                <div class='chart-container'>
                    <canvas id='chart-{$id}'></canvas>
                </div>
                
                <div class='crypto-description'>
                    <h3>Acerca de {$nombre}</h3>
                    <p>" . substr(strip_tags($descripcion), 0, 300) . "...</p>
                </div>
            </div>
            ";
        }
        ?>
        
        <div class="comparison-container" id="comparison-container">
            <div class="comparison-header">
                <h2>Comparación</h2>
                <button id="close-comparison">&times;</button>
            </div>
            <div class="comparison-charts">
                <div>
                    <h3 id="coin1-name">Cripto 1</h3>
                    <canvas id="comparison-chart1"></canvas>
                </div>
                <div>
                    <h3 id="coin2-name">Cripto 2</h3>
                    <canvas id="comparison-chart2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar perfil -->
<div id="editProfileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Editar Perfil</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="foto">Foto de perfil</label>
                <input type="file" id="foto" name="foto" accept="image/*">
            </div>
            
            <button type="submit" name="actualizar_perfil" class="btn">Guardar Cambios</button>
        </form>
    </div>
</div>

<!-- Modal para agregar red social -->
<div id="addSocialModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Agregar Red Social</h2>
        <form method="POST">
            <div class="form-group">
                <label for="tipo_red">Red Social</label>
                <select id="tipo_red" name="tipo_red" required>
                    <option value="">Seleccione una red</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Twitter">Twitter</option>
                    <option value="Instagram">Instagram</option>
                    <option value="LinkedIn">LinkedIn</option>
                    <option value="YouTube">YouTube</option>
                    <option value="TikTok">TikTok</option>
                    <option value="GitHub">GitHub</option>
                    <option value="Otra">Otra</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="url_red">URL</label>
                <input type="url" id="url_red" name="url_red" placeholder="https://..." required>
            </div>
            
            <button type="submit" name="agregar_red" class="btn">Agregar Red Social</button>
        </form>
    </div>
</div>

<script>
// JavaScript para manejar los modales
document.addEventListener('DOMContentLoaded', function() {
    // Modal de edición de perfil
    const editProfileModal = document.getElementById('editProfileModal');
    const editProfileBtn = document.getElementById('editProfileBtn');
    const closeEditProfile = editProfileModal.querySelector('.close');
    
    editProfileBtn.onclick = function() {
        editProfileModal.style.display = 'block';
    }
    
    closeEditProfile.onclick = function() {
        editProfileModal.style.display = 'none';
    }
    
    // Modal para agregar red social
    const addSocialModal = document.getElementById('addSocialModal');
    const addSocialBtn = document.getElementById('addSocialBtn');
    const closeAddSocial = addSocialModal.querySelector('.close');
    
    addSocialBtn.onclick = function() {
        addSocialModal.style.display = 'block';
    }
    
    closeAddSocial.onclick = function() {
        addSocialModal.style.display = 'none';
    }
    
    // Cerrar modales haciendo clic fuera de ellos
    window.onclick = function(event) {
        if (event.target == editProfileModal) {
            editProfileModal.style.display = 'none';
        }
        if (event.target == addSocialModal) {
            addSocialModal.style.display = 'none';
        }
    }
});
</script>

<script src="funcionesperfil.js"></script>
</body>

<!-- Footer-->
<footer class="footer py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-lg-start">Copyright &copy; MyCrypto 2022</div>
            <div class="col-lg-4 my-3 my-lg-0">
                <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a class="link-dark text-decoration-none me-3" href="#!">Politica de Privacidad</a>
                <a class="link-dark text-decoration-none" href="#!">Terminos y Condiciones</a>
            </div>
        </div>
    </div>
</footer>

</html>