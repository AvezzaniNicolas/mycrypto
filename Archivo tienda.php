<?php 
session_start();
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
        header("Location: archivo tienda.php");
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
        header("Location: archivo tienda.php");
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
    <title>Tienda Virtual</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> 
    <link href="admin/css/proyectlist.css" rel="stylesheet">   
    <link href="admin/css/perfil.css" rel="stylesheet">
    <style>
        /* Estilos para la tienda */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .puntos-display {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .puntos-display h2 {
            margin: 0;
            font-size: 24px;
        }

        .puntos-display span {
            color: #007bff;
            font-weight: bold;
            font-size: 28px;
        }

        /* Estilos para las categorías */
        .category-section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .category-header {
            background-color: #f5f5f5;
            padding: 12px 15px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s;
        }
        
        .category-header:hover {
            background-color: #e9e9e9;
        }
        
        .category-header h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .category-toggle {
            font-size: 20px;
            color: #666;
        }
        
        .category-content {
            padding: 15px;
            display: none;
        }
        
        .category-section.active .category-content {
            display: block;
        }
        
        /* Grid de artículos */
        .articulos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }
        
        .articulo-card {
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 5px;
            transition: all 0.3s;
            background-color: #fff;
        }
        
        .articulo-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        
        .articulo-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }
        
        .articulo-card h4 {
            margin: 10px 0 5px;
            font-size: 16px;
            color: #333;
        }
        
        .articulo-card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .articulo-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .precio {
            font-weight: bold;
            color: #28a745;
            font-size: 16px;
        }
        
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        
       /* Estilos para el inventario */
.inventario-section {
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.inventario-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.inventario-item {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    background-color: #fff;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.inventario-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.inventario-item.equipado {
    border: 2px solid #28a745;
    background-color: #f8f9fa;
    position: relative;
}

.inventario-item.equipado::after {
    content: "EQUIPADO";
    position: absolute;
    top: -10px;
    right: -10px;
    background: #28a745;
    color: white;
    padding: 3px 8px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: bold;
}

.inventario-item img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #eee;
    margin: 0 auto 10px;
    display: block;
    transition: all 0.3s ease;
}

.inventario-item:hover img {
    border-color: #007bff;
}

.inventario-item h4 {
    margin: 10px 0 5px;
    font-size: 16px;
    color: #333;
    font-weight: bold;
}

.inventario-item p {
    color: #666;
    font-size: 14px;
    margin-bottom: 15px;
}

.inventario-item .btn {
    width: 100%;
    margin-top: 10px;
}

.equipado-label {
    display: none; /* Ocultamos el texto ya que usamos el pseudo-elemento */
}
    </style>
</head>
<body>

<?php include('header_usuario.php'); ?>

