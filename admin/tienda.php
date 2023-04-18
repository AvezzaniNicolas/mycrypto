<?php
$title="Galería de imágenes";
include ("../conexion.php");
$active_config="active";
$active_banner="active";

session_start();
?>
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
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
  </head>
  <body style="background: #212529;" >
	
	<?php include("top_menu.php");?>
	
    <div class="container">
		
      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">

		 <ol class="breadcrumb">
		  <li><a href="#">Inicio</a></li>
		  <li class="active">Tienda</li>
		</ol>

				<?php 
				if(isset($_SESSION['logueado']) && $_SESSION['logueado']>0){

				
				$idrol=$_SESSION['rol'];
				$permiso=mysqli_query($conexion,"SELECT p.descripcion,pr.idpermiso FROM permisos AS p, permiso_roles AS pr WHERE p.idpermiso = pr.idpermiso AND pr.idrol= $idrol;" );

				while($r=mysqli_fetch_array($permiso)){

					$nombre_permiso = $r['descripcion'];
				
				switch($nombre_permiso){

				case 'alta red' : ?> 
					<div class="row">
			  		<div class="col-xs-12 text-right">
						<a href='add_red.php' class="btn btn-success" ><span class="glyphicon glyphicon-plus"></span> Agregar Red</a>
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
</html>
<script>
	$(document).ready(function(){
		load(1);
	});
	function load(page){
		var parametros = {"action":"ajax","page":page};
		$.ajax({
			url:'./ajax/red_ajax.php',
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
	function eliminar_slide(idred){
		page=1;
		var parametros = {"action":"ajax","page":page,"idred":idred};
		if(confirm('Esta acción  eliminará de forma permanente el elemento \n\n Desea continuar?')){
		$.ajax({
			url:'./ajax/red_ajax.php',
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