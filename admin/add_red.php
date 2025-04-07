<?php
session_start();
include("../conexion.php");
$SELECT = mysqli_query($conexion, "SELECT * FROM estados");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../images/ico/favicon.ico">
    <title>Red</title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn {
            background: rgb(212, 175, 55);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background: rgb(0, 0, 0);
        }
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>

<body>
    <?php include("header_admin.php"); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3><span class="glyphicon glyphicon-edit"></span> Agregar Red</h3>
                
                <form action="abm_red.php" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre_red" class="col-sm-3 control-label">Nombre Red</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nombre_red" required name="nombre_red">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="orden" class="col-sm-3 control-label">Orden</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="orden" name="orden">
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
                    
                    <!-- Sección de imagen mejorada -->
                    <div class="form-group">
                        <label for="imagen" class="col-sm-3 control-label">Imagen de la Red</label>
                        <div class="col-sm-9">
                            <input type="file" name="imagen" class="form-control" id="imagen" accept="image/*" required>
                            <small class="text-muted">Formatos aceptados: JPG, PNG, JPEG, GIF. Tamaño máximo: 2MB</small>
                            <img id="imagePreview" src="#" alt="Vista previa de la imagen" class="preview-image"/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button id="insert" name="insert" value="insert" type="submit" class="btn btn-success">Agregar Red</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript para vista previa de imagen -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>
        // Vista previa de la imagen antes de subir
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#imagen").change(function() {
            readURL(this);
            
            // Validación básica del archivo
            var file = this.files[0];
            if(file.size > 2000000) {
                alert("El archivo es demasiado grande. El tamaño máximo permitido es 2MB.");
                $(this).val('');
                $('#imagePreview').hide();
            }
        });
        
        function eliminar(id) {
            if(confirm("¿Estás seguro de eliminar esta red?")) {
                var parametros = {
                    "action": "delete",
                    "id": id
                };
                $.ajax({
                    url: 'ajax/upload2.php',
                    data: parametros,
                    beforeSend: function(objeto) {
                        $(".upload-msg2").text('Cargando...');
                    },
                    success: function(data) {
                        $(".upload-msg2").html(data);
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>
</html>