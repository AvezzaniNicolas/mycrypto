<?php 
session_start();
require ('conexion.php');

// Configuración del webhook de Discord (REEMPLAZA CON TU URL)
$webhook_url = "https://discord.com/api/webhooks/1355906975871008968/aPIa4O-fJaswxrwFvinK8ry0vCIorgkFrFxSzzjZGDDgKev48QvqZBmzBDGy-0rlh_NA";


$idproyecto = $_GET['id'];

// Función para enviar notificaciones a Discord
function sendToDiscord($webhook_url, $title, $description, $fields, $color = "3498db") {
    $data = [
        "embeds" => [
            [
                "title" => $title,
                "description" => $description,
                "fields" => $fields,
                "color" => hexdec($color),
                "timestamp" => date("c")
            ]
        ]
    ];
    
    $options = [
        "http" => [
            "header" => "Content-type: application/json",
            "method" => "POST",
            "content" => json_encode($data)
        ]
    ];
    
    $context = stream_context_create($options);
    @file_get_contents($webhook_url, false, $context);
}

// Notificar visita al proyecto
if(isset($_SESSION['logueado'])) {
    $consulta_user = mysqli_query($conexion, "SELECT nickname FROM usuarios WHERE idusuario = ".$_SESSION['logueado']);
    $user_data = mysqli_fetch_assoc($consulta_user);
    $username = $user_data['nickname'];
} else {
    $username = "Invitado";
}

sendToDiscord($webhook_url, 
    "🔍 Visita a proyecto", 
    "Nueva visita a la página de proyecto", 
    [
        ["name" => "👤 Usuario", "value" => $username, "inline" => true],
        ["name" => "🕒 Fecha", "value" => date("d/m/Y H:i:s"), "inline" => true]
    ],
    "3498db"
);

