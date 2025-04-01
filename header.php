<?php 
        require ('conexion.php');
        $idusuario =$_SESSION['logueado'];
        $consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario=$idusuario");
        while($respuesta=mysqli_fetch_assoc($consulta)){
            $nick = $respuesta['nickname'];
        }
        $rol = $_SESSION['rol'];
    ?>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand"  href=""> <img src=" assets/img/sad.png" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../mycrypto/admin/redeslist.php">Redes</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin/proyectoslist.php">Juegos</a></li>
                        <?php 
                            if($rol == 1){
                        ?>
                            <li class="nav-item"><a class="nav-link" href="../mycrypto/productos.php">Productos</a></li>    
                        <?php 
                            }
                        ?>
                        <li class="nav-item"><a class="nav-link" href="../mycrypto/tienda.php">Tienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://es.cointelegraph.com/tags/games">Noticias</a></li>
                        <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                        <li class="nav-item"><a class="nav-link" href="perfil.php" > Perfil: <?php echo $nick; ?></a></li>
                        
                    </ul>
                </div>
            </div>
        </nav>
    