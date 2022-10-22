<?php
session_start();
include ("../conexion.php");
$SELECT=mysqli_query($conexion, "SELECT * FROM estados");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <meta name="author" content="">
    <link rel="icon" href="../images/ico/favicon.ico">
    <title>Red</title>
    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
	<link href="css/preview-image.css" rel="stylesheet">
  </head>
  <body>
		<?php include("top_menu.php");?>

    <div class="container">
		
      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
 
	   <ol class="breadcrumb">
		  <li><a href="#">Inicio</a></li>
		  <li><a href="redeslist.php">Redes</a></li>
		  <li class="active">Agregar</li>
		</ol>
		 <div class="col-md-7">
		 <h3 ><span class="glyphicon glyphicon-edit"></span> Agregar Red</h3>
			<form action="abm_red.php" class="form-horizontal"  method="POST" enctype="multipart/form-data">
				 
			 
			  
			  <div class="form-group">
				<label for="nombre_red" class="col-sm-3 control-label">Nombre Red</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="nombre_red"  required name="nombre_red">
				
				</div>
			  </div>
			  		  
			
			  
			  <div class="form-group">
				<label for="orden" class="col-sm-3 control-label">Orden</label>
				<div class="col-sm-9">
				  <input type="number" class="form-control" id="orden" name="orden" >
				</div>
			  </div>
			  
			  
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-9">
				  <select class="form-control" id="estado" required name="estado">
					<?php
					while($idestado=mysqli_fetch_array($SELECT)){
					
					?>
					<option value="<?php echo $idestado['idestado'];?>">  <?php echo $idestado['descripcion'] ?>  </option>
					<?php
					}
				?>
				 </select>
				 
				</div>
				
			  </div>
			  
			
			 
			  
			  
			  <div class="form-group">
			  <div id='loader'></div>
			  <div class='outer_div'></div>
				<div class="col-sm-offset-3 col-sm-9">
				  <button id="insert" name="insert" value="insert" type="submit" class="btn btn-success">Agregar Red</button>
				</div>
			  </div>
			
			
			
			
				</div>
				<div class="col-md-5">
		 		<h3 ><span class="glyphicon glyphicon-picture"></span> Imagen</h3>
		 
		  
		 
			<div class="form-group">
				
				<div class="col-sm-12">
				
				 				
									  
								  
								  
												
								<div class="form-row">
                                	<div class="form-group col-md-8">
                                     
                                     <input type="file" name="imagen" class="form-control" id="imagen" >
                                	</div>

                        		</div>


								  </div>
					</div>
					<div class="upload-msg"></div>
					
				</div>
				
			  </div>
			  
			
			  
			 
			  
			  
		 </form>
		</div>
    </div> 
	</div><!-- /container -->

		
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="js/jasny-bootstrap.min.js"></script>
	
  </body>
</html>
	<script>
			
			
			function eliminar(id){
				var parametros = {"action":"delete","id":id};
						$.ajax({
							url:'ajax/upload2.php',
							data: parametros,
							 beforeSend: function(objeto){
							$(".upload-msg2").text('Cargando...');
						  },
							success:function(data){
								$(".upload-msg2").html(data);
								
							}
						})
					
				}
				
				
				
				
			
	</script>
	<script>
		$("#editar_red").submit(function(e) {
			
			  $.ajax({
				  url: "ajax/editar_red.php",
				  type: "POST",
				  data: $("#editar_red").serialize(),
				   beforeSend: function(objeto){
					$("#loader").html("Cargando...");
				  },
				  success:function(data){
						$(".outer_div").html(data).fadeIn('slow');
						$("#loader").html("");
					}
			});
			 e.preventDefault();
		});
	</script>

	

