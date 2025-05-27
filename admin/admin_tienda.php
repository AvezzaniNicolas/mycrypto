<?php
session_start();
require('../conexion.php');

// Verificar permisos de administrador
if (!isset($_SESSION['logueado'])) {
    header("Location: ../login.php");
    exit();
}

$idrol = $_SESSION['rol'];
$permiso = mysqli_query($conexion, "SELECT p.descripcion FROM permisos p 
          JOIN permiso_roles pr ON p.idpermiso = pr.idpermiso 
          WHERE pr.idrol = $idrol AND p.descripcion = 'alta tienda'");

if (mysqli_num_rows($permiso) == 0) {
    header("Location: ../index.php");
    exit();
}

// Procesar formularios
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['agregar'])) {
        // Procesar alta de artículo
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
        $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
        $precio = intval($_POST['precio']);
        
        // Procesar imagen
        $imagen = '';
        if (!empty($_FILES['imagen']['name'])) {
            $target_dir = "../uploads/tienda/";
            $file_name = uniqid() . '_' . basename($_FILES["imagen"]["name"]);
            $target_file = $target_dir . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            // Verificar si es una imagen real
            $check = getimagesize($_FILES["imagen"]["tmp_name"]);
            if ($check !== false) {
                // Mover el archivo subido
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                    $imagen = $file_name;
                }
            }
        }
        
        $query = "INSERT INTO tienda_articulos (nombre, descripcion, tipo, precio, imagen, idestado) 
                  VALUES ('$nombre', '$descripcion', '$tipo', $precio, '$imagen', 1)";
        mysqli_query($conexion, $query);
        
        $_SESSION['mensaje'] = "Artículo agregado correctamente";
        header("Location: admin_tienda.php");
        exit();
    }
    
    if (isset($_POST['modificar'])) {
        // Procesar modificación de artículo
        $idarticulo = intval($_POST['idarticulo']);
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
        $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
        $precio = intval($_POST['precio']);
        $idestado = intval($_POST['idestado']);
        
        // Obtener artículo actual para la imagen
        $articulo_actual = mysqli_query($conexion, "SELECT imagen FROM tienda_articulos WHERE idarticulo = $idarticulo");
        $articulo_actual = mysqli_fetch_assoc($articulo_actual);
        $imagen = $articulo_actual['imagen'];
        
        // Procesar nueva imagen si se subió
        if (!empty($_FILES['imagen']['name'])) {
            // Eliminar imagen anterior si existe
            if (!empty($imagen)) {
                @unlink("../uploads/tienda/" . $imagen);
            }
            
            $target_dir = "../uploads/tienda/";
            $file_name = uniqid() . '_' . basename($_FILES["imagen"]["name"]);
            $target_file = $target_dir . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            // Verificar si es una imagen real
            $check = getimagesize($_FILES["imagen"]["tmp_name"]);
            if ($check !== false) {
                // Mover el archivo subido
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                    $imagen = $file_name;
                }
            }
        }
        
        $query = "UPDATE tienda_articulos 
                  SET nombre = '$nombre', 
                      descripcion = '$descripcion', 
                      tipo = '$tipo', 
                      precio = $precio, 
                      imagen = '$imagen',
                      idestado = $idestado
                  WHERE idarticulo = $idarticulo";
        mysqli_query($conexion, $query);
        
        $_SESSION['mensaje'] = "Artículo modificado correctamente";
        header("Location: admin_tienda.php");
        exit();
    }
}

if (isset($_GET['eliminar'])) {
    // Procesar baja de artículo
    $idarticulo = intval($_GET['eliminar']);
    
    // Obtener imagen para eliminarla
    $articulo = mysqli_query($conexion, "SELECT imagen FROM tienda_articulos WHERE idarticulo = $idarticulo");
    $articulo = mysqli_fetch_assoc($articulo);
    
    if (!empty($articulo['imagen'])) {
        @unlink("../uploads/tienda/" . $articulo['imagen']);
    }
    
    $query = "DELETE FROM tienda_articulos WHERE idarticulo = $idarticulo";
    mysqli_query($conexion, $query);
    
    $_SESSION['mensaje'] = "Artículo eliminado correctamente";
    header("Location: admin_tienda.php");
    exit();
}

