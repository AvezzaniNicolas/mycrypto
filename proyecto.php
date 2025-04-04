<?php session_start();?>

<!DOCTYPE html>

<html>
  <head>
    <title>Proyecto Cyrpto</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="dist/js/bootstrap.min.js"></script> 
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nicepage.css" media="screen">
    <link rel="stylesheet" href="css/Proyectos.css" media="screen">
    <link href="css/styles.css" rel="stylesheet" />

    <!-- Facebook SDK 
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '977872107814579', // Reemplaza 'YOUR_APP_ID' con tu App ID de Facebook
          cookie     : true,
          xfbml      : true,
          version    : 'v12.0'
        });
        FB.AppEvents.logPageView();   
      };
    </script>-->
    
    <style>
      .project-name {
        text-align: center;
        margin-top: 40px;
        color: white;
        font-size: 2rem; /* Ajusta el tamaño según lo necesario */
        font-weight: bold; /* Opcional: hace el texto más grueso */
      }
    </style>
</head>
  <body style='background:#090909'data-home-page="proyecto.php" data-home-page-title="Proyectos" class="u-body u-overlap u-white u-xl-mode" data-lang="es">
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
                        <li class="nav-item"><a class="nav-link" href="perfil.php" > Perfil: <?php echo $nick; ?></a></li>
                        
                        
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
                  <div class="project-name"><?php echo $nombre_proyecto; ?></div>
                    
                  </div>
                </div>
                <div style='background:#090909' class="u-align-left u-container-style u-layout-cell u-right-cell u-size-30 u-white u-layout-cell-3">
                  <div class="u-container-layout u-container-layout-3">
                  <div class="project-name">Version: <?php echo $estado_proyecto; ?></div>
                  <div class="project-name">Tipo: <?php echo $tipo_proyecto; ?></div>
                  <div class="project-name">Moneda: <?php echo $moneda_proyecto; ?></div>
                  <br><br><br>
                  <div style="text-align: center; margin-top: 40px; color: white;"> <?php echo $descripcion_proyecto; ?></div>
                  <div style="text-align: center; margin-top: 40px; color: white;"> Whitepaper: <?php echo $whitepaper_proyecto; ?></div>
                  <div style="text-align: center; margin-top: 40px; color: white;">  Noticias:<?php echo $descripcion2_proyecto; ?></div>
                </div>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      </section>       
    
              </div>
            </div>
          </div>

        <div class="container">
        <div class="comment-form-container">
        <!-- Conteiner de advertencia falta de respeto -->  
        <div class="container" style="text-align: center;"> <h4><?php echo $nombre_proyecto; echo ' le recuerda ser respestuoso con los otros usuarios'; ?></h4></div>
            
    
    </div> 

    <div style="text-align: center;">
  <a href="<?php echo $pagina_proyecto; ?>" class="u-border-none u-btn u-button-style u-palette-3-light-2 u-btn-1">WEB OFICIAL DEL JUEGO</a>
    </div>

<!-- 
    
Caja de comentarios de Facebook 
 
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" 
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0&appId=YOUR_APP_ID&autoLogAppEvents=1" 
        nonce="YOUR_NONCE">
</script>

<div class="fb-comments" data-href="https://yourwebsite.com/proyecto.php?id=<?php echo $idproyecto; ?>" data-width="" data-numposts="5" width="100%"></div>

-->



<!-- Caja de comentarios de Discord -->

<widgetbot
  server="1355896202788470945"
  channel="1355896203987910749"
  width="100%"
  height="600"
></widgetbot>
<script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>

<br> <br> <br>
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


<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</html>