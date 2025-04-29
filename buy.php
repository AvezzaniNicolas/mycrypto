<?php
    require ("conexion.php");
    session_start();

    $idproducto = $_REQUEST['producto'];
    $sql = "SELECT * FROM productos WHERE idproducto = ".$idproducto;

    $result = mysqli_query($conexion, $sql);
    $producto = mysqli_fetch_assoc($result);
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

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="tienda/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="tienda/css/slick-theme.css">
    <link href="css/styles.css" rel="stylesheet" />
<!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>

<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:info@company.com">info@company.com</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
                </div>
                <div>
                    <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Top Nav -->

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



    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="img/<?php echo $producto['imagen'] ?>" alt="Card image cap" id="product-detail">
                    </div>
                    <div class="row">
                        <!--Start Controls-->
                    
                        <!--End Controls-->
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2"><?php echo $producto['nombre_producto'] ?></h1>
                            <p class="h3 py-2">$<?php echo $producto['precio'] ?></p>
                            <p class="py-2">
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <span class="list-inline-item text-dark">Rating 4.8 | 36 Comments</span>
                            </p>
                        

                            <h6>Descripcion:</h6>
                            <p><?php echo $producto['descripcion']; ?></p>
                            <ul class="list-inline">
                            
                                
                            </ul>

                           

                            <form action="buy_action.php" method="POST">
                                <input type="hidden" name="producto" value="<?php echo $producto['idproducto'] ?>">
                                <div class="row">
                                    <div class="col-auto">
                                        
                                    </div>
                                    <div class="col-auto">
                                    
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col d-grid">
                                        <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">Comprar</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Close Content -->

    <!-- Start Article -->
    
    <!-- End Article -->


    <?php include 'footer.php' ?>

    <!-- Start Script -->
    <script src="tienda/js/jquery-1.11.0.min.js"></script>
    <script src="tienda/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="tienda/js/bootstrap.bundle.min.js"></script>
    <script src="tienda/js/templatemo.js"></script>
    <script src="tienda/js/custom.js"></script>
    <!-- End Script -->

    <!-- Start Slider Script -->
    <script src="tienda/js/slick.min.js"></script>
    <script>
        $('#carousel-related-product').slick({
            infinite: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 3,
            dots: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                }
            ]
        });
    </script>
    <!-- End Slider Script -->

</body>

</html>