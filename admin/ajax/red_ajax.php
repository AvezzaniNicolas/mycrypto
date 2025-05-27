<?php
session_start();
/* Llamar la Cadena de Conexion*/ 
include ("../../conexion.php");
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

// Verificar rol del usuario (pasado por AJAX o de la sesión)
$idrol = isset($_REQUEST['rol']) ? intval($_REQUEST['rol']) : (isset($_SESSION['rol']) ? $_SESSION['rol'] : 0);

// Condición WHERE según el rol
$where_condition = ($idrol == 1) ? "1=1" : "idestado = 1"; // Admins ven todo, otros solo activos

if($action == 'ajax'){
    // Eliminar red (solo disponible para admins)
    if (isset($_REQUEST['idred'])){
        $idred = intval($_REQUEST['idred']);
        // Verificar permisos antes de eliminar
        if ($idrol == 1) {
            if ($delete = mysqli_query($conexion,"DELETE FROM redes WHERE idred='$idred'")){
                $message = "Datos eliminados satisfactoriamente";
            } else {
                $error = "No se pudo eliminar los datos";
            }
        } else {
            $error = "No tiene permisos para esta acción";
        }
    }
    
    $tables = "redes";
    $sWhere = " WHERE $where_condition "; // Aplicamos la condición de visibilidad
    $sWhere .= " ORDER BY orden";
    
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = 12; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion,"SELECT count(*) AS numrows FROM $tables $sWhere");
    if ($row = mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    } else {
        echo mysqli_error($conexion);
    }
    
    $total_pages = ceil($numrows/$per_page);
    $reload = './productslist.php';
    
    //main query to fetch the data
    $query = mysqli_query($conexion,"SELECT * FROM $tables $sWhere LIMIT $offset,$per_page");
    
    // Mostrar mensajes
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
    
    // Mostrar datos
    if ($numrows > 0) {
        ?>
        <div class="row">
            <?php
            while($row = mysqli_fetch_array($query)){
                $imagen_red = $row['imagen_red'];
                $nombre_red = $row['nombre_red'];
                $idred = $row['idred'];
                $idestado = $row['idestado'];
                
                // Clase CSS adicional para redes deshabilitadas
                $disabled_class = ($idestado == 2) ? 'disabled-network' : '';
                ?>
                
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail <?php echo $disabled_class; ?>">
                        <a href="../admin/proyectoslist.php?id=<?php echo $idred;?>">
                            <img src="../img/Redes/<?php echo $imagen_red;?>" alt="<?php echo htmlspecialchars($nombre_red);?>">
                        </a>
                        <div class="caption">
                            <h3><?php echo htmlspecialchars($nombre_red);?></h3>
                            
                            <?php 
                            if(isset($_SESSION['logueado'])) {
                                $idrol = $_SESSION['rol'];
                                $permiso = mysqli_query($conexion,"SELECT p.descripcion 
                                          FROM permisos p
                                          JOIN permiso_roles pr ON p.idpermiso = pr.idpermiso
                                          WHERE pr.idrol = $idrol 
                                          AND (p.descripcion = 'modificar red' OR p.descripcion = 'baja red')");
                                
                                while($r = mysqli_fetch_array($permiso)) {
                                    switch($r['descripcion']) {
                                        case 'modificar red': ?>
                                            <a href="edit_red.php?id=<?php echo intval($idred);?>" class="btn btn-info" role="button">
                                                <i class='glyphicon glyphicon-edit'></i> Editar
                                            </a>
                                            <?php break;
                                        case 'baja red': ?>
                                            <button type="button" class="btn btn-danger" onclick="eliminar_slide('<?php echo $idred;?>');" role="button">
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
        echo '<div class="alert alert-warning">No se encontraron redes disponibles.</div>';
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

/* Estilo para redes deshabilitadas */
.disabled-network {
  opacity: 0.7;
  position: relative;
}

.disabled-network::after {
  content: "DESHABILITADA";
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