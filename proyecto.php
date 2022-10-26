<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
  <title>Perfil de Proyecto</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Proyecto, Estado : (proyecto_estado)., Proyecto : (nombre_proyecto)., Caja de comentarios aca, Objetos relacionados">
    <meta name="description" content="">
    <title>Proyectos</title>
    <link rel="stylesheet" href="css/nicepage.css" media="screen">
    <link rel="stylesheet" href="css/Proyectos.css" media="screen">
    <link href="css/styles.css" rel="stylesheet" />
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 4.19.3, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Proyectos">
    <meta property="og:type" content="website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
  <body style='background: #090909'data-home-page="proyecto.php" data-home-page-title="Proyectos" class="u-body u-overlap u-white u-xl-mode" data-lang="es">
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
        $tipo_proyecto=$r['tipo_proyecto'];
        $estado_proyecto=$r['estado_proyecto'];
        $descripcion_proyecto=$r['descripcion_proyecto'];
        $pagina_proyecto=$r['pagina_proyecto'];
        $whitepaper_proyecto=$r['whitepaper_proyecto'];
        $descripcion2_proyecto=$r['descripcion2_proyecto'];
    }

      $idusuario =$_SESSION['logueado'];
      $consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario=$idusuario");

      while($respuesta=mysqli_fetch_assoc($consulta)){

        $nick = $respuesta['nickname'];
        $email = $respuesta['email'];
        $descripcion = $respuesta['descripcion']; 
        $twitter = $respuesta['twitter'];
        $instagram = $respuesta['instagram'];
        $facebook = $respuesta['facebook'];
        
        
      }

      ?>
      
          
    
      <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                
                <a class="navbar-brand"  href="inicio.php"> <img src=" assets/img/sad.png" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../mycrypto/admin/redeslist.php">Redes</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin/proyectoslist.php">Juegos</a></li>
                        <li class="nav-item"><a class="nav-link" href="tienda.php">Tienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://es.cointelegraph.com/tags/games">Noticias</a></li>
                        <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                        <li class="nav-item"><a class="nav-link" href="perfil.php" ><?php echo $nick; ?></a></li>
                        <li class="nav-item"> <a class="nav-link" href="logout.php" >Cerrar Sesion</a></li>
                        
                        
                    </ul>
                </div>
            </div>
        </nav>
              
           
          
        
      </div>
