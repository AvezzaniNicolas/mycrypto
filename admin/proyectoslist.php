<?php
$title="Galería de imágenes";
/* Llamar la Cadena de Conexion*/ 
include ("../conexion.php");
$active_config="active";
$active_banner="active";
session_start();

?>

<?php 
require ('../conexion.php');
$idusuario = $_SESSION['logueado'];
$consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario=$idusuario");
while($respuesta = mysqli_fetch_assoc($consulta)) {
    $nick = $respuesta['nickname'];
    $email = $respuesta['email'];
    $nombre = $respuesta['nombre'];
    $apellido = $respuesta['apellido'];
    $foto = $respuesta['foto'] ?? 'default.jpg';
    $rol = $_SESSION['rol'];
}?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/ico/favicon.ico">
    <title><?php echo $title;?></title>
    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> 
    <!-- Custom styles for this template -->
    <link href="css/proyectlist.css" rel="stylesheet">   
	<link href="css/perfil.css" rel="stylesheet">
	
  </head>
  <style>
        /* Estilos adicionales */
  
        .btn {
            background:rgb(212, 175, 55);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn:hover {
            background:rgb(0, 0, 0);
        }
    </style>
  <body style="background: #212529;">

	<!-- Barra de navegación -->
<div class="navbar">
    <a href="../inicio.php" class="active">Inicio</a>
    <a href="https://es.cointelegraph.com/tags/games">NOTICIAS</a>
    <a href="redeslist.php">REDES</a>
    <a href="../tienda.php">TIENDA</a>
	<a href="../perfil.php">PERFIL</a>
    
    <div class="user-info">
        <span>Bienvenido, <?php echo $nick; ?></span>
        <span>(ID ROL:<?php echo $rol; ?>)</span>
        <a href="logout.php" style="color:rgb(0, 0, 0);">Cerrar Sesión</a>
    </div>
</div>
	

			<?php 
					if(isset($_SESSION['logueado']) && $_SESSION['logueado']>0){

					
					$idrol=$_SESSION['rol'];
					$permiso=mysqli_query($conexion,"SELECT p.descripcion,pr.idpermiso FROM permisos AS p, permiso_roles AS pr WHERE p.idpermiso = pr.idpermiso AND pr.idrol= $idrol;" );

					while($r=mysqli_fetch_array($permiso)){

						$nombre_permiso = $r['descripcion'];
					
					switch($nombre_permiso){

					case 'alta proyecto': ?> 
						<div class="row">
			  			<div class="col-xs-12 text-right">
						<a href='add_proyecto.php' class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span> Agregar Proyectos</a>
						</div>
						</div>
						<?php break; 
					}
					}
					}
					?>
			
		  
		  <br>
		  <div id="loader" class="text-center"> <span><img src="./img/ajax-loader.gif"></span></div>
		  <div class="outer_div"></div><!-- Datos ajax Final -->
					  
	  </div>

    </div> <!-- /container -->
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>

<!-- Footer-->
<footer class="footer py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-lg-start">Copyright &copy; MyCrypto 2022</div>
            <div class="col-lg-4 my-3 my-lg-0">
                <a class="btn btn-dark btn-social mx-2" href="https://github.com/AvezzaniNicolas/mycrypto/tree/main" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <br>
            <div class="col-lg-4 text-lg-end">
                <a class="link-dark text-decoration-none me-3" href="#!">Politica de Privacidad</a>
                <a class="link-dark text-decoration-none" href="#!">Terminos y Condiciones</a>
            </div>
        </div>
    </div>
</footer>



</html>
<script>
	$(document).ready(function(){
		load(1);
	});
	function load(page){
		var parametros = {"action":"ajax","page":page};
		$.ajax({
			<?php 
			if(isset($_GET['id'] ) && !empty($_GET['id'])){
			$idred=$_GET['id'];
			?>
			url:'./ajax/proyecto_ajax.php?id=<?php echo $idred;?>',
			<?php }else{ ?>
			url:'./ajax/proyecto_ajax.php',
			 <?php } ?>
			data: parametros,
			 beforeSend: function(objeto){
			$("#loader").html("<img src='../img/ajax-loader.gif'>");
		  },
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$("#loader").html("");
			}
		})
	}
	function eliminar_slide(idproyecto){
		page=1;
		var parametros = {"action":"ajax","page":page,"idproyecto":idproyecto};
		if(confirm('Esta acción  eliminará de forma permanente el banner \n\n Desea continuar?')){
		$.ajax({
			url:'./ajax/proyecto_ajax.php',
			data: parametros,
			 beforeSend: function(objeto){
			$("#loader").html("<img src='../images/ajax-loader.gif'>");
		  },
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$("#loader").html("");
			}
		})
	}
	}
</script>
