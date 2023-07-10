<?php
session_start();
/* Llamar la Cadena de Conexion*/ 
include ("../../conexion.php");
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {
    // Elimino producto
    if (isset($_REQUEST['iditem'])) {
        $id_item = intval($_REQUEST['iditem']);
        if ($delete = mysqli_query($conexion, "DELETE FROM items WHERE iditem='$id_item'")) {
            $message = "Datos eliminados satisfactoriamente";
        } else {
            $error = "No se pudo eliminar los datos";
        }
    }

    $tables = "items";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 12; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;

    // Count the total number of rows in your table
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $tables ");
    if ($row = mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    } else {
        echo mysqli_error($conexion);
    }
    $total_pages = ceil($numrows / $per_page);
    $reload = './itemlist.php';
    // main query to fetch the data
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $idtienda = $_GET['id'];
        $query = mysqli_query($conexion, "SELECT * FROM  $tables WHERE idtienda='$idtienda' LIMIT $offset,$per_page ");
    } else {
        $query = mysqli_query($conexion, "SELECT * FROM  $tables LIMIT $offset,$per_page ");
    }

    if (isset($message)) {
        ?>
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>Aviso!</strong> <?php echo $message; ?>
        </div>
        <?php
    }
    if (isset($error)) {
        ?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>Error!</strong> <?php echo $error; ?>
        </div>
        <?php
    }
    // loop through fetched data
    if ($numrows > 0) {
        ?>
        <div class="row">
            <?php
            while ($row = mysqli_fetch_array($query)) {
                $imagen_item = $row['imagen_item'];
                $nombre_item = $row['nombre_item'];
                $iditem = $row['iditem'];
                $idtienda = $row['idtienda'];
                $precio_item =$row['precio'];
                ?>
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <a href="#" data-toggle="modal" data-target="#myModal<?php echo $iditem; ?>">
                            <img src="../img/item/<?php echo $imagen_item; ?>" alt="..." style="width: 100%;">
                        </a>
                        <div class="caption">
                            <h3><?php echo $nombre_item; ?></h3>
                            <?php
                            if (isset($_SESSION['logueado']) && $_SESSION['logueado'] > 0) {
                                $idrol = $_SESSION['rol'];
                                $permiso = mysqli_query($conexion, "SELECT p.descripcion,pr.idpermiso FROM permisos AS p, permiso_roles AS pr WHERE p.idpermiso = pr.idpermiso AND pr.idrol= $idrol;");

                                while ($r = mysqli_fetch_array($permiso)) {
                                    $nombre_permiso = $r['descripcion'];
                                    switch ($nombre_permiso) {
                                        case 'modificar item':
                                            ?>
                                            <a href="edit_items.php?id=<?php echo intval($iditem); ?>" class="btn btn-info" role="button"><i class='glyphicon glyphicon-edit'></i> Editar</a>
                                            <?php break;
                                        case 'baja item':
                                            ?>
                                            <button type="button" class="btn btn-danger" onclick="eliminar_slide('<?php echo $iditem; ?>');" role="button"><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
                                            <?php break;
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="myModal<?php echo $iditem; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $nombre_item; ?></h4>
                            </div>
                            <div class="modal-body">
                                <img src="../img/item2/<?php echo $imagen_item; ?>" alt="..." style="width: 100%;">
                                <!-- Resto del contenido del modal -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="agregarBtn">Comprar</button>
                            </div>
                            <div class="modal-footer">
                            <h4 class="modal-title" id="myModalLabel"><?php echo $precio_item; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="table-pagination text-right">
            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
        </div>
        <?php
    }
}
?>

