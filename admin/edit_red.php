<?php
session_start();
$title = "Editar Red";
include ("../conexion.php");
$SELECT = mysqli_query($conexion, "SELECT * FROM estados");

$idred = $_GET['id'];
$sql = mysqli_query($conexion, "SELECT * FROM redes WHERE idred='$idred' limit 0,1");
$count = mysqli_num_rows($sql);

if ($count == 0) {
    // Código si no hay resultados
}

while ($rw = mysqli_fetch_array($sql)) {
    $nombre_red = $rw['nombre_red'];
    $imagen_red = $rw['imagen_red'];
    $orden = $rw['orden'];
    $idestado = $rw['idestado'];
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
    <title>Editar Red</title>
</head>

<body>
<!-- Header -->   
    <?php include("header_admin.php"); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h3><span class="glyphicon glyphicon-edit"></span> Editar Red</h3>
                
                <form action="abm_red.php" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre_red" class="col-sm-3 control-label">Nombre Red</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nombre_red" value="<?php echo $nombre_red; ?>" required name="nombre_red">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="orden" class="col-sm-3 control-label">Orden</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="orden" name="orden" value="<?php echo $orden; ?>">
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
                        <div id='loader'></div>
                        <div class='outer_div'></div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <input type="text" name="idred" id="idred" value="<?php echo $idred; ?>" hidden> 
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
                                <img class="img-rounded" src="../img/Redes/<?php echo $imagen_red; ?>" />
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
        function upload_image() {
            $(".upload-msg").text('Cargando...');
            var idred = $("#idred").val();
            var inputFileImage = document.getElementById("fileToUpload");
            var file = inputFileImage.files[0];
            var data = new FormData();
            data.append('fileToUpload', file);
            data.append('idred', idred);
            
            $.ajax({
                url: "ajax/upload_red.php",        // Url to which the request is send
                type: "POST",                     // Type of request to be send, called as method
                data: data,                        // Data sent to server
                contentType: false,                // The content type used when sending data to the server.
                cache: false,                      // To unable request pages to be cached
                processData: false,                // To send DOMDocument or non processed data file it is set to false
                success: function(data) {         // A function to be called if request succeeds
                    $(".upload-msg").html(data);
                    window.setTimeout(function() {
                        $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function() {
                            $(this).remove();
                        });
                    }, 5000);
                }
            });
        }
        
        function eliminar(idred) {
            var parametros = {"action": "delete", "idred": idred};
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
        $("#editar_red").submit(function(e) {
            $.ajax({
                url: "ajax/editar_red.php",
                type: "POST",
                data: $("#editar_red").serialize(),
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