<?php
require ("conexion.php");
$error_messages = [
    3 => "El email ya está registrado. Por favor, utiliza otro.",
    4 => "El formato de email no es válido. Debe ser ejemplo@dominio.com",
    5 => "La contraseña debe tener al menos 8 caracteres.",
    6 => "La contraseña debe contener al menos una letra mayúscula.",
    7 => "La contraseña debe contener al menos un número."
];

$error = isset($_GET['error']) ? (int)$_GET['error'] : 0;
$error_message = isset($error_messages[$error]) ? $error_messages[$error] : '';
?>

<!-- voy a cambiar esto a futuro para que aparezca en cada type submit-->
<?php if ($error_message): ?>
<div class="alert alert-danger">
    <?php echo htmlspecialchars($error_message); ?>
</div>
<?php endif; ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="jquery.min.js"></script>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>       
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
    <style>
		.ocultar {
    display: none;
	}
 
	.mostrar {
    display: block;
	}
	</style>
    
</head>
<body>

<form action="registrar.php" onsubmit="validarcontra(); return false" method="POST">
	<div class="limiter">
	
		<div class="container-login100" style="background:#212529";>
		
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form">
				<div id="msg"></div>
 

				<!-- Mensajes de Verificación -->
				<div id="error" class="alert alert-danger ocultar" role="alert">
					Las Contraseñas no coinciden, vuelve a intentar !
				</div>
				
					<span class="login100-form-title p-b-49">
						Bienvenido!
					</span>
					<?php 
					if (isset($_GET['error'])&& $_GET['error']==3){
						echo 'E-Mail ya existente, por favor use otro';
					}
					?>
					<div class="wrap-input100 validate-input m-b-23" data-validate = "mail is reauired">
						<span class="label-input100">Nickname</span>
						<input class="input100" type="text" name="nick" id="nick" placeholder="Ingrese su nickname">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-23" data-validate = "mail is reauired">
						<span class="label-input100">EMail</span>
						<input class="input100" type="text" name="mail" id="mail" placeholder="Ingrese su email">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
					

					<div class="wrap-input100 validate-input" data-validate="Contraseña is required">
						<span class="label-input100">Contraseña</span>
						<input class="input100" type="password" name="contrasenia" id="contrasenia" placeholder="Ingrese su contraseña">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="wrap-input100 validate-input" data-validate="Contraseña is required">
						<span class="label-input100">Repetir Contraseña</span>
						<input class="input100" type="password" name="contrasenia2" id="contrasenia2" placeholder="Vuelva a ingresar su contraseña">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<br>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="registrar" value="registrar" type="submit"> 
								Registrarse
							</button>
						</div>
					</div>

	</form>
     <form action="registrar.php" method="POST">
					<div class="txt1 text-center p-t-54 p-b-20">
						<span>
							O registrese utilizando
						</span>
					</div>

					<div class="flex-c-m">
						<a href="#" class="login100-social-item bg1">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="login100-social-item bg2">
							<i class="fa fa-twitter"></i>
						</a>

						<a href="#" class="login100-social-item bg3">
							<i class="fa fa-google"></i>
						</a>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	</form>
	
	<script> 

	function validarcontra(){

		contra1 = document.getElementById('contrasenia');
		contra2 = document.getElementById('contrasenia2');



		if (contra1.value != contra2.value) {
 
 		// Si las constraseñas no coinciden mostramos un mensaje
 		document.getElementById("error").classList.add("mostrar");

 		return false;
		}

		else {

		// Si las contraseñas coinciden ocultamos el mensaje de error
		document.getElementById("error").classList.remove("mostrar");

		

		// Desabilitamos el botón de login
		document.getElementById("login").disabled = true;

		// Refrescamos la página (Simulación de envío del formulario)
		setTimeout(function() {
		location.reload();
		}, 3000);

		return true;
		}



	}
	</script>
     <div id="dropDownSelect1"></div>
	


<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->

</body>
</html>