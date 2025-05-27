<?php
session_start();
$title = "Editar Proyectos";
include ("../conexion.php");
$SELECT = mysqli_query($conexion, "SELECT * FROM estados");
$SELECT_red = mysqli_query($conexion, "SELECT * FROM redes");

$idproyecto = $_GET['id'];
$sql = mysqli_query($conexion, "SELECT * FROM proyectos WHERE idproyecto='$idproyecto' limit 0,1");
$count = mysqli_num_rows($sql);

if ($count == 0) {
    // Código si no hay resultados
}

while ($rw = mysqli_fetch_array($sql)) {
    $idred = $rw['idred'];
    $nombre_proyecto = $rw['nombre_proyecto'];
    $imagen_proyecto = $rw['imagen_proyecto'];
    $moneda_proyecto = $rw['moneda_proyecto'];
    $precio_proyecto = $rw['precio_proyecto'];
    $idestado = $rw['idestado'];
    $tipo_proyecto = $rw['tipo_proyecto'];
    $estado_proyecto = $rw['estado_proyecto'];
    $descripcion_proyecto = $rw['descripcion_proyecto'];
    $pagina_proyecto = $rw['pagina_proyecto'];
    $whitepaper_proyecto = $rw['whitepaper_proyecto'];
    $descripcion2_proyecto = $rw['descripcion2_proyecto'];
}

$active_config = "active";
$active_banner = "active";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../images/icons/favicon.ico">
    <title>Editar Proyecto</title>
</head>

<body>
<!-- Header -->
    <?php include("header_admin.php"); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h3><span class="glyphicon glyphicon-edit"></span> Editar Proyecto</h3>
                
                <form action="abm_proyectos.php" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre_proyecto" class="col-sm-3 control-label">Nombre Proyecto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nombre_proyecto" value="<?php echo $nombre_proyecto; ?>" required name="nombre_proyecto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="orden" class="col-sm-3 control-label">Moneda del Proyecto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="moneda_proyecto" value="<?php echo $moneda_proyecto; ?>" required name="moneda_proyecto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Precio de Moneda del Proyecto</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="precio_proyecto" value="<?php echo $precio_proyecto; ?>" required name="precio_proyecto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nombre_red" class="col-sm-3 control-label">Red</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="idred" required name="idred">
                                <?php while ($r = mysqli_fetch_array($SELECT_red)) { ?>
                                    <option value="<?php echo $r['idred']; ?>" <?php if ($idred == $r['idred']) { echo 'selected'; } ?>>
                                        <?php echo $r['nombre_red'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="idestado" class="col-sm-3 control-label">Estado</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="estado" required name="estado">
                                <?php while ($r = mysqli_fetch_array($SELECT)) { ?>
                                    <option value="<?php echo $r['idestado']; ?>" <?php if ($idestado == $r['idestado']) { echo 'selected'; } ?>>
                                        <?php echo $r['descripcion'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Tipo de Proyecto(Juego)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="tipo_proyecto" name="tipo_proyecto" value="<?php echo $tipo_proyecto; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Estado del Proyecto(Version, Finalizado)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="estado_proyecto" name="estado_proyecto" value="<?php echo $estado_proyecto; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Descripcion breve del proyecto</label>
                        <div class="col-sm-9">
                            <textarea type="text" class="form-control" id="descripcion_proyecto" name="descripcion_proyecto"><?php echo $descripcion_proyecto; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Link del proyecto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="pagina_proyecto" name="pagina_proyecto" value="<?php echo $pagina_proyecto; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Whitepaper</label>
                        <div class="col-sm-9">
                            <textarea type="text" class="form-control" id="whitepaper_proyecto" name="whitepaper_proyecto"><?php echo $whitepaper_proyecto; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio_proyecto" class="col-sm-3 control-label">Noticias</label>
                        <div class="col-sm-9">
                            <textarea type="text" class="form-control" id="descripcion2_proyecto" name="descripcion2_proyecto"><?php echo $descripcion2_proyecto; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div id='loader'></div>
                        <div class='outer_div'></div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <input type="text" name="idproyecto" id="idproyecto" value="<?php echo $idproyecto; ?>" hidden> 
                            <button name="update" id="update" value="update" type="submit" class="btn btn-success">Actualizar datos</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="col-md-5">
                <h3><span class="glyphicon glyphicon-picture"></span> Imagen</h3>
                
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="max-width: 100%;">
                                <img class="img-rounded" src="../img/Proyectos/<?php echo $imagen_proyecto; ?>" />
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 250px;"></div>
                            <div>
                                <span class="btn btn-info btn-file"><span class="fileinput-new">Selecciona una imagen</span>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <input type="file" name="imagen" class="form-control" id="imagen">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="upload-msg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/jasny-bootstrap.min.js"></script>
    
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

    </script>
    
    <script>
        function upload_image() {
            $(".upload-msg").text('Cargando...');
            var idproyecto = $("#idproyecto").val();
            var inputFileImage = document.getElementById("fileToUpload");
            var file = inputFileImage.files[0];
            var data = new FormData();
            data.append('fileToUpload', file);
            data.append('idproyecto', idproyecto);
            
            $.ajax({
                url: "ajax/upload_proyecto.php",
                type: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $(".upload-msg").html(data);
                    window.setTimeout(function() {
                        $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function() {
                            $(this).remove();
                        });
                    }, 5000);
                }
            });
        }
        
        function eliminar(idproyecto) {
            var parametros = {"action": "delete", "idproyecto": idproyecto};
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
    </script>
    
    <script>
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