<?php 
    // Mostrar botón de agregar solo si tiene permiso
    if(isset($_SESSION['logueado'])) {
        $idrol = $_SESSION['rol'];
        $permiso = mysqli_query($conexion, "SELECT p.descripcion FROM permisos p 
                  JOIN permiso_roles pr ON p.idpermiso = pr.idpermiso 
                  WHERE pr.idrol = $idrol AND p.descripcion = 'alta proyecto'");
        
        if(mysqli_num_rows($permiso) > 0): ?>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a href='admin/admin_tienda.php' class="btn btn-default">
                        <span class="glyphicon glyphicon-plus"></span> Agregar o Modificar Avatar/Banner/Fondos
                    </a>
                </div>
            </div>
        <?php endif;
    }
    ?>

<div class="container">
    <h1>Tienda Virtual</h1>
    
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <?php if ($puntosObtenidos > 0): ?>
        <div class="alert success">¡Has recibido <?php echo $puntosObtenidos; ?> puntos por entrar hoy!</div>
    <?php endif; ?>
    
    <div class="puntos-display">
        <h2>Tus puntos: <span><?php echo $puntosUsuario; ?></span></h2>
    </div>
    
    <!-- Sección de Fondos -->
    <div class="category-section active">
        <div class="category-header" onclick="toggleCategory(this)">
            <h3>Fondos de Perfil</h3>
            <span class="category-toggle">-</span>
        </div>
        <div class="category-content">
            <?php if (empty($articulosPorTipo['fondo'])): ?>
                <p>No hay fondos disponibles en este momento.</p>
            <?php else: ?>
                <div class="articulos-grid">
                    <?php foreach ($articulosPorTipo['fondo'] as $articulo): ?>
                        <div class="articulo-card">
                            <img src="uploads/tienda/<?php echo $articulo['imagen']; ?>" alt="<?php echo $articulo['nombre']; ?>">
                            <h4><?php echo $articulo['nombre']; ?></h4>
                            <p><?php echo $articulo['descripcion']; ?></p>
                            <div class="articulo-footer">
                                <span class="precio"><?php echo $articulo['precio']; ?> puntos</span>
                                <form method="POST">
                                    <input type="hidden" name="idarticulo" value="<?php echo $articulo['idarticulo']; ?>">
                                    <button type="submit" name="comprar" class="btn btn-primary">Comprar</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Sección de Banners -->
    <div class="category-section active">
        <div class="category-header" onclick="toggleCategory(this)">
            <h3>Banners</h3>
            <span class="category-toggle">-</span>
        </div>
        <div class="category-content">
            <?php if (empty($articulosPorTipo['banner'])): ?>
                <p>No hay banners disponibles en este momento.</p>
            <?php else: ?>
                <div class="articulos-grid">
                    <?php foreach ($articulosPorTipo['banner'] as $articulo): ?>
                        <div class="articulo-card">
                            <img src="uploads/tienda/<?php echo $articulo['imagen']; ?>" alt="<?php echo $articulo['nombre']; ?>">
                            <h4><?php echo $articulo['nombre']; ?></h4>
                            <p><?php echo $articulo['descripcion']; ?></p>
                            <div class="articulo-footer">
                                <span class="precio"><?php echo $articulo['precio']; ?> puntos</span>
                                <form method="POST">
                                    <input type="hidden" name="idarticulo" value="<?php echo $articulo['idarticulo']; ?>">
                                    <button type="submit" name="comprar" class="btn btn-primary">Comprar</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Sección de Avatares -->
    <div class="category-section active">
        <div class="category-header" onclick="toggleCategory(this)">
            <h3>Avatares</h3>
            <span class="category-toggle">-</span>
        </div>
        <div class="category-content">
            <?php if (empty($articulosPorTipo['avatar'])): ?>
                <p>No hay avatares disponibles en este momento.</p>
            <?php else: ?>
                <div class="articulos-grid">
                    <?php foreach ($articulosPorTipo['avatar'] as $articulo): ?>
                        <div class="articulo-card">
                            <img src="uploads/tienda/<?php echo $articulo['imagen']; ?>" alt="<?php echo $articulo['nombre']; ?>">
                            <h4><?php echo $articulo['nombre']; ?></h4>
                            <p><?php echo $articulo['descripcion']; ?></p>
                            <div class="articulo-footer">
                                <span class="precio"><?php echo $articulo['precio']; ?> puntos</span>
                                <form method="POST">
                                    <input type="hidden" name="idarticulo" value="<?php echo $articulo['idarticulo']; ?>">
                                    <button type="submit" name="comprar" class="btn btn-primary">Comprar</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Sección de Inventario -->
    <div class="inventario-section">
        <h2>Tu Inventario</h2>
        
        <?php if (mysqli_num_rows($inventario) == 0): ?>
            <p>No tienes artículos en tu inventario aún.</p>
        <?php else: ?>
            <div class="inventario-grid">
                <?php while ($item = mysqli_fetch_assoc($inventario)): ?>
                    <div class="inventario-item <?php echo $item['equipado'] ? 'equipado' : ''; ?>">
                        <img src="uploads/tienda/<?php echo $item['imagen']; ?>" alt="<?php echo $item['nombre']; ?>">
                        <h4><?php echo $item['nombre']; ?></h4>
                        <p>Tipo: <?php echo ucfirst($item['tipo']); ?></p>
                        
                        <?php if (!$item['equipado']): ?>
                            <form method="POST">
                                <input type="hidden" name="idarticulo" value="<?php echo $item['idarticulo']; ?>">
                                <input type="hidden" name="tipo" value="<?php echo $item['tipo']; ?>">
                                <button type="submit" name="equipar" class="btn btn-primary">Equipar</button>
                            </form>
                        <?php else: ?>
                            <span class="equipado-label">Equipado</span>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Función para mostrar/ocultar categorías
    function toggleCategory(header) {
        const section = header.parentElement;
        const content = header.nextElementSibling;
        const toggle = header.querySelector('.category-toggle');
        
        if (section.classList.contains('active')) {
            section.classList.remove('active');
            content.style.display = 'none';
            toggle.textContent = '+';
        } else {
            section.classList.add('active');
            content.style.display = 'block';
            toggle.textContent = '-';
        }
    }
    
    // Inicializar todas las secciones como abiertas
    document.querySelectorAll('.category-section').forEach(section => {
        section.classList.add('active');
        section.querySelector('.category-content').style.display = 'block';
    });

    // Modo oscuro mejorado
    document.addEventListener('DOMContentLoaded', function() {
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const body = document.body;
        
        // Verificar preferencias del sistema
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Función para aplicar modo oscuro
        function applyDarkMode(enable) {
            if (enable) {
                body.classList.add('dark-mode');
                if(darkModeToggle) darkModeToggle.checked = true;
            } else {
                body.classList.remove('dark-mode');
                if(darkModeToggle) darkModeToggle.checked = false;
            }
        }
        
        // Cargar estado guardado o preferencia del sistema
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode === 'enabled' || (savedMode === null && prefersDarkScheme.matches)) {
            applyDarkMode(true);
        }
        
        // Escuchar cambios en el toggle
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
        
        // Escuchar cambios en las preferencias del sistema
        prefersDarkScheme.addEventListener('change', e => {
            if (localStorage.getItem('darkMode') === null) {
                applyDarkMode(e.matches);
            }
        });
    });
</script>

<?php include("footer_usuario.php"); ?>
</body>
</html>