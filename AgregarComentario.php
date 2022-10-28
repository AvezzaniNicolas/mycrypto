<?php

require_once ("conexion.php");


$commentId = isset($_POST['comentario_id']) ? $_POST['comentario_id'] : "";
$comment = isset($_POST['comment']) ? $_POST['comment'] : "";
$commentSenderName = isset($_POST['name']) ? $_POST['name'] : "";
$date = date('Y-m-d H:i:s');
$id = $_GET['id'];

$sql = "INSERT INTO comentario (idproyecto,parent_comentario_id,comment,comment_sender_name,date) VALUES ('" . $id . "','" . $commentId . "','" . $comment . "','" . $commentSenderName . "','" . $date . "')";

$result = mysqli_query($conexion, $sql);

if (! $result) {
    $result = mysqli_error($conexion);
}
echo $result;
?>
