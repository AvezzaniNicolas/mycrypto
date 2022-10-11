<!DOCTYPE html>
<html>

<head>
    <title>Perfil de Proyecto</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <link href="css/estilos.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>


<body>
    

<!--  caja de comentarios para todos los proyectos  -->
    <?php 
    
    require ('conexion.php');

    $idproyecto=$_GET['id'];
    $SELECT=mysqli_query($conexion, "SELECT * FROM proyectos WHERE idproyecto=$idproyecto");
    while($r=mysqli_fetch_array($SELECT)){

        $nombre_proyecto=$r['nombre_proyecto'];
        $precio_proyecto=$r['precio_proyecto'];
        $moneda_proyecto=$r['moneda_proyecto'];
        $imagen_proyecto=$r['imagen_proyecto'];
        $idred=$r['idred'];
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4><?php echo $nombre_proyecto; ?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel-body">

                    <!--Inicio elementos contenedor-->

                    <div class="comment-form-container">
                        
                        <form id="frm-comment">
                            <div class="input-row">
                                <input type="hidden" name="comentario_id" id="commentId" placeholder="Name" /> <input class="input-field" type="text" name="name" id="name" placeholder="Nombres" />
                            </div>
                            <div class="input-row">
                                <textarea class="input-field" type="text" name="comment" id="comment" placeholder="Agregar comentario">  </textarea>
                            </div>
                            <div>
                                <input type="button" class="btn-submit" id="submitButton" value="Publicar Ahora" />
                                <div id="comment-message">Comentario ha sido agregado exitosamente!</div>
                            </div>
                            <div style="clear:both"></div>

                        </form>
                    
                    </div>
                    <div class='scroll'>
                    <div id="output"></div>
                    </div>
                    <script>
                        var totalLikes = 0;
                        var totalUnlikes = 0;

                        function postReply(commentId) {
                            $('#commentId').val(commentId);
                            $("#name").focus();
                        }

                        $("#submitButton").click(function() {
                            $("#comment-message").css('display', 'none');
                            var str = $("#frm-comment").serialize();

                            $.ajax({
                                url: "AgregarComentario.php?id=<?php echo $idproyecto; ?>",
                                data: str,
                                type: 'post',
                                success: function(response) {
                                    var result = eval('(' + response + ')');
                                    if (response) {
                                        $("#comment-message").css('display', 'inline-block');
                                        $("#name").val("");
                                        $("#comment").val("");
                                        $("#commentId").val("");
                                        listComment();
                                    } else {
                                        alert("Failed to add comments !");
                                        return false;
                                    }
                                }
                            });
                        });

                        $(document).ready(function() {
                            listComment();
                        });

                        function listComment() {
                            $.post("ListaDeComentarios.php?id=<?php echo $idproyecto; ?>",
                                function(data) {
                                    var data = JSON.parse(data);

                                    var comments = "";
                                    var replies = "";
                                    var item = "";
                                    var parent = -1;
                                    var results = new Array();

                                    var list = $("<ul class='outer-comment'>");
                                    var item = $("<li>").html(comments);

                                    for (var i = 0;
                                        (i < data.length); i++) {
                                        var commentId = data[i]['comentario_id'];
                                        parent = data[i]['parent_comentario_id'];

                                        var obj = getLikesUnlikes(commentId);

                                        if (parent == "0") {
                                            if (data[i]['like_unlike'] >= 1) {
                                                like_icon = "<img src='img/MeGusta.png'  id='unlike_" + data[i]['comentario_id'] + "' class='like-unlike'  onClick='likeOrDislike(" + data[i]['comentario_id'] + ",-1)' />";
                                                like_icon += "<img style='display:none;' src='img/NoMeGusta.png' id='like_" + data[i]['comentario_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comentario_id'] + ",1)' />";
                                            } else {
                                                like_icon = "<img style='display:none;' src='img/MeGusta.png'  id='unlike_" + data[i]['comentario_id'] + "' class='like-unlike'  onClick='likeOrDislike(" + data[i]['comentario_id'] + ",-1)' />";
                                                like_icon += "<img src='img/NoMeGusta.png' id='like_" + data[i]['comentario_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comentario_id'] + ",1)' />";

                                            }

                                            comments = "\
                                        <div class='comment-row'>\
                                            <div class='comment-info'>\
                                                <span class='commet-row-label'>De</span>\
                                                <span class='posted-by'>" + data[i]['comment_sender_name'] + "</span>\
                                                <span class='commet-row-label'>a las </span> \
                                                <span class='posted-at'>" + data[i]['date'] + "</span>\
                                            </div>\
                                            <div class='comment-text'>" + data[i]['comment'] + "</div>\
                                            <div>\
                                                <a class='btn-reply' onClick='postReply(" + commentId + ")'>Responder</a>\
                                            </div>\
                                            <div class='post-action'>\ " + like_icon + "&nbsp;\
                                                <span id='likes_" + commentId + "'> " + totalLikes + " Me Gusta </span>\
                                            </div>\
                                        </div>";

                                            var item = $("<li>").html(comments);
                                            list.append(item);
                                            var reply_list = $('<ul>');
                                            item.append(reply_list);
                                            listReplies(commentId, data, reply_list);
                                        }
                                    }
                                    $("#output").html(list);
                                });
                        }

                        function listReplies(commentId, data, list) {

                            for (var i = 0;
                                (i < data.length); i++) {

                                var obj = getLikesUnlikes(data[i].comentario_id);
                                if (commentId == data[i].parent_comentario_id) {
                                    if (data[i]['like_unlike'] >= 1) {
                                        like_icon = "<img src='img/MeGusta.png'  id='unlike_" + data[i]['comentario_id'] + "' class='like-unlike'  onClick='likeOrDislike(" + data[i]['comentario_id'] + ",-1)' />";
                                        like_icon += "<img style='display:none;' src='img/NoMeGusta.png' id='like_" + data[i]['comentario_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comentario_id'] + ",1)' />";

                                    } else {
                                        like_icon = "<img style='display:none;' src='img/NoMeGusta.png'  id='unlike_" + data[i]['comentario_id'] + "' class='like-unlike'  onClick='likeOrDislike(" + data[i]['comentario_id'] + ",-1)' />";
                                        like_icon += "<img src='img/NoMeGusta.png' id='like_" + data[i]['comentario_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comentario_id'] + ",1)' />";

                                    }
                                    var comments = "\
                                        <div class='comment-row'>\
                                            <div class='comment-info'>\
                                                <span class='commet-row-label'>De </span>\
                                                <span class='posted-by'>" + data[i]['comment_sender_name'] + "</span>\
                                                <span class='commet-row-label'>a las </span> \
                                                <span class='posted-at'>" + data[i]['date'] + "</span>\
                                            </div>\
                                            <div class='comment-text'>" + data[i]['comment'] + "</div>\
                                            <div>\
                                                <a class='btn-reply' onClick='postReply(" + data[i]['comentario_id'] + ")'>Responder</a>\
                                            </div>\
                                            <div class='post-action'> " + like_icon + "&nbsp;\
                                                <span id='likes_" + data[i]['comentario_id'] + "'> " + totalLikes + " Me Gusta </span>\
                                            </div>\
                                        </div>";

                                    var item = $("<li>").html(comments);
                                    var reply_list = $('<ul>');
                                    list.append(item);
                                    item.append(reply_list);
                                    listReplies(data[i].comentario_id, data, reply_list);
                                }
                            }
                        }

                        function getLikesUnlikes(commentId) {

                            $.ajax({
                                type: 'POST',
                                async: false,
                                url: 'Envio_MeGusta.php',
                                data: {
                                    comentario_id: commentId
                                },
                                success: function(data) {
                                    totalLikes = data;
                                }

                            });

                        }


                        function likeOrDislike(comentario_id, like_unlike) {

                            $.ajax({
                                url: 'MeGusta_NoMeGusta.php',
                                async: false,
                                type: 'post',
                                data: {
                                    comentario_id: comentario_id,
                                    like_unlike: like_unlike
                                },
                                dataType: 'json',
                                success: function(data) {

                                    $("#likes_" + comentario_id).text(data + " likes");

                                    if (like_unlike == 1) {
                                        $("#like_" + comentario_id).css("display", "none");
                                        $("#unlike_" + comentario_id).show();
                                    }

                                    if (like_unlike == -1) {
                                        $("#unlike_" + comentario_id).css("display", "none");
                                        $("#like_" + comentario_id).show();
                                    }

                                },
                                error: function(data) {
                                    alert("error : " + JSON.stringify(data));
                                }
                            });
                        }
                    </script>

                    <!--Fin elementos contenedor-->
                </div>
            </div>
        </div>
    </div>
    

</body>

</html>
