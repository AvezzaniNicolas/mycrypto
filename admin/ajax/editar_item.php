<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["nombre_item"])) {
    include("../../conexion.php");    
    $nombre_item = mysqli_real_escape_string($conexion, (strip_tags($_POST['nombre_item'], ENT_QUOTES)));
    $idestado = intval($_POST['idestado']);
    $precio = intval($_POST['precio']);
	$iditem = intval($_POST['iditem']);
    $sql = "UPDATE items SET nombre_item='$nombre_item', idestado='$idestado', precio='$precio' WHERE iditem='$iditem'";
    $query = mysqli_query($conexion, $sql);

    if ($query) {
        $messages[] = "Los datos han sido actualizados satisfactoriamente.";
    } else {
        $errors[] = "Lo siento, algo ha salido mal. Por favor, intenta nuevamente." . mysqli_error($conexion);
    }

	
    if (isset($errors)) {
        ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong>
            <?php
            foreach ($errors as $error) {
                echo $error;
            }
            ?>
        </div>
        <?php
    }
    if (isset($messages)) {
        ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Bien hecho!</strong>
            <?php
            foreach ($messages as $message) {
                echo $message;
            }
            ?>
        </div>
        <?php
    }
}
?>
