<?php
session_start();
$title="Galería de imágenes";
require ("conexion.php");
$sql = "SELECT * FROM productos_categoria WHERE activo = 1";

$result = mysqli_query($conexion, $sql);
$sql = "SELECT * FROM productos WHERE destacado = 1";

$productos = mysqli_query($conexion, $sql);


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tienda Mycripto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="tienda/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="images/icons/favicon.ico">

    <link rel="stylesheet" href="tienda/css/bootstrap.min.css">
    <link rel="stylesheet" href="tienda/css/templatemo.css">
    <link rel="stylesheet" href="tienda/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="tienda/css/fontawesome.min.css">
    <link href="css/styles.css" rel="stylesheet" />
        
<!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>

<body>
    <?php include 'header.php' ?>
    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>



    <!-- Start Banner Hero -->
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="img\Proyectos2\The-Sandbox.jpg" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left align-self-center">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="img\Proyectos2\Axie-Fondo.jpg" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="img\Proyectos2\alienship.jpg" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <!-- End Banner Hero -->


    <!-- Start Categories of The Month -->
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Categorias de Productos</h1>
            
            </div>
        </div>
        <div class="row">
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
            ?>

            <div class="col-12 col-md-4 p-5 mt-3">
                <a href="#"><img src="<?php echo $row['url']; ?>" class="rounded-circle img-fluid border"></a>
                <h5 class="text-center mt-3 mb-3"><?php echo $row['nombre']; ?></h5>
                <p class="text-center"><a class="btn btn-success" href="shop.php?categoria=<?php echo $row['id']; ?>">Comprar</a></p>
            </div>
            <?php } ?>

        </div>
    </section>
    <!-- End Categories of The Month -->


    <!-- Start Featured Product -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Productos Destacados</h1>
                   
                </div>
            </div>
            <div class="row">
            <?php
                    while ($row = mysqli_fetch_assoc($productos)) {
                ?>
                <div class="col-md-4">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">
                                <img class="card-img rounded-0 img-fluid" src="img/<?php echo $row['imagen']; ?>">
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white mt-2" href="buy.php?producto=<?php echo $row['idproducto']; ?>"><i class="fas fa-cart-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <a href="shop-single.html" class="h3 text-decoration-none"><?php echo $row['nombre_producto']; ?></a>
                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                    <li class="pt-2">
                                        <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                    </li>
                                </ul>
                                <ul class="list-unstyled d-flex justify-content-center mb-1">
                                    <li>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                    </li>
                                </ul>
                                <p class="text-center mb-0">$<?php echo $row['precio']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
        
            </div>
        </div>
    </section>
    <!-- End Featured Product -->

    <?php include 'footer.php' ?>

    <!-- Start Script -->
    <script src="tienda/js/jquery-1.11.0.min.js"></script>
    <script src="tienda/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="tienda/js/bootstrap.bundle.min.js"></script>
    <script src="tienda/js/templatemo.js"></script>
    <script src="tienda/js/custom.js"></script>
    <!-- End Script -->
</body>

</html>