// Obtener artículos agrupados por tipo
$articulos = mysqli_query($conexion, "SELECT ta.*, e.descripcion as estado 
                                     FROM tienda_articulos ta
                                     JOIN estados e ON ta.idestado = e.idestado
                                     ORDER BY ta.tipo, ta.nombre");

// Organizar artículos por tipo
$articulosPorTipo = [
    'fondo' => [],
    'banner' => [],
    'avatar' => []
];

while ($articulo = mysqli_fetch_assoc($articulos)) {
    $articulosPorTipo[$articulo['tipo']][] = $articulo;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Tienda</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="../css/proyectlist.css" rel="stylesheet">


    <style>
        /* Estilos generales */
        body {
            background-color: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        /* Alertas */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        /* Formulario */
        .form-container {
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }
        
        .form-container h2 {
            margin-top: 0;
            color: #444;
            font-size: 22px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        
        /* Secciones de artículos */
        .category-section {
            margin-bottom: 40px;
        }
        
        .category-title {
            padding: 12px 15px;
            background-color: #2c3e50;
            color: white;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        
        /* Grid de artículos */
        .articulos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }
        
        /* Tarjetas de artículos */
        .articulo-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: white;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }
        
        .articulo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: #007bff;
        }
        
        .articulo-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }
        
        .articulo-card:hover img {
            transform: scale(1.03);
        }
        
        .articulo-card h4 {
            margin: 0 0 10px;
            font-size: 17px;
            color: #333;
            font-weight: 600;
        }
        
        .articulo-info {
            margin-bottom: 15px;
        }
        
        .articulo-info p {
            margin: 8px 0;
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }
        
        .articulo-precio {
            font-weight: bold;
            color: #27ae60;
            font-size: 16px;
        }
        
        /* Estado */
        .articulo-estado {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .estado-activo {
            background-color: #27ae60;
            color: white;
        }
        
        .estado-inactivo {
            background-color: #e74c3c;
            color: white;
        }
        
        /* Acciones */
        .articulo-acciones {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }
        
        .btn-warning {
            background-color: #f39c12;
            border-color: #f39c12;
            color: white;
        }
        
        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
        
        .btn-default {
            background-color: #95a5a6;
            border-color: #95a5a6;
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .articulos-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
            
            .container {
                padding: 15px;
            }
        }
        
        @media (max-width: 480px) {
            .articulos-grid {
                grid-template-columns: 1fr;
            }
            
            .articulo-acciones {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<?php include('header_admin.php'); ?>

<div class="container">
    <h1><span class="glyphicon glyphicon-shopping-cart"></span> Administrar Artículos de la Tienda</h1>
    
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span> <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
        </div>
    <?php endif; ?>
    
    <!-- Formulario para agregar/modificar -->
    <div class="form-container">
        <h2><?php echo isset($_GET['editar']) ? 'Modificar Artículo' : 'Agregar Nuevo Artículo'; ?></h2>
        <form method="POST" enctype="multipart/form-data">
            <?php
            $articulo = null;
            if (isset($_GET['editar'])) {
                $idarticulo = intval($_GET['editar']);
                $articulo = mysqli_query($conexion, "SELECT * FROM tienda_articulos WHERE idarticulo = $idarticulo");
                $articulo = mysqli_fetch_assoc($articulo);
            }
            ?>
            
            <input type="hidden" name="idarticulo" value="<?php echo $articulo['idarticulo'] ?? ''; ?>">
            
            <div class="form-group">
                <label for="nombre">Nombre del artículo:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" 
                       value="<?php echo $articulo['nombre'] ?? ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $articulo['descripcion'] ?? ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="tipo">Tipo de artículo:</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="fondo" <?php echo ($articulo['tipo'] ?? '') == 'fondo' ? 'selected' : ''; ?>>Fondo de Perfil</option>
                    <option value="banner" <?php echo ($articulo['tipo'] ?? '') == 'banner' ? 'selected' : ''; ?>>Banner</option>
                    <option value="avatar" <?php echo ($articulo['tipo'] ?? '') == 'avatar' ? 'selected' : ''; ?>>Avatar</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="precio">Precio en puntos:</label>
                <input type="number" class="form-control" id="precio" name="precio" 
                       value="<?php echo $articulo['precio'] ?? ''; ?>" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="imagen">Imagen del artículo:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" <?php echo !isset($articulo) ? 'required' : ''; ?>>
                <?php if (isset($articulo) && !empty($articulo['imagen'])): ?>
                    <div style="margin-top: 10px;">
                        <p>Imagen actual:</p>
                        <img src="../uploads/tienda/<?php echo $articulo['imagen']; ?>" style="max-width: 150px; max-height: 150px; border-radius: 5px; border: 1px solid #ddd;">
                    </div>
                    <input type="hidden" name="imagen_actual" value="<?php echo $articulo['imagen']; ?>">
                <?php endif; ?>
            </div>
            
            <?php if (isset($articulo)): ?>
                <div class="form-group">
                    <label for="idestado">Estado:</label>
                    <select class="form-control" id="idestado" name="idestado" required>
                        <?php
                        $estados = mysqli_query($conexion, "SELECT * FROM estados");
                        while ($estado = mysqli_fetch_assoc($estados)): ?>
                            <option value="<?php echo $estado['idestado']; ?>" <?php echo $estado['idestado'] == ($articulo['idestado'] ?? 1) ? 'selected' : ''; ?>>
                                <?php echo $estado['descripcion']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php endif; ?>
            
            <div style="margin-top: 25px;">
                <button type="submit" name="<?php echo isset($_GET['editar']) ? 'modificar' : 'agregar'; ?>" class="btn btn-primary">
                    <span class="glyphicon glyphicon-<?php echo isset($_GET['editar']) ? 'refresh' : 'plus'; ?>"></span> 
                    <?php echo isset($_GET['editar']) ? 'Actualizar Artículo' : 'Agregar Artículo'; ?>
                </button>
                
                <?php if (isset($_GET['editar'])): ?>
                    <a href="admin_tienda.php" class="btn btn-default">
                        <span class="glyphicon glyphicon-remove"></span> Cancelar
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <!-- Sección de Fondos -->
    <div class="category-section">
        <div class="category-title">
            <span class="glyphicon glyphicon-picture"></span> Fondos de Perfil
        </div>
        <?php if (empty($articulosPorTipo['fondo'])): ?>
            <div class="alert alert-info">No hay fondos de perfil registrados.</div>
        <?php else: ?>
            <div class="articulos-grid">
                <?php foreach ($articulosPorTipo['fondo'] as $articulo): ?>
                    <div class="articulo-card">
                        <?php if (!empty($articulo['imagen'])): ?>
                            <img src="../uploads/tienda/<?php echo $articulo['imagen']; ?>" alt="<?php echo $articulo['nombre']; ?>">
                        <?php else: ?>
                            <div style="height: 160px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 5px; margin-bottom: 15px;">
                                <span class="glyphicon glyphicon-picture" style="font-size: 40px; color: #ccc;"></span>
                            </div>
                        <?php endif; ?>
                        <h4><?php echo $articulo['nombre']; ?></h4>
                        <div class="articulo-info">
                            <p><?php echo $articulo['descripcion']; ?></p>
                            <p class="articulo-precio"><?php echo $articulo['precio']; ?> puntos</p>
                        </div>
                        <span class="articulo-estado <?php echo $articulo['idestado'] == 1 ? 'estado-activo' : 'estado-inactivo'; ?>">
                            <?php echo $articulo['estado']; ?>
                        </span>
                        <div class="articulo-acciones">
                            <a href="admin_tienda.php?editar=<?php echo $articulo['idarticulo']; ?>" class="btn btn-warning btn-sm">
                                <span class="glyphicon glyphicon-edit"></span> Editar
                            </a>
                            <a href="admin_tienda.php?eliminar=<?php echo $articulo['idarticulo']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este artículo?')">
                                <span class="glyphicon glyphicon-trash"></span> Eliminar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Sección de Banners -->
    <div class="category-section">
        <div class="category-title">
            <span class="glyphicon glyphicon-blackboard"></span> Banners
        </div>
        <?php if (empty($articulosPorTipo['banner'])): ?>
            <div class="alert alert-info">No hay banners registrados.</div>
        <?php else: ?>
            <div class="articulos-grid">
                <?php foreach ($articulosPorTipo['banner'] as $articulo): ?>
                    <div class="articulo-card">
                        <?php if (!empty($articulo['imagen'])): ?>
                            <img src="../uploads/tienda/<?php echo $articulo['imagen']; ?>" alt="<?php echo $articulo['nombre']; ?>">
                        <?php else: ?>
                            <div style="height: 160px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 5px; margin-bottom: 15px;">
                                <span class="glyphicon glyphicon-picture" style="font-size: 40px; color: #ccc;"></span>
                            </div>
                        <?php endif; ?>
                        <h4><?php echo $articulo['nombre']; ?></h4>
                        <div class="articulo-info">
                            <p><?php echo $articulo['descripcion']; ?></p>
                            <p class="articulo-precio"><?php echo $articulo['precio']; ?> puntos</p>
                        </div>
                        <span class="articulo-estado <?php echo $articulo['idestado'] == 1 ? 'estado-activo' : 'estado-inactivo'; ?>">
                            <?php echo $articulo['estado']; ?>
                        </span>
                        <div class="articulo-acciones">
                            <a href="admin_tienda.php?editar=<?php echo $articulo['idarticulo']; ?>" class="btn btn-warning btn-sm">
                                <span class="glyphicon glyphicon-edit"></span> Editar
                            </a>
                            <a href="admin_tienda.php?eliminar=<?php echo $articulo['idarticulo']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este artículo?')">
                                <span class="glyphicon glyphicon-trash"></span> Eliminar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Sección de Avatares -->
    <div class="category-section">
        <div class="category-title">
            <span class="glyphicon glyphicon-user"></span> Avatares
        </div>
        <?php if (empty($articulosPorTipo['avatar'])): ?>
            <div class="alert alert-info">No hay avatares registrados.</div>
        <?php else: ?>
            <div class="articulos-grid">
                <?php foreach ($articulosPorTipo['avatar'] as $articulo): ?>
                    <div class="articulo-card">
                        <?php if (!empty($articulo['imagen'])): ?>
                            <img src="../uploads/tienda/<?php echo $articulo['imagen']; ?>" alt="<?php echo $articulo['nombre']; ?>" style="border-radius: 50%;">
                        <?php else: ?>
                            <div style="height: 160px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-bottom: 15px;">
                                <span class="glyphicon glyphicon-user" style="font-size: 40px; color: #ccc;"></span>
                            </div>
                        <?php endif; ?>
                        <h4><?php echo $articulo['nombre']; ?></h4>
                        <div class="articulo-info">
                            <p><?php echo $articulo['descripcion']; ?></p>
                            <p class="articulo-precio"><?php echo $articulo['precio']; ?> puntos</p>
                        </div>
                        <span class="articulo-estado <?php echo $articulo['idestado'] == 1 ? 'estado-activo' : 'estado-inactivo'; ?>">
                            <?php echo $articulo['estado']; ?>
                        </span>
                        <div class="articulo-acciones">
                            <a href="admin_tienda.php?editar=<?php echo $articulo['idarticulo']; ?>" class="btn btn-warning btn-sm">
                                <span class="glyphicon glyphicon-edit"></span> Editar
                            </a>
                            <a href="admin_tienda.php?eliminar=<?php echo $articulo['idarticulo']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este artículo?')">
                                <span class="glyphicon glyphicon-trash"></span> Eliminar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>


<script>
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

<?php include('footer_admin.php'); ?>

</body>
</html>