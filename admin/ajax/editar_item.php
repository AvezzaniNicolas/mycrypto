<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["nombre_item"])){
	include ("../../conexion.php");
     $nombre_item = mysqli_real_escape_string($conexion,(strip_tags($_POST['nombre_item'], ENT_QUOTES)));	 
     $precio = intval($_POST['precio']);
	 $idestado = intval($_POST['idestado']);
	 $sql="UPDATE items SET nombre_item='$nombre_item', precio='$precio' , idestado='$idestado' WHERE iditem='$iditem'";
	 $query = mysqli_query($conexion,$sql);
	
	if ($query) {
		$messages[] = "Datos  han sido actualizados satisfactoriamente.";
	} else {
		$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
	}
	
	if (isset($errors)){
			
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
		if (isset($messages)){
			
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