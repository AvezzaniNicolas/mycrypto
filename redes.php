<?php 
include("conexion.php");
$active1="";
$active2="";
$active3="";
$active4="active";
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Freebie: 4 Bootstrap Gallery Templates</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <link rel="stylesheet" href="css/thumbnail-gallery.css">
	<link rel="stylesheet" href="css/demo.css">

</head>
<body>

<div class="container gallery-container">

    <h1>Bootstrap 3 Gallery</h1>

    <p class="page-description text-center">Thumbnails With Title And Description</p>
    
    <div class="tz-gallery">

        <div class="row">
		<?php
			$nums=1;
			$sql_redes_top=mysqli_query($conexion,"SELECT * FROM redes WHERE idestado=1 ORDER BY orden  ");
			while($redes_top=mysqli_fetch_array($sql_redes_top)){
		?>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a class="lightbox" href="/mycrypto/img/Redes/<?php echo $redes_top['imagen_red'];?>">
                        <img src="/mycrypto/img/Redes/<?php echo $redes_top['imagen_red'];?>" alt="<?php echo $redes_top['nombre_red'];?>">
                    </a>
                    <div class="caption">
                        <h3><?php echo $redes_top['nombre_red'];?></h3>
                        
                    </div>
                </div>
            </div>
		<?php
			if ($nums%3==0){
				echo '<div class="clearfix"></div>';
			}
			$nums++;
			}
		?>	
            
            
        </div>

    </div>

</div>


</body>
</html>