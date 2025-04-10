<?php
$title = "Galería";
include("../conexion.php");
$active_config = "active";
$active_banner = "active";
session_start();
require('../conexion.php');

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../images/icons/favicon.ico">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> 
    <link href="css/proyectlist.css" rel="stylesheet">   
    <link href="css/perfil.css" rel="stylesheet">
    
</head>
<body>
    <?php include("header_admin.php"); ?>

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
                                <span class="glyphicon glyphicon-plus"></span> Agregar Proyectos
                            </a>
                        </div>
                    </div>
                    <?php 
                    break;
            }
        }
    }
    ?>
    
    <br>
    <div id="loader" class="text-center">
        <span><img src="./img/ajax-loader.gif"></span>
    </div>
    <div class="outer_div"></div><!-- Datos ajax Final -->
    
    <!-- Bootstrap core JavaScript -->
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

    // Tu código AJAX existente
    $(document).ready(function() {
        load(1);
    });

    function load(page) {
        var parametros = {
            "action": "ajax",
            "page": page
        };
        
        $.ajax({
            <?php 
            if(isset($_GET['id']) && !empty($_GET['id'])) {
                $idred = $_GET['id'];
            ?>
                url: './ajax/proyecto_ajax.php?id=<?php echo $idred; ?>',
            <?php } else { ?>
                url: './ajax/proyecto_ajax.php',
            <?php } ?>
            data: parametros,
            beforeSend: function(objeto) {
                $("#loader").html("<img src='../img/ajax-loader.gif'>");
            },
            success: function(data) {
                $(".outer_div").html(data).fadeIn('slow');
                $("#loader").html("");
            }
        });
    }

    function eliminar_slide(idproyecto) {
        page = 1;
        var parametros = {
            "action": "ajax",
            "page": page,
            "idproyecto": idproyecto
        };
        
        if(confirm('Esta acción eliminará de forma permanente el banner \n\n Desea continuar?')) {
            $.ajax({
                url: './ajax/proyecto_ajax.php',
                data: parametros,
                beforeSend: function(objeto) {
                    $("#loader").html("<img src='../images/ajax-loader.gif'>");
                },
                success: function(data) {
                    $(".outer_div").html(data).fadeIn('slow');
                    $("#loader").html("");
                }
            });
        }
    }
    </script>
</body>
</html>