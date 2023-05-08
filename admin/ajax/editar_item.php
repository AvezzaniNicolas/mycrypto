<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["nombre_proyecto"])){
	/* Llamar la Cadena de Conexion*/ 
	include ("../../conexion.php");
	// escaping, additionally removing everything that could be (html/javascript-) code
     $nombre_proyecto = mysqli_real_escape_string($conexion,(strip_tags($_POST['nombre_proyecto'], ENT_QUOTES)));	 
	 $moneda_proyecto = intval($_POST['moneda_proyecto']);
     $precio_proyecto = intval($_POST['precio_proyecto']);
	 $idestado = intval($_POST['idestado']);
	 $sql="UPDATE proyectos SET nombre_proyecto='$nombre_proyecto', moneda_proyecto='$moneda_proyecto', precio_proyecto='$precio_proyecto' , idestado='$idestado' WHERE idproyecto='$idproyecto'";
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