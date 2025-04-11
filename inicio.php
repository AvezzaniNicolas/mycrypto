<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>My Crypto inicio</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--Boostrap Carrousel-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> 
        <link href="css/proyectlist.css" rel="stylesheet">   
        <link href="css/perfil.css" rel="stylesheet">
        <!--Radio-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body id="page-top" >
    
    <?php 
        require ('conexion.php');
        $idusuario =$_SESSION['logueado'];
        $consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario=$idusuario");
        while($respuesta=mysqli_fetch_assoc($consulta)){
        $nick = $respuesta['nickname'];
        $rol = $_SESSION['rol'];
        }
    ?>

    </div>

    <?php include("header_usuario.php"); ?>

<div class="radio-api-player container mt-4 p-3 bg-light rounded">
    <h4 class="text-center mb-3">Selecciona una estación</h4>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <select class="form-select station-select mb-3">
                <option value="" selected disabled>Elige una radio</option>
                <option value="http://stream.laut.fm/rock">🎸 Rock</option>
                <option value="http://stream.laut.fm/pop">🎵 POP</option>
                <option value="https://stream.laut.fm/anime">🇯🇵 Laut.fm Anime Radio</option>
                <!-- Más opciones -->
            </select>
            
            <div class="d-flex align-items-center mb-3">
                <audio controls class="station-player w-100"></audio>
                <button class="btn btn-outline-secondary btn-sm ms-2 volume-control">
                    <i class="bi bi-volume-up"></i>
                </button>
            </div>
            
            <div class="station-info alert alert-info d-none">
                <strong>Reproduciendo:</strong> <span class="station-name"></span>
            </div>
            
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary btn-sm prev-station">Anterior</button>
                <button class="btn btn-danger btn-sm stop-btn">Detener</button>
                <button class="btn btn-primary btn-sm next-station">Siguiente</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.querySelector('.station-select');
    const player = document.querySelector('.station-player');
    const stationInfo = document.querySelector('.station-info');
    const stationName = document.querySelector('.station-name');
    const stopBtn = document.querySelector('.stop-btn');
    const prevBtn = document.querySelector('.prev-station');
    const nextBtn = document.querySelector('.next-station');
    const volumeControl = document.querySelector('.volume-control');
    
    // Configuración inicial
    player.volume = 0.2;
    let stations = Array.from(select.options).filter(opt => opt.value);
    let currentIndex = -1;
    
    // Cambiar estación
    function changeStation(index) {
        if (index >= 0 && index < stations.length) {
            currentIndex = index;
            const station = stations[currentIndex];
            select.value = station.value;
            player.src = station.value;
            stationName.textContent = station.text;
            stationInfo.classList.remove('d-none');
            
            player.play().catch(e => {
                stationInfo.innerHTML = `<strong>Error:</strong> Haz click en play para reproducir. <button class="btn btn-sm btn-warning force-play">Forzar reproducción</button>`;
                
                document.querySelector('.force-play')?.addEventListener('click', () => {
                    player.play();
                });
            });
        }
    }
    
    // Eventos
    select.addEventListener('change', function() {
        if (this.value) {
            currentIndex = stations.findIndex(s => s.value === this.value);
            changeStation(currentIndex);
        }
    });
    
    stopBtn.addEventListener('click', () => {
        player.pause();
        player.currentTime = 0;
        stationInfo.classList.add('d-none');
    });
    
    prevBtn.addEventListener('click', () => {
        changeStation((currentIndex - 1 + stations.length) % stations.length);
    });
    
    nextBtn.addEventListener('click', () => {
        changeStation((currentIndex + 1) % stations.length);
    });
    
    volumeControl.addEventListener('click', () => {
        player.volume = player.volume === 0 ? 0.7 : 0;
        volumeControl.innerHTML = player.volume === 0 ? 
            '<i class="bi bi-volume-mute"></i>' : '<i class="bi bi-volume-up"></i>';
    });
    
    // Manejo de errores
    player.addEventListener('error', () => {
        stationInfo.innerHTML = '<strong>Error:</strong> No se puede conectar a la estación.';
    });
    
    // Teclado
    document.addEventListener('keydown', (e) => {
        if (e.code === 'Space' && !player.paused) {
            player.pause();
        } else if (e.code === 'ArrowLeft') {
            changeStation((currentIndex - 1 + stations.length) % stations.length);
        } else if (e.code === 'ArrowRight') {
            changeStation((currentIndex + 1) % stations.length);
        }
    });
});
</script>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">