// Consulta para obtener datos del proyecto
$SELECT = mysqli_query($conexion, 
    "SELECT p.*, r.nombre_red, r.moneda_red, r.imagen_red 
     FROM proyectos p
     JOIN redes r ON p.idred = r.idred
     WHERE p.idproyecto = $idproyecto");

if(mysqli_num_rows($SELECT) > 0) {
    $r = mysqli_fetch_array($SELECT);

    $nombre_proyecto = $r['nombre_proyecto'];
    $precio_proyecto = $r['precio_proyecto'];
    $moneda_proyecto = $r['moneda_proyecto'];
    $imagen_proyecto = $r['imagen_proyecto'];
    $idred = $r['idred'];
    $tipo_proyecto = $r['tipo_proyecto'];
    $estado_proyecto = $r['estado_proyecto'];
    $descripcion_proyecto = $r['descripcion_proyecto'];
    $pagina_proyecto = $r['pagina_proyecto'];
    $whitepaper_proyecto = $r['whitepaper_proyecto'];
    $descripcion2_proyecto = $r['descripcion2_proyecto'];
    
    // Datos de la red
    $nombre_red = $r['nombre_red'];
    $moneda_red = $r['moneda_red'];
    $imagen_red = $r['imagen_red'];
} else {
    header("Location: error.php?msg=Proyecto no encontrado");
    exit();
}

// Obtener datos del usuario si está logueado
if(isset($_SESSION['logueado'])) {
    $consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario = ".$_SESSION['logueado']);
    if(mysqli_num_rows($consulta) > 0) {
        $respuesta = mysqli_fetch_assoc($consulta);
        $nick = $respuesta['nickname'];
        $email = $respuesta['email'];
        $descripcion = $respuesta['descripcion']; 
        $twitter = $respuesta['twitter'];
        $instagram = $respuesta['instagram'];
        $facebook = $respuesta['facebook'];
    }
} else {
    $nick = "Invitado";
}

// Procesar clic en enlaces externos
if(isset($_GET['clicked'])) {
    sendToDiscord($webhook_url, 
        "🖱️ Clic en enlace oficial", 
        "Usuario accediendo al sitio oficial del proyecto",
        [
            ["name" => "👤 Usuario", "value" => $nick, "inline" => true],
            ["name" => "🌐 Proyecto", "value" => $nombre_proyecto, "inline" => true],
            ["name" => "🔗 Enlace", "value" => $pagina_proyecto, "inline" => false]
        ],
        "2ecc71"
    );
    header("Location: ".$pagina_proyecto);
    exit();
}

if(isset($_GET['wpclick'])) {
    sendToDiscord($webhook_url, 
        "📄 Whitepaper visualizado", 
        "Usuario accediendo al documento técnico",
        [
            ["name" => "👤 Usuario", "value" => $nick, "inline" => true],
            ["name" => "📑 Proyecto", "value" => $nombre_proyecto, "inline" => true],
            ["name" => "🔗 Enlace", "value" => $whitepaper_proyecto, "inline" => false]
        ],
        "e74c3c"
    );
    header("Location: ".$whitepaper_proyecto);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $nombre_proyecto; ?> | MyCrypto</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    
    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Iconos Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color:rgb(226, 176, 69);
            --secondary-color:rgb(23, 24, 24);
            --dark-bg: #0f0f1a;
            --darker-bg: #0a0a12;
            --text-light:rgb(252, 193, 0);
            --text-muted:rgb(0, 0, 0);
            --accent-color: #ff6b6b;
        }
        
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-light);
            overflow-x: hidden;
        }
        
        .crypto-heading {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .navbar {
            background-color: rgba(15, 15, 26, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .project-header {
            background: linear-gradient(135deg, var(--primary-color) 0%,rgb(44, 14, 78) 100%);
            padding: 3rem 0;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .project-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('assets/img/pattern.png') center/cover no-repeat;
            opacity: 0.1;
        }
    </style>
</head>

<body style='background:#090909' data-home-page="proyecto.php" data-home-page-title="Proyectos" class="u-body u-overlap u-white u-xl-mode" data-lang="es">
<?php include("header_usuario.php"); ?>

<header class="project-header">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-md-4 text-center text-md-start">
                <img src="./img/Proyectos/<?php echo $imagen_proyecto; ?>" alt="<?php echo $nombre_proyecto; ?>" class="img-fluid rounded-3 shadow-lg" style="max-height: 200px;">
            </div>
            <div class="col-md-8 text-center text-md-start mt-4 mt-md-0">
                <h1 class="crypto-heading display-4 mb-3"><?php echo $nombre_proyecto; ?></h1>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
                    <span class="badge bg-primary py-2 px-3">
                        <i class="fas fa-coins me-1"></i> <?php echo $moneda_proyecto; ?>
                    </span>
                    <span class="badge bg-secondary py-2 px-3">
                        <i class="fas fa-tag me-1"></i> <?php echo $tipo_proyecto; ?>
                    </span>
                    <span class="badge bg-info py-2 px-3">
                        <i class="fas fa-code-branch me-1"></i> <?php echo $estado_proyecto; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Columna izquierda - Imagen y detalles -->
            <div class="col-lg-4">
                <div class="card bg-darker border-0 shadow-lg h-100">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="./img/Proyectos/<?php echo $imagen_proyecto; ?>" alt="<?php echo $nombre_proyecto; ?>" class="img-fluid rounded-3">
                        </div>
                        
                        <div class="crypto-details">
                            <h4 class="crypto-heading mb-4">Detalles del Proyecto</h4>
                            
                            <div class="detail-item mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-network-wired me-3 text-primary"></i>
                                    <div>
                                        <h6 class="mb-0">Red Blockchain</h6>
                                        <small class="text-muted"><?php echo $nombre_red; ?></small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="detail-item mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-coins me-3 text-warning"></i>
                                    <div>
                                        <h6 class="mb-0">Token</h6>
                                        <small class="text-muted"><?php echo $moneda_proyecto; ?></small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="detail-item mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tag me-3 text-info"></i>
                                    <div>
                                        <h6 class="mb-0">Categoría</h6>
                                        <small class="text-muted"><?php echo $tipo_proyecto; ?></small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="detail-item mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-code-branch me-3 text-success"></i>
                                    <div>
                                        <h6 class="mb-0">Versión</h6>
                                        <small class="text-muted"><?php echo $estado_proyecto; ?></small>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="proyecto.php?id=<?php echo $idproyecto; ?>&clicked=1" class="btn btn-primary w-100 mt-4" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i> Sitio Oficial
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Columna derecha - Descripción y contenido -->
            <div class="col-lg-8">
                <div class="card bg-darker border-0 shadow-lg mb-4">
                    <div class="card-body">
                        <h4 class="crypto-heading mb-4">Descripción</h4>
                        <p><?php echo $descripcion_proyecto; ?></p>
                    </div>
                </div>
                
                <?php if(!empty($whitepaper_proyecto)): ?>
                <div class="card bg-darker border-0 shadow-lg mb-4">
                    <div class="card-body">
                        <h4 class="crypto-heading mb-4">Whitepaper</h4>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-pdf me-3 text-danger" style="font-size: 2rem;"></i>
                            <div>
                                <a href="proyecto.php?id=<?php echo $idproyecto; ?>&wpclick=1" class="text-decoration-none" target="_blank">
                                    <h5 class="mb-0">Documento técnico</h5>
                                    <small class="text-muted">Haz clic para ver el whitepaper</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($descripcion2_proyecto)): ?>
                <div class="card bg-darker border-0 shadow-lg">
                    <div class="card-body">
                        <h4 class="crypto-heading mb-4">Últimas Noticias</h4>
                        <p><?php echo $descripcion2_proyecto; ?></p>
                        <a href="https://es.cointelegraph.com/tags/games" class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                            <i class="fas fa-newspaper me-1"></i> Ver más noticias
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="container" style="text-align: center;">
    <h4><?php echo $nombre_proyecto; echo ' le recuerda ser respestuoso con los otros usuarios'; ?></h4>
</div>

<div style="text-align: center;">
    <a href="proyecto.php?id=<?php echo $idproyecto; ?>&clicked=1" class="u-border-none u-btn u-button-style u-palette-3-light-2 u-btn-1">WEB OFICIAL DEL JUEGO</a>
</div>

<!-- Sección del Chat de Discord -->
<section class="py-5 bg-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="crypto-heading mb-0">
                            <i class="fab fa-discord me-2"></i> Chat de la Comunidad
                        </h4>
                    </div>
                    <div class="card-body p-0">
                        <!-- Widget de Discord -->
                        <iframe src="https://discord.com/widget?id=1355896202788470945&theme=dark&channel=1356135572640366642" 
                                width="100%" 
                                height="500" 
                                allowtransparency="true" 
                                frameborder="0"
                                sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"
                                style="border-radius: 0 0 0.25rem 0.25rem;">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h3 class="crypto-heading text-center mb-5">Proyectos Relacionados</h3>
        
        <div class="row g-4">
            <?php
            $query_relacionados = mysqli_query($conexion, 
                "SELECT * FROM proyectos 
                 WHERE idred = $idred AND idproyecto != $idproyecto 
                 ORDER BY RAND() LIMIT 3");
            
            while($proyecto = mysqli_fetch_array($query_relacionados)):
            ?>
            <div class="col-md-4">
                <div class="card bg-darker border-0 h-100 shadow-lg project-card">
                    <img src="./img/Proyectos/<?php echo $proyecto['imagen_proyecto']; ?>" class="card-img-top" alt="<?php echo $proyecto['nombre_proyecto']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $proyecto['nombre_proyecto']; ?></h5>
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge bg-primary"><?php echo $proyecto['moneda_proyecto']; ?></span>
                            <span class="badge bg-secondary"><?php echo $proyecto['tipo_proyecto']; ?></span>
                        </div>
                        <p class="card-text text-muted small"><?php echo substr($proyecto['descripcion_proyecto'], 0, 100); ?>...</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="proyecto.php?id=<?php echo $proyecto['idproyecto']; ?>" class="btn btn-sm btn-outline-primary w-100">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include("footer_usuario.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>
<script src="js/scripts.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.project-card, .detail-item');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if(elementPosition < screenPosition) {
                    element.classList.add('animate__animated', 'animate__fadeInUp');
                }
            });
        };
        
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const body = document.body;
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        
        function applyDarkMode(enable) {
            if (enable) {
                body.classList.add('dark-mode');
                if(darkModeToggle) darkModeToggle.checked = true;
            } else {
                body.classList.remove('dark-mode');
                if(darkModeToggle) darkModeToggle.checked = false;
            }
        }
        
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode === 'enabled' || (savedMode === null && prefersDarkScheme.matches)) {
            applyDarkMode(true);
        }
        
        if(darkModeToggle) {
            darkModeToggle.addEventListener('change', function() {
                if (this.checked) {
                    localStorage.setItem('darkMode', 'enabled');
                    applyDarkMode(true);
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                    applyDarkMode(false);
                }
            });
        }
        
        prefersDarkScheme.addEventListener('change', e => {
            if (localStorage.getItem('darkMode') === null) {
                applyDarkMode(e.matches);
            }
        });
    });
</script>
</body>
</html>