</header>
    <section class="u-clearfix u-section-1" id="sec-54a0">
      <div class="u-clearfix u-gutter-0 u-layout-wrap u-layout-wrap-1">
        <div class="u-gutter-0 u-layout">
          <div class="u-layout-row">
            <div class="u-size-30">
              <div class="u-layout-row">
                <div class="u-container-style u-layout-cell u-left-cell u-size-60 u-layout-cell-1" src="">
                  <div class="u-container-layout u-container-layout-1">
                    <img class="u-image u-image-1" src="./img/Proyectos/<?php echo $imagen_proyecto;?>" alt="..." data-image-width="1080" data-image-height="1080">
                  </div>
                </div>
              </div>
            </div>
            <div class="u-size-30">
              <div class="u-layout-col">
                <div class="u-container-style u-hidden-sm u-hidden-xs u-layout-cell u-right-cell u-size-30 u-layout-cell-2">
                  <div class="u-container-layout">
                  <h2 class="u-text u-text-3" align= 'center'><?php echo $nombre_proyecto;?></h2>
                    
                  </div>
                </div>
                <div style='background: #090909' class="u-align-left u-container-style u-layout-cell u-right-cell u-size-30 u-white u-layout-cell-3">
                  <div class="u-container-layout u-container-layout-3">
                    <h4 class="u-text u-text-2"align= 'left'>ESTADO:   <?php echo $estado_proyecto; ?></h4>
                    
                    <h4  class="u-text u-text-2"align= 'left'>JUEGO DE:   <?php echo $tipo_proyecto; ?></h4>

                    <h4  class="u-text u-text-2"align= 'left'>MONEDA DEL JUEGO:   <?php echo $moneda_proyecto; ?></h4>

                    <p class="u-text u-text-4"align= 'left'><?php echo $descripcion_proyecto; ?></p>

                    <a href="<?php echo $pagina_proyecto; ?>" class="u-border-none u-btn u-button-style u-palette-3-light-2 u-btn-1">WEB OFICIAL DEL JUEGO</a>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section  style='background: #090909' class="u-align-center u-clearfix u-white u-section-2" id="sec-446b">
      <div  class="u-clearfix u-sheet u-sheet-1">
        <div id="carousel-5989" data-interval="5000" data-u-ride="carousel" class="u-carousel u-slider u-slider-1">
          <ol class="u-absolute-hcenter u-carousel-indicators u-carousel-indicators-1">
            <li data-u-target="#carousel-5989" class="u-active u-grey-30 u-shape-circle" data-u-slide-to="0" style="width: 10px; height: 10px;"></li>
            <li data-u-target="#carousel-5989" class="u-grey-30 u-shape-circle" data-u-slide-to="1" style="width: 10px; height: 10px;"></li>
          </ol>
          <div style='background: #090909' class="u-carousel-inner" role="listbox">
            <div style='background: #9e9e9e' class="u-active u-align-center u-carousel-item u-container-style u-slide u-white u-carousel-item-1">
              <div class="u-container-layout u-container-layout-1">
                <!-- <h4 class="u-text u-text-default u-text-1">Whitepaper </h4> -->
                <a href="<?php echo $whitepaper_proyecto; ?>" class="u-large-text u-text u-text-variant u-text-2">WHITEPAPER</a>
              </div>
            </div>
            <div class="u-align-center u-carousel-item u-container-style u-slide">
              <div style='background: #ffecb3' class="u-container-layout u-container-layout-2">
                <h4 class="u-text u-text-3"> Descripcion<br>
                </h4>
                <p class="u-large-text u-text u-text-variant u-text-4"><?php echo $descripcion2_proyecto; ?></p>
              </div>
            </div>
          </div>
          <a class="u-absolute-vcenter u-carousel-control u-carousel-control-prev u-gradient u-hidden-xs u-icon-circle u-spacing-10 u-carousel-control-1" href="#carousel-5989" role="button" data-u-slide="prev">
            <span aria-hidden="true">
              <svg viewBox="0 0 451.847 451.847"><path d="M97.141,225.92c0-8.095,3.091-16.192,9.259-22.366L300.689,9.27c12.359-12.359,32.397-12.359,44.751,0
                    c12.354,12.354,12.354,32.388,0,44.748L173.525,225.92l171.903,171.909c12.354,12.354,12.354,32.391,0,44.744
                    c-12.354,12.365-32.386,12.365-44.745,0l-194.29-194.281C100.226,242.115,97.141,234.018,97.141,225.92z"></path></svg>
                                </span>
                                <span class="sr-only">
                                  <svg viewBox="0 0 451.847 451.847"><path d="M97.141,225.92c0-8.095,3.091-16.192,9.259-22.366L300.689,9.27c12.359-12.359,32.397-12.359,44.751,0
                    c12.354,12.354,12.354,32.388,0,44.748L173.525,225.92l171.903,171.909c12.354,12.354,12.354,32.391,0,44.744
                    c-12.354,12.365-32.386,12.365-44.745,0l-194.29-194.281C100.226,242.115,97.141,234.018,97.141,225.92z"></path></svg>
                                </span>
                              </a>
                              <a class="u-absolute-vcenter u-carousel-control u-carousel-control-next u-gradient u-hidden-xs u-icon-circle u-spacing-10 u-carousel-control-2" href="#carousel-5989" role="button" data-u-slide="next">
                                <span aria-hidden="true">
                                  <svg viewBox="0 0 451.846 451.847"><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744
                    L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284
                    c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z"></path></svg>
                                </span>
                                <span class="sr-only">
                                  <svg viewBox="0 0 451.846 451.847"><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744
                    L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284
                    c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z"></path></svg>
            </span>
            </a>
            </div>
            </div>
     
        <div class="container">
        <div class="comment-form-container">
            <div class="container"> <h4><?php echo $nombre_proyecto;  echo ' le recuerda ser respestuoso con los otros usuarios' ?></h4></div>
            
        </div>
        


        <div class="container">
            <div class="container">
                <div class="panel-body">

                    <!--Inicio elementos contenedor-->

                    <div class="comment-form-container">
                        
                        <form id="frm-comment">
                            
                            <h4 class="nickname"align= 'left' ><?php echo $nick; ?></h4>
                                
                            
                            <div class="input-row">

                                <input type="text" name="name" id="name" value="<?php echo $nick; ?>" hidden>                           
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

    <section class="u-align-center u-clearfix u-image u-shading u-section-4" src="" data-image-width="1280" data-image-height="800" id="sec-e2ec">
      <div class="u-align-center u-clearfix u-sheet u-sheet-1">
        <h2 class="u-text u-text-1">Objetos relacionados</h2>
      </div>
    </section>
    <section class="u-align-center u-clearfix u-section-5" id="sec-e1dd">
      <div class="u-align-left u-clearfix u-sheet u-sheet-1">
        <div class="u-expanded-width u-list u-list-1">
          <div class="u-repeater u-repeater-1">
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-1"><span class="u-icon u-icon-circle u-text-palette-3-base u-icon-1"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 512 512" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-36a5"></use></svg><svg class="u-svg-content" viewBox="0 0 512 512" x="0px" y="0px" id="svg-36a5" style="enable-background:new 0 0 512 512;"><g><g><path d="M478.609,99.726H441.34c4.916-7.78,8.16-16.513,9.085-25.749C453.38,44.46,437.835,18,411.37,6.269    c-24.326-10.783-51.663-6.375-71.348,11.479l-47.06,42.65c-9.165-10.024-22.34-16.324-36.962-16.324    c-14.648,0-27.844,6.32-37.011,16.375l-47.12-42.706C152.152-0.111,124.826-4.502,100.511,6.275    C74.053,18.007,58.505,44.476,61.469,73.992c0.927,9.229,4.169,17.958,9.084,25.734H33.391C14.949,99.726,0,114.676,0,133.117    v50.087c0,9.22,7.475,16.696,16.696,16.696h478.609c9.22,0,16.696-7.475,16.696-16.696v-50.087    C512,114.676,497.051,99.726,478.609,99.726z M205.913,94.161v5.565H127.37c-20.752,0-37.084-19.346-31.901-40.952    c2.283-9.515,9.151-17.626,18.034-21.732c12.198-5.638,25.71-3.828,35.955,5.445l56.469,51.182    C205.924,93.834,205.913,93.996,205.913,94.161z M417.294,69.544c-1.244,17.353-16.919,30.184-34.316,30.184h-76.891v-5.565    c0-0.197-0.012-0.392-0.014-0.589c12.792-11.596,40.543-36.748,55.594-50.391c8.554-7.753,20.523-11.372,31.587-8.072    C409.131,39.847,418.455,53.349,417.294,69.544z"></path>
</g>
</g><g><g><path d="M33.391,233.291v244.87c0,18.442,14.949,33.391,33.391,33.391h155.826V233.291H33.391z"></path>
</g>
</g><g><g><path d="M289.391,233.291v278.261h155.826c18.442,0,33.391-14.949,33.391-33.391v-244.87H289.391z"></path>
</g>
</g></svg>
            
            <!-- ITEMS? FUTURA TIENDA O RELACIONADO AL JUEGO-->
           <section>
          </span>
                <h3 class="u-align-center u-text u-text-default u-text-1"></h3>
                <p class="u-align-center u-text u-text-2"></p>
                
              </div>
            </div>
            <div class="u-align-center u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-2"><span class="u-icon u-icon-circle u-text-palette-3-base u-icon-2"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 511.846 511.846" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-2bb9"></use></svg><svg class="u-svg-content" viewBox="0 0 511.846 511.846" id="svg-2bb9"><g><path d="m225.336 258.021-163.44-88.824c-7.27-3.949-15.855-3.786-22.969.443-7.114 4.228-11.359 11.693-11.359 19.969v206.052c0 8.337 4.502 16.076 11.75 20.197l163.443 92.917c3.603 2.048 7.543 3.071 11.484 3.071 4.016 0 8.031-1.063 11.682-3.188 7.231-4.207 11.548-11.714 11.548-20.081v-210.143c0-8.521-4.65-16.343-12.139-20.413z"></path><path d="m454.621 115.6c-.011-8.7-4.817-16.591-12.54-20.594l-178.226-92.399c-6.748-3.5-14.791-3.474-21.514.065l-175.605 92.399c-7.646 4.025-12.402 11.892-12.413 20.533-.01 8.639 4.727 16.517 12.362 20.559l175.606 92.976c3.4 1.799 7.133 2.699 10.868 2.699 3.689 0 7.379-.878 10.745-2.635l178.23-92.974c7.714-4.024 12.499-11.929 12.487-20.629z"></path><path d="m472.919 169.64c-7.11-4.229-15.699-4.396-22.966-.444l-163.445 88.825c-7.487 4.07-12.137 11.891-12.137 20.412v210.143c0 8.367 4.317 15.874 11.548 20.081 3.651 2.125 7.665 3.187 11.682 3.187 3.94 0 7.882-1.023 11.484-3.07l163.444-92.917c7.248-4.121 11.749-11.86 11.749-20.197v-206.051c0-8.276-4.245-15.741-11.359-19.969z"></path>
          </g></svg>
            
            
          </span>
                <h3 class="u-align-center u-text u-text-default u-text-3"></h3>
                <p class="u-align-center u-text u-text-4"></p>
                
              </div>
            </div>
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-3"><span class="u-icon u-icon-circle u-text-palette-3-base u-icon-3"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 512 512" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-a5cb"></use></svg><svg class="u-svg-content" viewBox="0 0 512 512" x="0px" y="0px" id="svg-a5cb" style="enable-background:new 0 0 512 512;"><g><g><path d="M493.563,431.87l-58.716-125.913c-32.421,47.207-83.042,80.822-141.639,91.015l49.152,105.401    c6.284,13.487,25.732,12.587,30.793-1.341l25.193-69.204l5.192-2.421l69.205,25.193    C486.63,459.696,499.839,445.304,493.563,431.87z"></path>
                </g>
                </g><g><g><path d="M256.001,0C154.815,0,72.485,82.325,72.485,183.516s82.331,183.516,183.516,183.516    c101.186,0,183.516-82.325,183.516-183.516S357.188,0,256.001,0z M345.295,170.032l-32.541,31.722l7.69,44.804    c2.351,13.679-12.062,23.956-24.211,17.585l-40.231-21.148l-40.231,21.147c-12.219,6.416-26.549-3.982-24.211-17.585l7.69-44.804    l-32.541-31.722c-9.89-9.642-4.401-26.473,9.245-28.456l44.977-6.533l20.116-40.753c6.087-12.376,23.819-12.387,29.913,0    l20.116,40.753l44.977,6.533C349.697,143.557,355.185,160.389,345.295,170.032z"></path>
                </g>
                </g><g><g><path d="M77.156,305.957L18.44,431.87c-6.305,13.497,7.023,27.81,20.821,22.727l69.204-25.193l5.192,2.421l25.193,69.205    c5.051,13.899,24.496,14.857,30.793,1.342l49.152-105.401C160.198,386.779,109.578,353.165,77.156,305.957z"></path>
                </g>
                </g></svg>
            
            
          </span>
                <h3 class="u-align-center u-text u-text-default u-text-5"></h3>
                <p class="u-align-center u-text u-text-6"></p>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <style class="u-overlap-style">.u-overlap:not(.u-sticky-scroll) .u-header {
    background-color: #404040 !important
  }</style>
</section> 
</body>

<footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">Copyright &copy; MyCrypto 2022</div>
                    <div class="col-lg-4 my-3 my-lg-0">
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="link-dark text-decoration-none me-3" href="#!">Politica de Privacidad</a>
                        <a class="link-dark text-decoration-none" href="#!">Terminos y Condiciones</a>
                    </div>
                </div>
            </div>
</footer>

</html>