<?php
session_start();
/* Llamar la Cadena de Conexion*/ 
include ("../../conexion.php");
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

// Verificar rol del usuario para determinar qué proyectos mostrar
$idrol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 0;
$where_condition = ($idrol == 1) ? "1=1" : "idestado = 1"; // Admins ven todo, otros solo activos

if($action == 'ajax'){
    //Elimino producto
    if (isset($_REQUEST['idproyecto'])){
        $id_proyecto=intval($_REQUEST['idproyecto']);
        if ($delete=mysqli_query($conexion,"DELETE FROM proyectos WHERE idproyecto='$id_proyecto'")){
            $message= "Datos eliminados satisfactoriamente";
        } else {
            $error= "No se pudo eliminar los datos";
        }
    }
    
    $tables="proyectos";
    
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = 12; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion,"SELECT count(*) AS numrows FROM $tables WHERE $where_condition");
    if ($row= mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    } else {
        echo mysqli_error($conexion);
    }
    
    $total_pages = ceil($numrows/$per_page);
    $reload = './productslist.php';
    
    //main query to fetch the data
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $idred=intval($_GET['id']);
        $query = mysqli_query($conexion,"SELECT * FROM $tables WHERE idred=$idred AND $where_condition ORDER BY idproyecto DESC LIMIT $offset,$per_page");
    } else {
        $query = mysqli_query($conexion,"SELECT * FROM $tables WHERE $where_condition ORDER BY idproyecto DESC LIMIT $offset,$per_page");
    }
    
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
    if ($numrows>0) {
        ?>
        <div class="row">
            <?php
            while($row = mysqli_fetch_array($query)){
                $imagen_proyecto=$row['imagen_proyecto'];
                $nombre_proyecto=$row['nombre_proyecto'];
                $idproyecto=$row['idproyecto'];
                $idred=$row['idred'];
                $idestado=$row['idestado'];
                
                // Agregar clase CSS adicional para proyectos deshabilitados
                $disabled_class = ($idestado == 2) ? 'disabled-project' : '';
                ?>
                
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail <?php echo $disabled_class; ?>">
                        <a href="../proyecto.php?id=<?php echo $idproyecto;?>" >
                            <img src="../img/Proyectos/<?php echo $imagen_proyecto;?>" alt="<?php echo $nombre_proyecto;?>" >
                        </a>
                        <div class="caption">
                            <h3><?php echo $nombre_proyecto;?></h3>
                            
                            <?php 
                            if(isset($_SESSION['logueado'])) {
                                $idrol=$_SESSION['rol'];
                                $permiso=mysqli_query($conexion,"SELECT p.descripcion FROM permisos p 
                                          JOIN permiso_roles pr ON p.idpermiso = pr.idpermiso 
                                          WHERE pr.idrol = $idrol 
                                          AND (p.descripcion = 'modificar proyecto' OR p.descripcion = 'baja proyecto')");
                                
                                while($r=mysqli_fetch_array($permiso)) {
                                    switch($r['descripcion']) {
                                        case 'modificar proyecto': ?>
                                            <a href="edit_proyectos.php?id=<?php echo intval($idproyecto);?>" class="btn btn-info" role="button">
                                                <i class='glyphicon glyphicon-edit'></i> Editar
                                            </a>
                                            <?php break;
                                        case 'baja proyecto': ?>
                                            <button type="button" class="btn btn-danger" onclick="eliminar_slide('<?php echo $idproyecto;?>');" role="button">
                                                <i class='glyphicon glyphicon-trash'></i> Eliminar
                                            </button>
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
    } else {
        echo '<div class="alert alert-warning">No se encontraron proyectos disponibles.</div>';
    }
}
?>

<style>
.thumbnail {
  background-color: #1a1a1a;
  color: #ffffff;
  border: 1px solid #333;
  border-radius: 8px;
  padding: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
}

.thumbnail:hover {
  transform: translateY(-5px);
}

.thumbnail h3 {
  color: #ffffff;
  font-weight: bold;
  text-align: center;
  margin-top: 10px;
}

.thumbnail img {
  border-radius: 8px;
  width: 100%;
  height: auto;
}

/* Estilo para proyectos deshabilitados */
.disabled-project {
  opacity: 0.7;
  position: relative;
}

.disabled-project::after {
  content: "DESHABILITADO";
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  background-color: rgba(255, 0, 0, 0.7);
  color: white;
  text-align: center;
  font-weight: bold;
  padding: 5px;
}

.btn {
  margin: 5px 0;
  width: 100%;
}

.alert {
  margin: 20px;
}
</style>