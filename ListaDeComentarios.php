<?php
require_once ("conexion.php");

$idproyecto= $_GET['id'];
$memberId = 1;
$sql = "SELECT comentario.*,megusta_nomegusta.like_unlike FROM comentario LEFT JOIN megusta_nomegusta ON comentario.comentario_id = megusta_nomegusta.comentario_id WHERE comentario.idproyecto=$idproyecto  ORDER BY parent_comentario_id asc, comentario_id desc";
//AND member_id = " . $memberId . "     esto estaba en la consulta y no dejaba mostrar los comentarios de cada proyecto
$result = mysqli_query($conexion, $sql);
$record_set = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($record_set, $row);
}
mysqli_free_result($result);

mysqli_close($conexion);
echo json_encode($record_set);



?>