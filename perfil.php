<?php session_start();
require('conexion.php');

$idusuario = $_SESSION['logueado'] ?? null;

if (!$idusuario) {
    header("Location: login.php");
    exit();
}

// Función para dar puntos diarios
function darPuntosDiarios($conexion, $idusuario) {
    $hoy = date('Y-m-d');
    $query = "SELECT * FROM usuario_puntos WHERE idusuario = $idusuario";
    $result = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($result) == 0) {
        // Primer acceso, crear registro
        $insert = "INSERT INTO usuario_puntos (idusuario, puntos, ultima_recompensa) 
                   VALUES ($idusuario, 100, '$hoy')";
        mysqli_query($conexion, $insert);
        return 100;
    } else {
        $puntos = mysqli_fetch_assoc($result);
        
        if ($puntos['ultima_recompensa'] != $hoy) {
            // Dar puntos diarios (100 puntos por día)
            $nuevosPuntos = $puntos['puntos'] + 100;
            $update = "UPDATE usuario_puntos 
                       SET puntos = $nuevosPuntos, ultima_recompensa = '$hoy' 
                       WHERE idusuario = $idusuario";
            mysqli_query($conexion, $update);
            return 100;
        }
        return 0;
    }
}

// Procesar compras
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['comprar'])) {
        $idarticulo = intval($_POST['idarticulo']);
        
        // Verificar si el usuario ya tiene el artículo
        $check = "SELECT * FROM usuario_inventario 
                 WHERE idusuario = $idusuario AND idarticulo = $idarticulo";
        $result = mysqli_query($conexion, $check);
        
        if (mysqli_num_rows($result) == 0) {
            // Obtener precio del artículo
            $articulo = mysqli_query($conexion, "SELECT precio FROM tienda_articulos WHERE idarticulo = $idarticulo");
            $articulo = mysqli_fetch_assoc($articulo);
            $precio = $articulo['precio'];
            
            // Verificar puntos del usuario
            $puntos = mysqli_query($conexion, "SELECT puntos FROM usuario_puntos WHERE idusuario = $idusuario");
            $puntos = mysqli_fetch_assoc($puntos);
            
            if ($puntos['puntos'] >= $precio) {
                // Restar puntos
                $nuevosPuntos = $puntos['puntos'] - $precio;
                mysqli_query($conexion, "UPDATE usuario_puntos SET puntos = $nuevosPuntos WHERE idusuario = $idusuario");
                
                // Añadir al inventario
                mysqli_query($conexion, "INSERT INTO usuario_inventario (idusuario, idarticulo) VALUES ($idusuario, $idarticulo)");
                
                $_SESSION['mensaje'] = "¡Compra exitosa!";
            } else {
                $_SESSION['error'] = "No tienes suficientes puntos para comprar este artículo.";
            }
        } else {
            $_SESSION['error'] = "Ya tienes este artículo en tu inventario.";
        }
        header("Location: perfil.php");
        exit();
    }
    
    if (isset($_POST['equipar'])) {
        $idarticulo = intval($_POST['idarticulo']);
        $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
        
        // Primero desequipar todos los artículos del mismo tipo
        mysqli_query($conexion, 
            "UPDATE usuario_inventario ui
             JOIN tienda_articulos ta ON ui.idarticulo = ta.idarticulo
             SET ui.equipado = 0
             WHERE ui.idusuario = $idusuario AND ta.tipo = '$tipo'");
        
        // Equipar el artículo seleccionado
        mysqli_query($conexion, 
            "UPDATE usuario_inventario SET equipado = 1 
             WHERE idusuario = $idusuario AND idarticulo = $idarticulo");
        
        $_SESSION['mensaje'] = "Artículo equipado correctamente.";
        header("Location: perfil.php");
        exit();
    }
}

// Dar puntos diarios (si corresponde)
$puntosObtenidos = darPuntosDiarios($conexion, $idusuario);

// Obtener puntos actuales del usuario
$puntos = mysqli_query($conexion, "SELECT puntos FROM usuario_puntos WHERE idusuario = $idusuario");
$puntos = mysqli_fetch_assoc($puntos);
$puntosUsuario = $puntos['puntos'] ?? 0;

// Obtener artículos de la tienda agrupados por tipo
$articulos = mysqli_query($conexion, 
    "SELECT * FROM tienda_articulos WHERE idestado = 1 ORDER BY tipo, precio ASC");

// Organizar artículos por tipo
$articulosPorTipo = [
    'fondo' => [],
    'banner' => [],
    'avatar' => []
];

while ($articulo = mysqli_fetch_assoc($articulos)) {
    $articulosPorTipo[$articulo['tipo']][] = $articulo;
}

// Obtener inventario del usuario
$inventario = mysqli_query($conexion, 
    "SELECT ta.*, ui.idinventario, ui.equipado 
     FROM usuario_inventario ui
     JOIN tienda_articulos ta ON ui.idarticulo = ta.idarticulo
     WHERE ui.idusuario = $idusuario
     ORDER BY ui.fecha_compra DESC");




?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI PERFIL</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="admin/css/perfil.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="admin/css/EstilosAdicionalesABM.css" rel="stylesheet">
        <!-- Iconos Font Awesome iconos de footer -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="admin/css/eestilosinventarioperfil.css" rel="stylesheet">

    <style>
         /* Estilos para el inventario */
    .inventario-section {
        margin-top: 40px;
        padding: 20px;
        background-color:rgb(228, 228, 228);
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .inventario-section h2 {
        color: #333;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    
    .inventario-categoria {
        margin-bottom: 30px;
    }
    
    .inventario-categoria h3 {
        color: #444;
        margin-bottom: 15px;
        font-size: 18px;
    }
    
    .inventario-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .inventario-item {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .inventario-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .inventario-item.equipado {
        border: 2px solid #4CAF50;
        background-color: #f8fff8;
    }
    
    .inventario-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    
    .inventario-item .avatar-img {
        border-radius: 50%;
    }
    
    .inventario-item h4 {
        margin: 10px 0 5px;
        color: #333;
        font-size: 16px;
    }
    
    .inventario-item p {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
    }
    
    .btn-equipar {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }
    
    .btn-equipar:hover {
        background-color: #3e8e41;
    }
    
    .equipado-badge {
        background-color: #4CAF50;
        color: white;
        padding: 8px;
        border-radius: 4px;
        text-align: center;
        font-weight: bold;
    }
    
    @media (max-width: 768px) {
        .inventario-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }
    
    @media (max-width: 480px) {
        .inventario-grid {
            grid-template-columns: 1fr;
        }
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


// Obtener artículos equipados del usuario
$articulosEquipados = [];
$query_articulos = mysqli_query($conexion, 
    "SELECT ta.* FROM usuario_inventario ui
     JOIN tienda_articulos ta ON ui.idarticulo = ta.idarticulo
     WHERE ui.idusuario = $idusuario AND ui.equipado = 1");
     
while ($articulo = mysqli_fetch_assoc($query_articulos)) {
    $articulosEquipados[$articulo['tipo']] = $articulo;
}


// Obtener inventario del usuario
$inventario = mysqli_query($conexion, 
    "SELECT ta.*, ui.equipado 
     FROM usuario_inventario ui
     JOIN tienda_articulos ta ON ui.idarticulo = ta.idarticulo
     WHERE ui.idusuario = $idusuario
     ORDER BY ta.tipo, ui.equipado DESC, ta.nombre");

// Organizar artículos por tipo
$inventarioPorTipo = [
    'fondo' => [],
    'banner' => [],
    'avatar' => []
];

while ($item = mysqli_fetch_assoc($inventario)) {
    $inventarioPorTipo[$item['tipo']][] = $item;
}


?>

<!-- Barra de navegación -->
<div class="navbar">

    <a href="inicio.php" class="active">Inicio</a>
    <a href="admin/proyectoslist.php">PROYECTOS</a>
    <a href="admin/redeslist.php">REDES</a>
    <a href="Archivo tienda.php">TIENDA</a>
    
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

<div class="container">
    <!-- Sección de perfil del usuario -->
    <div style="display: flex; align-items: center; margin-bottom: 20px;">
    <div style="position: relative;">
   
        <div style="position: absolute; display: inline-block;">
            <?php if (isset($articulosEquipados['avatar'])): ?>
                <img src="uploads/tienda/<?php echo $articulosEquipados['avatar']['imagen']; ?>" 
                     style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #fff;">
            <?php endif; ?>
        </div>
        
        <?php if (isset($articulosEquipados['fondo'])): ?>
            <div style="width: 300px; height: 100px; 
                 background-image: url('uploads/tienda/<?php echo $articulosEquipados['fondo']['imagen']; ?>'); 
                 background-size: cover; background-position: center; z-index: -1; opacity: 0.3; border-radius: 8px;"></div>
        <?php endif; ?>
    </div>
    <div style="margin-left: 20px;">
        <h1>Usuario: <?php echo $nick; ?></p>
        <h3>Mail: <?php echo $email; ?></p>
        <h3>Nombre: <?php echo $nombre . ' ' . $apellido; ?></h3>
        <button id="editProfileBtn" class="btn"style="display: inline-block; margin-top: 5px;">Editar Perfil</button>
    </div>
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

 <!--Sección de inventario-->
<div class="container">
<div class="inventario-section">
    <h2><i class="fas fa-archive"></i> Inventario</h2>
    
    <?php if (empty($inventarioPorTipo['fondo']) && empty($inventarioPorTipo['banner']) && empty($inventarioPorTipo['avatar'])): ?>
        <p>Aún no tienes artículos en tu inventario. Visita la tienda para adquirir algunos.</p>
    <?php else: ?>
        <!-- Sección de Fondos -->
        <?php if (!empty($inventarioPorTipo['fondo'])): ?>
            <div class="inventario-categoria">
                <h3><i class="fas fa-image"></i> Fondos de Perfil</h3>
                <div class="inventario-grid">
                    <?php foreach ($inventarioPorTipo['fondo'] as $item): ?>
                        <div class="inventario-item <?php echo $item['equipado'] ? 'equipado' : ''; ?>">
                            <img src="uploads/tienda/<?php echo $item['imagen']; ?>" alt="<?php echo $item['nombre']; ?>">
                            <h4><?php echo $item['nombre']; ?></h4>
                            <p><?php echo $item['descripcion']; ?></p>
                            
                            <?php if (!$item['equipado']): ?>
                                <form method="POST">
                                    <input type="hidden" name="idarticulo" value="<?php echo $item['idarticulo']; ?>">
                                    <input type="hidden" name="tipo" value="<?php echo $item['tipo']; ?>">
                                    <button type="submit" name="equipar" class="btn-equipar">
                                        <i class="fas fa-check"></i> Equipar
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="equipado-badge">
                                    <i class="fas fa-check-circle"></i> Equipado
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Sección de Banners -->
        <?php if (!empty($inventarioPorTipo['banner'])): ?>
            <div class="inventario-categoria">
                <h3><i class="fas fa-flag"></i> Banners</h3>
                <div class="inventario-grid">
                    <?php foreach ($inventarioPorTipo['banner'] as $item): ?>
                        <div class="inventario-item <?php echo $item['equipado'] ? 'equipado' : ''; ?>">
                            <img src="uploads/tienda/<?php echo $item['imagen']; ?>" alt="<?php echo $item['nombre']; ?>">
                            <h4><?php echo $item['nombre']; ?></h4>
                            <p><?php echo $item['descripcion']; ?></p>
                            
                            <?php if (!$item['equipado']): ?>
                                <form method="POST">
                                    <input type="hidden" name="idarticulo" value="<?php echo $item['idarticulo']; ?>">
                                    <input type="hidden" name="tipo" value="<?php echo $item['tipo']; ?>">
                                    <button type="submit" name="equipar" class="btn-equipar">
                                        <i class="fas fa-check"></i> Equipar
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="equipado-badge">
                                    <i class="fas fa-check-circle"></i> Equipado
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Sección de Avatares -->
        <?php if (!empty($inventarioPorTipo['avatar'])): ?>
            <div class="inventario-categoria">
                <h3><i class="fas fa-user"></i> Avatares</h3>
                <div class="inventario-grid">
                    <?php foreach ($inventarioPorTipo['avatar'] as $item): ?>
                        <div class="inventario-item <?php echo $item['equipado'] ? 'equipado' : ''; ?>">
                            <img src="uploads/tienda/<?php echo $item['imagen']; ?>" alt="<?php echo $item['nombre']; ?>" class="avatar-img">
                            <h4><?php echo $item['nombre']; ?></h4>
                            <p><?php echo $item['descripcion']; ?></p>
                            
                            <?php if (!$item['equipado']): ?>
                                <form method="POST">
                                    <input type="hidden" name="idarticulo" value="<?php echo $item['idarticulo']; ?>">
                                    <input type="hidden" name="tipo" value="<?php echo $item['tipo']; ?>">
                                    <button type="submit" name="equipar" class="btn-equipar">
                                        <i class="fas fa-check"></i> Equipar
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="equipado-badge">
                                    <i class="fas fa-check-circle"></i> Equipado
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
</div>




<!-- Modal para editar perfil -->
<div id="editProfileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Editar Perfil</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Nombre de Usuario</label>
                <input type="text" id="user" name="user" value="<?php echo $nick; ?>" required autocomplete="user" disabled>
            </div>
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
<?php include("footer_usuario.php"); ?>

</html>