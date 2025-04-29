<?php session_start(); ?>

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
    <link href="admin/css/EstilosAdicionalesABM.css" rel="stylesheet">
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

$sql = "SELECT * FROM inventarios WHERE idusuario = ".$idusuario;
    $result = mysqli_query($conexion, $sql);
    $inventario = mysqli_fetch_assoc($result);
    $logo = '';
    if (!empty($inventario['logo3'])) {
        $logo = $inventario['logo3'];
    } elseif (!empty($inventario['logo2'])) {
        $logo = $inventario['logo2'];
    } elseif (!empty($inventario['logo1'])) {
        $logo = $inventario['logo1'];
    }
    echo "logo:".$logo;    
    $banner = '';
    if (!empty($inventario['banner3'])) {
        $banner = $inventario['banner3'];
    } elseif (!empty($inventario['banner2'])) {
        $banner = $inventario['banner2'];
    } elseif (!empty($inventario['banner1'])) {
        $banner = $inventario['banner1'];
    }
    $estiloFondo = "margin-top: 120px;";
    if (!empty($banner)) {
        $estiloFondo .= " background-image: url('img/$banner'); background-size: cover; background-position: center;";
    }
    $marco = '';
    if (!empty($inventario['imagen3'])) {
        $marco = $inventario['imagen3'];
    } elseif (!empty($inventario['imagen2'])) {
        $marco = $inventario['imagen2'];
    } elseif (!empty($inventario['imagen1'])) {
        $marco = $inventario['imagen1'];
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
    
    // Manejar favoritos (nuevo)
    if (isset($_POST['agregar_favorito'])) {
        $crypto_id = mysqli_real_escape_string($conexion, $_POST['crypto_id']);
        $crypto_nombre = mysqli_real_escape_string($conexion, $_POST['crypto_nombre']);
        
        // Verificar si ya existe
        $check = mysqli_query($conexion, "SELECT * FROM usuario_favoritos WHERE idusuario=$idusuario AND crypto_id='$crypto_id'");
        if (mysqli_num_rows($check) == 0) {
            $query = "INSERT INTO usuario_favoritos (idusuario, crypto_id, crypto_nombre) VALUES ($idusuario, '$crypto_id', '$crypto_nombre')";
            mysqli_query($conexion, $query);
        }
    }
    
    if (isset($_POST['eliminar_favorito'])) {
        $crypto_id = mysqli_real_escape_string($conexion, $_POST['crypto_id']);
        $query = "DELETE FROM usuario_favoritos WHERE idusuario=$idusuario AND crypto_id='$crypto_id'";
        mysqli_query($conexion, $query);
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

// Obtener favoritos del usuario (nuevo)
$favoritos = [];
$query_favoritos = mysqli_query($conexion, "SELECT * FROM usuario_favoritos WHERE idusuario=$idusuario");
if ($query_favoritos) {
    while ($fav = mysqli_fetch_assoc($query_favoritos)) {
        $favoritos[] = $fav;
    }
}

?>

<!-- Barra de navegación -->
<div class="navbar">

    <a href="inicio.php" class="active">Inicio</a>
    <a href="admin/proyectoslist.php">PROYECTOS</a>
    <a href="admin/redeslist.php">REDES</a>
    <a href="tienda.php">TIENDA</a>
    
    <div class="user-info">
        <span>Bienvenido, <?php echo $nick; ?></span>
        <span>(ID ROL:<?php echo $rol; ?>)</span>
        <a href="logout.php" style="color:rgb(0, 0, 0);">Cerrar Sesión</a>
        <label class="toggle-switch">
                <input type="checkbox" id="dark-mode-toggle">
                <span class="slider"></span>
                </label>
                <span>Luces</span>
    </div>
   
</div>

<div class="container" style="<?php echo $estiloFondo; ?>">
    <!-- Sección de perfil del usuario -->
    <div class="profile-section">
        <h2>Mi Perfil</h2>
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
        <div style="width: 160px; height: 160px; 
                  <?php if (!empty($marco)): ?>
                      background-image: url('img/<?php echo $marco; ?>');
                  <?php endif; ?>
                  background-size: cover; background-position: center; 
                  display: flex; align-items: center; justify-content: center;">
                    
                  <img src="<?php 
                    if (isset($logo) && $logo != '') {
                        echo 'img/' . $logo;
                    } else {
                        echo 'https://bootdey.com/img/Content/avatar/avatar6.png';
                    }
                  ?>" alt="Admin" class="rounded-circle" width="100">
                </div>
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
    
    <!-- Nueva sección de favoritos -->

    <div class="profile-section">
        <h2>Mis Criptomonedas Favoritas</h2>
        <ul class="favorites-list">
            <?php if (empty($favoritos)): ?>
                <li>No tienes criptomonedas favoritas aún.</li>
            <?php else: ?>
                <?php foreach ($favoritos as $fav): ?>
                    <li>
                        <span><?php echo htmlspecialchars($fav['crypto_nombre']); ?></span>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="crypto_id" value="<?php echo htmlspecialchars($fav['crypto_id']); ?>">
                            <button type="submit" name="eliminar_favorito" style="background: none; border: none; color: #cc0000; cursor: pointer;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>


    <!-- Buscador de Perfiles -->
<div class="profile-search-section">
    <h2>Buscar otros usuarios</h2>
    <form method="GET" action="" class="search-form">
        <input type="text" name="buscar_usuario" placeholder="Nombre, apellido o nickname..." value="<?php echo $_GET['buscar_usuario'] ?? ''; ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <?php
    if (isset($_GET['buscar_usuario']) && !empty($_GET['buscar_usuario'])) {
        $termino = mysqli_real_escape_string($conexion, $_GET['buscar_usuario']);
        $query = "SELECT idusuario, nombre, apellido, nickname, foto FROM usuarios 
                 WHERE nombre LIKE '%$termino%' 
                 OR apellido LIKE '%$termino%' 
                 OR nickname LIKE '%$termino%'
                 AND idusuario != $idusuario"; // Excluye al usuario actual
        $result = mysqli_query($conexion, $query);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="user-results">';
            while ($user = mysqli_fetch_assoc($result)) {
                echo '<div class="user-card">';
                echo '<img src="uploads/perfiles/'.$user['foto'].'" alt="'.$user['nombre'].'" class="user-avatar">';
                echo '<div class="user-info">';
                echo '<h3>'.$user['nombre'].' '.$user['apellido'].'</h3>';
                echo '<p>@'.$user['nickname'].'</p>';
                echo '<a href="ver_perfil.php?id='.$user['idusuario'].'" class="btn btn-small">Ver Perfil</a>';
                echo '</div></div>';
            }
            echo '</div>';
        } else {
            echo '<p class="no-results">No se encontraron usuarios</p>';
        }
    }
    ?>
</div>


    
    <!-- Resto del contenido (criptomonedas) -->
    <header>
        <h1>MY CRYPTO</h1>
        <p>Consulta tus criptomonedas</p>
    </header>
    
    <div class="controls">
        <div class="search-box">
            <form method="GET" action="" style="display: flex; width: 100%;">
                <input type="text" name="moneda" id="moneda" placeholder="Ej: bitcoin, ethereum, solana..." required>
                <button type="submit">Buscar</button>
            </form>
        </div>
        
        <div class="toggle-container">
            <button id="compare-btn" class="favorites-btn">Comparar</button>
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
            global $conexion, $idusuario, $favoritos;
            
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
            
            // Verificar si es favorito
            $esFavorito = false;
            foreach ($favoritos as $fav) {
                if ($fav['crypto_id'] == $id) {
                    $esFavorito = true;
                    break;
                }
            }
            
            echo "
            <div class='crypto-card' data-id='{$id}'>
                <div class='crypto-actions'>
                    <form method='POST' style='display: inline;'>
                        <input type='hidden' name='crypto_id' value='{$id}'>
                        <input type='hidden' name='crypto_nombre' value='{$nombre}'>
                        ";
            
            if ($esFavorito) {
                echo "<button type='submit' name='eliminar_favorito' class='favorite-btn active'>&#9733;</button>";
            } else {
                echo "<button type='submit' name='agregar_favorito' class='favorite-btn'>&#9733;</button>";
            }
            
            echo "
                    </form>
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
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required autocomplete="given-name">
            </div>
            
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required autocomplete="family-name">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required autocomplete="email">
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

<script src="js/perfil/main.js"></script>
<script src="js/perfil/darkModeModule.js"></script>
<script src="js/perfil/chartModule.js"></script>
<script src="js/perfil/comparisonModule.js"></script>

</body>

<!-- Footer-->
<?php include("admin/footer_admin.php"); ?>

</html>