</div>


        <!-- Masthead-->
        <header class="masthead">
                <div class="masthead-subheading"></div>
                <div class="masthead-heading text-uppercase"></div>
                
                <!-- CLASS MEASTHEAD ESPACIO DE GIF NO BORRAR -->
            <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
            
        </header>
        <!-- Services-->
        <section class="page-section" >
            <div class="container">
                <div class="text-center">

                   
                   
                </div>

                <div class="row text-center">
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-gamepad fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">CATALOGO DE REDES Y JUEGOS NFT</h4>
                        <p class="text-muted">Ofrecemos un amplio catalogo de Redes y juegos NFT donde se podra descubrir, compartir sus experiencias y debatir el estado actual de cada juego junto a sus noticias del momento.</p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-coins fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">RECOMPENSAS POR INTERACTUAR</h4>
                        <p class="text-muted">Cada usuario que sea activo en nuestro foro, sera recompensado con monedas que podra utilizar para comprar articulos en la tienda y customizar su perfil. Tambien tendra la oportunidad de retirar dichas monedas a cambio de una criptomoneda creada por nosotros.</p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-newspaper fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">ULTIMAS NOTICIAS DEL MUNDO CRIPTO</h4>
                        <p class="text-muted">Manténgase al día de las últimas noticias sobre las criptomonedas y sus principales proyectos, tambien .</p>
                    </div>
                </div>
            </div>
        </section>

        


                    <!-- carrousel-->
        <selection>

        

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="assets/img/axie_inicio.png" alt="First slide">
                            
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="assets/img/thesandbox.png" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="assets/img/embersword.png" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
            </div>
        </selection>

        <!-- Team-->
        <section class="grupo-team" id="grupo-team">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Nuestro Grupo</h2>
                    
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="assets/img/fotos_equipo/profilepicturev2.jpg" alt="..." />
                            <h4>Nicolas Avezzani</h4>
                            <p class="text-muted">Desarrollador</p>
                            <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Parveen Anand Twitter Profile"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Parveen Anand Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Parveen Anand LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="assets/img/fotos_equipo/profilepicturev2 (1).jpg" alt="..." />
                            <h4>Nicolas Zoppi</h4>
                            <p class="text-muted">Desarrollador</p>
                            <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Diana Petersen Twitter Profile"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Diana Petersen Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Diana Petersen LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="assets/img/fotos_equipo/228c4df9-09f7-4f6e-979f-7975b6215b25.jpg" alt="..." />
                            <h4>Brian Garcia</h4>
                            <p class="text-muted">Desarrollador</p>
                            <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Larry Parker Twitter Profile"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Larry Parker Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Larry Parker LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>


        <script>
             // Modo oscuro mejorado
    document.addEventListener('DOMContentLoaded', function() {
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const body = document.body;
        
        // Verificar preferencias del sistema
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Función para aplicar modo oscuro
        function applyDarkMode(enable) {
            if (enable) {
                body.classList.add('dark-mode');
                if(darkModeToggle) darkModeToggle.checked = true;
            } else {
                body.classList.remove('dark-mode');
                if(darkModeToggle) darkModeToggle.checked = false;
            }
        }
        
        // Cargar estado guardado o preferencia del sistema
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode === 'enabled' || (savedMode === null && prefersDarkScheme.matches)) {
            applyDarkMode(true);
        }
        
        // Escuchar cambios en el toggle
        if(darkModeToggle) {
            darkModeToggle.addEventListener('change', function() {
                if (this.checked) {
                    localStorage.setItem('darkMode', 'enabled');
                    applyDarkMode(true);
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                    applyDarkMode(false);
                }
            });
        }
        
        // Escuchar cambios en las preferencias del sistema
        prefersDarkScheme.addEventListener('change', e => {
            if (localStorage.getItem('darkMode') === null) {
                applyDarkMode(e.matches);
            }
        });
    });
        </script>
    </body>
    <?php include("admin/footer_admin.php"); ?>
</html>