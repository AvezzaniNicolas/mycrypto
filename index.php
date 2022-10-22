<?php
require ("conexion.php");
session_start();
?>

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
    
    
</head>
<body>

<form action="login.php" method="POST">
	<div class="limiter">
		<div class="container-login100" style="background:#212529";>
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-49">
						Inicio de sesion
					</span>

					<div class="wrap-input100 validate-input m-b-23" data-validate = "mail is reauired">
						<span class="label-input100">eMail</span>
						<input class="input100" type="text" name="mail" id="mail" placeholder="Ingrese su email">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Contraseña is required">
						<span class="label-input100">Contraseña</span>
						<input class="input100" type="password" name="contrasenia" id="contrasenia" placeholder="Ingrese su contraseña">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="text-right p-t-8 p-b-31">
						<a href="#">
							Contraseña olvidada?
						</a>
					</div>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="ingresar" value="ingresar" type="submit"> 
								Iniciar Sesion
							</button>
						</div>
					</div>
	</form>
     
					<div class="txt1 text-center p-t-54 p-b-20">
						<span>
							O ingresa usando
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

					<div class="flex-col-c p-t-155">
						<span class="txt1 p-b-17">
							O tambien podes
						</span>

						<a href="singup.php" class="txt2">
							Registrarse
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

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


<!--<form action="registrar.php" method="POST">
               <div class="form-group" id="user-group">
                    <label for="user">Usuario</label>
                    <input type="text" class="form-control" name="usuario" id="usuario" onkeypress="return check(event)" placeholder="Ingrese su usuario" require>
               </div>
               <div class="form-group" id="password-group">
                   <label for="contra">Contraseña</label>
                   <input type="password" class="form-control" name="contrasenia" id="contrasenia" onkeypress="return check(event)" placeholder="Ingrese su contraseña" require>
               </div>
               <div align="center"><a style="color:black;text-decoration:none" data-toggle="modal" href="#" data-target="#">¿Olvidaste tu contraseña?</a></div>
              <div align="center" class="form-group">
                   <button style="margin-top:7%;width:50%" name="registrar" value="registrar" type="submit" class="btn btn-light">Registrar</button>
              </div>
</form>  
-->

<!--
<form action="login.php" method="POST">
               <div class="form-group" id="user-group">
                    <label for="user">Usuario</label>
                    <input type="text" class="form-control" name="mail" id="mail" onkeypress="return check(event)" placeholder="Ingrese su usuario" require>
               </div>
               <div class="form-group" id="password-group">
                   <label for="contra">Contraseña</label>
                   <input type="password" class="form-control" name="contrasenia" id="contrasenia" onkeypress="return check(event)" placeholder="Ingrese su contraseña" require>
               </div>
               
              <div align="center" class="form-group">
                   <button style="margin-top:7%;width:50%" name="ingresar" value="ingresar" type="submit" class="btn btn-light">Ingresar</button>
              </div>
</form>
-->
</body>
</html>