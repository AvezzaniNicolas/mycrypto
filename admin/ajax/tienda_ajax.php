<?php
session_start();
/* Llamar la Cadena de Conexion*/ 
include ("../../conexion.php");
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
	//Elimino producto
	if (isset($_REQUEST['idtienda'])){
		$idtienda=intval($_REQUEST['idtienda']);
		if ($delete=mysqli_query($conexion,"DELETE FROM redes WHERE idtienda='$idtienda'")){
			$message= "Datos eliminados satisfactoriamente";
		} else {
			$error= "No se pudo eliminar los datos";
		}
	}
	
	
	$tables="tienda";
	$sWhere=" ";
	$sWhere.=" ";
	
	
	$sWhere.=" ORDER BY orden";
	include 'pagination.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	$per_page = 12; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	
	//Count the total number of row in your table*/
	$count_query   = mysqli_query($conexion,"SELECT count(*) AS numrows FROM $tables  $sWhere  ");
	if ($row= mysqli_fetch_array($count_query))
	{
	$numrows = $row['numrows'];
	}
	else {echo mysqli_error($conexion);}
	$total_pages = ceil($numrows/$per_page);
	$reload = './itemlist.php';
	//main query to fetch the data
	$query = mysqli_query($conexion,"SELECT * FROM  $tables  $sWhere LIMIT $offset,$per_page");
	
	if (isset($message)){
		?>
		<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Aviso!</strong> <?php echo $message;?>
		</div>
		
		<?php
	}
	if (isset($error)){
		?>
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Error!</strong> <?php echo $error;?>
		</div>
		
		<?php
	}
	//loop through fetched data
	if ($numrows>0)	{
		?>
		
		 <div class="row">
			<?php
				while($row = mysqli_fetch_array($query)){
					$imagen_tienda=$row['imagen_tienda'];
					$nombre_tienda=$row['nombre_tienda'];
					$idtienda=$row['idtienda'];
					
					
					?>
					
					  <div class="col-sm-6 col-md-3">
						<div class="thumbnail">
						  
						  <a href="../admin/itemlist.php?id=<?php echo $idtienda;?>" ><img src="../img/tienda/<?php echo $imagen_tienda;?>" alt="no se cargo imagen"></a>
						  <div class="caption">
							<h3><?php echo $nombre_tienda;?></h3>
							
							<?php 
							if(isset($_SESSION['logueado']) && $_SESSION['logueado']>0){

							
							$idrol=$_SESSION['rol'];
							$permiso=mysqli_query($conexion,"SELECT p.descripcion,pr.idpermiso FROM permisos AS p, permiso_roles AS pr WHERE p.idpermiso = pr.idpermiso AND pr.idrol= $idrol;" );

							while($r=mysqli_fetch_array($permiso)){

								$nombre_permiso = $r['descripcion'];
							
							switch($nombre_permiso){

							case 'modificar tienda' : ?> 
								
								<a href="edit_tienda.php?id=<?php echo intval($idtienda);?>" class="btn btn-info" role="button"><i class='glyphicon glyphicon-edit'></i> Editar</a>
									
								<?php break; 
							case 'baja tienda': ?>	
									
									<button type="button" class="btn btn-danger" onclick="eliminar_slide('<?php echo $idtienda;?>');" role="button"><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
										
									<?php break;
							}
							}
							}
							?>

							
							
						  </div>
						</div>
					  </div>
					
					<?php
				}
			?>
		  </div>
		
		<div class="table-pagination text-right">
			
			<?php echo paginate($reload, $page, $total_pages, $adjacents);?>
		</div>
		<?php
	}
}
?>
