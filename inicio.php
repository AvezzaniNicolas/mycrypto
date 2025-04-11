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

<!-- Widget de Radio Flotante -->
<div class="music-lake-radio-floating">
    <div class="radio-floating-container">
        <div class="radio-header d-flex justify-content-between align-items-center">
            <h4 class="radio-title m-0">MYCRYPTO</h4>
            <div class="live-badge">LIVE</div>
        </div>
        
        <div class="radio-controls">
            <audio id="musicLakePlayerFloating" controls></audio>
            
            <div class="station-selector mt-2">
                <select class="form-select station-select">
                    <option value="" selected disabled>Seleccionar estación</option>
                    <option value="http://stream.laut.fm/rock">🎸 Rock</option>
                    <option value="http://stream.laut.fm/pop">🎵 Pop</option>
                    <option value="https://stream.laut.fm/anime">🇯🇵 Anime</option>
                    <option value="http://stream.laut.fm/chillout">🌿 Chill</option>
                </select>
            </div>
            
            <div class="now-playing mt-2">
                <div class="np-title">Selecciona una estación</div>
            </div>
        </div>
        
        <button class="toggle-radio-btn">
            <i class="fas fa-music"></i>
        </button>
    </div>
</div>

<style>
/* Estilos para el widget flotante */
.music-lake-radio-floating {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    transition: all 0.3s ease;
    width: 300px;
}

.radio-floating-container {
    background: linear-gradient(135deg,rgb(108, 89, 26),rgb(114, 114, 114), #fdbb2d);
    color: white;
    border-radius: 15px;
    padding: 15px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    transform: translateY(calc(100% - 40px));
}

.radio-floating-container.expanded {
    transform: translateY(0);
}

.radio-title {
    font-weight: 700;
    font-size: 16px;
    letter-spacing: 0.5px;
    color: white;
}

.live-badge {
    background-color: #ff0000;
    color: white;
    padding: 2px 8px;
    border-radius: 15px;
    font-size: 10px;
    font-weight: bold;
    text-transform: uppercase;
    animation: pulse 1.5s infinite;
}

.toggle-radio-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(212, 186, 38, 0.2);
    border: none;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
}

.toggle-radio-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.now-playing {
    background-color: rgba(0, 0, 0, 0.3);
    padding: 8px;
    border-radius: 8px;
    text-align: center;
    font-size: 13px;
    margin-top: 8px;
}

.np-title {
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

audio {
    width: 100%;
    border-radius: 10px;
    background-color: rgba(0, 0, 0, 0.3);
}

audio::-webkit-media-controls-panel {
    background-color: rgba(0, 0, 0, 0.3);
}

audio::-webkit-media-controls-play-button,
audio::-webkit-media-controls-mute-button {
    background-color: white;
    border-radius: 50%;
}

/* Modo oscuro */
.dark-mode .radio-floating-container {
    background: linear-gradient(135deg,rgb(182, 156, 40),rgb(0, 0, 0), #9e7a1c);
}

/* Animaciones */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.6; }
    100% { opacity: 1; }
}

/* Responsive */
@media (max-width: 576px) {
    .music-lake-radio-floating {
        width: 260px;
        right: 10px;
        bottom: 10px;
    }
    
    .radio-floating-container {
        padding: 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const player = document.getElementById('musicLakePlayerFloating');
    const stationSelect = document.querySelector('.music-lake-radio-floating .station-select');
    const npTitle = document.querySelector('.music-lake-radio-floating .np-title');
    const radioContainer = document.querySelector('.radio-floating-container');
    const toggleBtn = document.querySelector('.toggle-radio-btn');
    
    // Configuración inicial
    player.volume = 0.2;
    let isExpanded = false;
    
    // Función para alternar visibilidad
    function toggleRadio() {
        isExpanded = !isExpanded;
        if(isExpanded) {
            radioContainer.classList.add('expanded');
            toggleBtn.innerHTML = '<i class="fas fa-times"></i>';
        } else {
            radioContainer.classList.remove('expanded');
            toggleBtn.innerHTML = '<i class="fas fa-music"></i>';
        }
    }
    
    // Evento para el botón de toggle
    toggleBtn.addEventListener('click', toggleRadio);
    
    // Cambiar estación
    stationSelect.addEventListener('change', function() {
        if (this.value) {
            player.src = this.value;
            npTitle.textContent = this.options[this.selectedIndex].text.replace(/^[^\s]+\s/, '');
            
            player.play().catch(e => {
                npTitle.textContent = "Click en play para reproducir";
            });
            
            // Auto-expandir cuando se selecciona una estación
            if(!isExpanded) toggleRadio();
        }
    });
    
    // Manejo de errores
    player.addEventListener('error', () => {
        npTitle.textContent = "Error al conectar";
    });
    
    // Actualizar título cuando se está cargando
    player.addEventListener('waiting', () => {
        npTitle.textContent = "Cargando...";
    });
    
    // Actualizar título cuando está reproduciendo
    player.addEventListener('playing', () => {
        const stationName = stationSelect.options[stationSelect.selectedIndex].text.replace(/^[^\s]+\s/, '');
        npTitle.textContent = stationName;
    });
});
</script>


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