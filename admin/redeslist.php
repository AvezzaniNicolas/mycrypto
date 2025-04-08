<?php
$title = "Galería";
session_start();
require('../conexion.php'); // Usar require_once para incluir solo una vez

$active_config = "active";
$active_banner = "active";

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] <= 0) {
    header("Location: login.php"); // Redirigir si no está logueado
    exit();
}

$idusuario = $_SESSION['logueado'];
$consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario = $idusuario");
$usuario = mysqli_fetch_assoc($consulta);

// Asignar valores con operador ternario para mayor claridad
$nick = $usuario['nickname'] ?? '';
$email = $usuario['email'] ?? '';
$nombre = $usuario['nombre'] ?? '';
$apellido = $usuario['apellido'] ?? '';
$foto = $usuario['foto'] ?? 'default.jpg';
$rol = $_SESSION['rol'] ?? '';
?>

<!DOCTYPE html>
<html lang="es"> <!-- Cambiado a 'es' para mejor SEO -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Página de administración"> <!-- Mejor SEO -->
    <link rel="icon" href="../images/icons/favicon.ico">
    <title><?php echo htmlspecialchars($title); ?></title> <!-- Seguridad XSS -->
    
    <!-- Hojas de estilo -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="css/proyectlist.css" rel="stylesheet">
    <link href="css/perfil.css" rel="stylesheet">
</head>

<body>
    <!-- Interruptor de modo oscuro -->
    <div class="toggle-container">
        <span class="toggle-label">Luces</span>
        <label class="toggle-switch">
            <input type="checkbox" id="dark-mode-toggle">
            <span class="slider"></span>
        </label>
    </div>
    
    <?php include("header_admin.php"); ?>
    
    <?php 
    $permiso = mysqli_query($conexion, 
        "SELECT p.descripcion 
         FROM permisos AS p
         JOIN permiso_roles AS pr ON p.idpermiso = pr.idpermiso
         WHERE pr.idrol = $rol");
    
    while($r = mysqli_fetch_assoc($permiso)) {
        if ($r['descripcion'] === 'alta red') {
            echo '<div class="row">
                <div class="col-xs-12 text-right">
                    <a href="add_red.php" class="btn btn-default">
                        <span class="glyphicon glyphicon-plus"></span> Agregar Red
                    </a>
                </div>
            </div>';
            break;
        }
    }
    ?>
    
    <br>
    <div id="loader" class="text-center">
        <span><img src="./img/ajax-loader.gif" alt="Cargando..."></span> <!-- Alt para accesibilidad -->
    </div>
    <div class="outer_div"></div><!-- Datos ajax Final -->
    
    <!-- Scripts al final del body para mejor rendimiento -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
    <?php include("footer_admin.php"); ?>

    <script>
    // Modo oscuro mejorado
    document.addEventListener('DOMContentLoaded', function() {
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const body = document.body;
        
        // Verificar preferencias del sistema
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Función para aplicar modo oscuro
        function applyDarkMode(enable) {
            body.classList.toggle('dark-mode', enable);
            if(darkModeToggle) darkModeToggle.checked = enable;
        }
        
        // Cargar estado guardado o preferencia del sistema
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode === 'enabled' || (savedMode === null && prefersDarkScheme.matches)) {
            applyDarkMode(true);
        }
        
        // Escuchar cambios en el toggle
        if(darkModeToggle) {
            darkModeToggle.addEventListener('change', function() {
                const isEnabled = this.checked;
                localStorage.setItem('darkMode', isEnabled ? 'enabled' : 'disabled');
                applyDarkMode(isEnabled);
            });
        }
        
        // Escuchar cambios en las preferencias del sistema
        prefersDarkScheme.addEventListener('change', e => {
            if (localStorage.getItem('darkMode') === null) {
                applyDarkMode(e.matches);
            }
        });
    });

    // AJAX functions
    $(document).ready(function() {
        load(1);
    });

    function load(page) {
        $.ajax({
            url: './ajax/red_ajax.php',
            data: { 
                "action": "ajax",
                "page": page 
            },
            beforeSend: function() {
                $("#loader").html("<img src='../img/ajax-loader.gif' alt='Cargando'>");
            },
            success: function(data) {
                $(".outer_div").html(data).fadeIn('slow');
                $("#loader").html("");
            },
            error: function(xhr, status, error) {
                console.error("Error en la carga: ", status, error);
                $("#loader").html("<div class='alert alert-danger'>Error al cargar los datos</div>");
            }
        });
    }

    function eliminar_slide(idred) {
        if(confirm('Esta acción eliminará de forma permanente el banner \n\n¿Desea continuar?')) {
            $.ajax({
                url: './ajax/red_ajax.php',
                data: {
                    "action": "ajax",
                    "page": 1,
                    "idred": idred
                },
                beforeSend: function() {
                    $("#loader").html("<img src='../images/ajax-loader.gif' alt='Procesando'>");
                },
                success: function(data) {
                    $(".outer_div").html(data).fadeIn('slow');
                    $("#loader").html("");
                },
                error: function() {
                    $("#loader").html("<div class='alert alert-danger'>Error al eliminar</div>");
                }
            });
        }
    }
    </script>
</body>
</html>