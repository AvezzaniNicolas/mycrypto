<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["nombre_red"])){
	/* Llamar la Cadena de Conexion*/ 
	include ("../../conexion.php");
	// escaping, additionally removing everything that could be (html/javascript-) code
     $nombre_red = mysqli_real_escape_string($conexion,(strip_tags($_POST['nombre_red'], ENT_QUOTES)));	 
	 $orden = intval($_POST['orden']);
	 $idestado = intval($_POST['idestado']);
	 $idred=intval($_POST['idred']);
	 $sql="UPDATE redes SET nombre_red='$nombre_red', idestado='$idestado', orden='$orden' WHERE idred='$idred'";
	 $query = mysqli_query($conexion,$sql);
	// if user has been added successfully
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