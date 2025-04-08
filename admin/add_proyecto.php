<?php
session_start();
include("../conexion.php");
$SELECT = mysqli_query($conexion, "SELECT * FROM estados");
$SELECT_red = mysqli_query($conexion, "SELECT * FROM redes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <link rel="icon" href="../images/icons/favicon.ico">
    <title>Proyecto</title>
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


    
    <!-- componentes principales -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3><span class="glyphicon glyphicon-edit"></span> Agregar Proyectos</h3>

                <form action="abm_proyectos.php" class="form-horizontal" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="nombre_red" class="col-sm-3 control-label">Nombre Proyecto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nombre_proyecto" required name="nombre_proyecto">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="orden" class="col-sm-3 control-label">Moneda del Proyecto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="moneda_proyecto" name="moneda_proyecto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Precio de Moneda del Proyecto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="precio_proyecto" name="precio_proyecto">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="nombre_red" class="col-sm-3 control-label">Red</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="nombre_red" required name="nombre_red">
                                <?php while($nombre_red = mysqli_fetch_array($SELECT_red)) { ?>
                                    <option value="<?php echo $nombre_red['idred']; ?>">
                                        <?php echo $nombre_red['nombre_red'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="estado" class="col-sm-3 control-label">Estado</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="estado" required name="estado">
                                <?php while($idestado = mysqli_fetch_array($SELECT)) { ?>
                                    <option value="<?php echo $idestado['idestado']; ?>">
                                        <?php echo $idestado['descripcion'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Tipo de Proyecto(Juego)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="tipo_proyecto" name="tipo_proyecto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Estado del Proyecto(Version, Finalizado)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="estado_proyecto" name="estado_proyecto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Descripcion breve del proyecto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="descripcion_proyecto" name="descripcion_proyecto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Link del proyecto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="pagina_proyecto" name="pagina_proyecto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Whitepaper</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="whitepaper_proyecto" name="whitepaper_proyecto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Noticias</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="descripcion2_proyecto" name="descripcion2_proyecto">
                        </div>
                    </div>
                    
                    <!-- Campo de imagen movido aquí dentro del formulario -->
                    <div class="form-group">
                        <label for="imagen" class="col-sm-3 control-label">Imagen del Proyecto</label>
                        <div class="col-sm-9">
                            <input type="file" name="imagen" class="form-control" id="imagen" accept="image/*">
                            <small class="text-muted">Formatos aceptados: JPG, PNG, JPEG, GIF. Tamaño máximo: 2MB</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div id='loader'></div>
                        <div class='outer_div'></div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <button id="insert" name="insert" value="insert" type="submit" class="btn btn-success">Agregar Proyecto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> 
    </div><!-- /container -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/jasny-bootstrap.min.js"></script>


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
    
    <script>
        function eliminar(id_proyecto) {
            var parametros = {
                "action": "delete",
                "id_proyecto": id_proyecto
            };
            $.ajax({
                url: 'ajax/upload2.php',
                data: parametros,
                beforeSend: function(objeto) {
                    $(".upload-msg2").text('Cargando...');
                },
                success: function(data) {
                    $(".upload-msg2").html(data);
                }
            });
        }
        
        $("#editar_proyecto").submit(function(e) {
            $.ajax({
                url: "ajax/editar_proyecto.php",
                type: "POST",
                data: $("#editar_proyecto").serialize(),
                beforeSend: function(objeto) {
                    $("#loader").html("Cargando...");
                },
                success: function(data) {
                    $(".outer_div").html(data).fadeIn('slow');
                    $("#loader").html("");
                }
            });
            e.preventDefault();
        });
    </script>
</body>
</html>