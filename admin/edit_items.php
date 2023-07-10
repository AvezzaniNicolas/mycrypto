<?php
session_start();
$title="Editar Item";
/* Llamar la Cadena de Conexion*/ 
include ("../conexion.php");
$SELECT=mysqli_query($conexion, "SELECT * FROM estados");


$iditem=$_GET['id'];
$sql=mysqli_query($conexion,"SELECT * FROM items WHERE iditem='$iditem' limit 0,1");
$count=mysqli_num_rows($sql);
if ($count==0){
	
}
while($rw=mysqli_fetch_array($sql)){


$nombre_item=$rw['nombre_item'];
$imagen_item=$rw['imagen_item'];
$idestado=$rw['idestado'];
$precio=$rw['precio'];
}
$active_config="active";
$active_banner="active";
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
    <title>Editar Item</title>
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
		  <li><a href="../inicio.php">Inicio</a></li>
		  <li><a href="itemlist.php">Item</a></li>
		  <li class="active">Editar</li>
		</ol>
		 <div class="col-md-7">
		 <h3 ><span class="glyphicon glyphicon-edit"></span> Editar Item</h3>

		 	
		 <form action="abm_items.php" class="form-horizontal"  method="POST" enctype="multipart/form-data">
				 
			 
			  
			  <div class="form-group">
				<label for="nombre_item" class="col-sm-3 control-label">Nombre Item</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="nombre_item" value="<?php echo $nombre_item;?>" required name="nombre_item">
				  
				</div>
			  </div>
			  					  
			  
			  
			  
			  <div class="form-group">
				<label for="idestado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-9">
				<select class="form-control" id="estado" required name="estado">
					<?php
					while($r=mysqli_fetch_array($SELECT)){
					
					?>
					<option value="<?php echo $r['idestado'];?>" <?php  if($idestado==$r['idestado']){ echo'selected';}?>>  <?php echo $r['descripcion'] ?>  </option>
					<?php
					}
				?>
				 </select>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Precio Item</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="precio" value="<?php echo $precio;?>" required name="precio">
				  
				</div>
			  </div>
			 
			  
			  
			  <div class="form-group">
			  <div id='loader'></div>
			  <div class='outer_div'></div>
				<div class="col-sm-offset-3 col-sm-9">
					<input type="text" name="iditem" id="iditem" value="<?php echo $iditem;?>" hidden> 
				  <button name="update" id="update" value="update" type="submit" class="btn btn-success">Actualizar datos</button>
				</div>
			  </div>
			
			
			
			
		</div>
		<div class="col-md-5">
		 <h3 ><span class="glyphicon glyphicon-picture"></span> Imagen</h3>
		 
		 
		 
			<div class="form-group">
				
				<div class="col-sm-12">
				
				 
				 <div class="fileinput fileinput-new" data-provides="fileinput">
								  <div class="fileinput-new thumbnail" style="max-width: 100%;" >
									  <img class="img-rounded" src="../img/item/<?php echo $imagen_item;?>" />
								  </div>
								  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 250px;"></div>
								  <div>
									<span class="btn btn-info btn-file"><span class="fileinput-new">Selecciona una imagen</span>
									<div class="form-row">
                                	<div class="form-group col-md-12">
                                     
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
			function upload_image(){
				$(".upload-msg").text('Cargando...');
				var iditem=$("#iditem").val();
				var inputFileImage = document.getElementById("fileToUpload");
				var file = inputFileImage.files[0];
				var data = new FormData();
				data.append('fileToUpload',file);
				data.append('iditem',iditem);
				
				$.ajax({
					url: "ajax/upload_item.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$(".upload-msg").html(data);
						window.setTimeout(function() {
						$(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();
						});	}, 5000);
					}
				});
				
			}
			
			function eliminar(iditem){
				var parametros = {"action":"delete","iditem":iditem};
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
		$("#editar_item").submit(function(e) {
			
			  $.ajax({
				  url: "ajax/editar_item.php",
				  type: "POST",
				  data: $("#editar_item").serialize(),
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

	