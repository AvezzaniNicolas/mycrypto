<?php


    require ("conexion.php");
    session_start();
    $idusuario =$_SESSION['logueado'];
    $consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario=$idusuario");

    while($respuesta=mysqli_fetch_assoc($consulta)){

      $nick = $respuesta['nickname'];
      $email = $respuesta['email'];
      $descripcion = $respuesta['descripcion']; 
      $twitter = $respuesta['twitter'];
      $instagram = $respuesta['instagram'];
      $facebook = $respuesta['facebook'];
      $imagen = $respuesta['imagen'];
      
    }

    $sql = "SELECT * FROM inventarios WHERE idusuario = ".$idusuario;
    $result = mysqli_query($conexion, $sql);
    $inventario = mysqli_fetch_assoc($result);
    $banner = '';
    if (!empty($inventario['banner3'])) {
        $banner = $inventario['banner3'];
    } elseif (!empty($inventario['banner2'])) {
        $banner = $inventario['banner2'];
    } elseif (!empty($inventario['banner1'])) {
        $banner = $inventario['banner1'];
    }
    $estiloFondo = "margin-top: 120px;";
    if (!empty($banner)) {
        $estiloFondo .= " background-image: url('img/$banner'); background-size: cover; background-position: center;";
    }
    $marco = '';
    if (!empty($inventario['imagen3'])) {
        $marco = $inventario['imagen3'];
    } elseif (!empty($inventario['imagen2'])) {
        $marco = $inventario['imagen2'];
    } elseif (!empty($inventario['imagen1'])) {
        $marco = $inventario['imagen1'];
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/perfil.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    
</head>
<body>
<?php include 'header.php' ?>
<div class="container" style="<?php echo $estiloFondo; ?>">
    <div class="main-body">    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                  <div style="width: 160px; height: 160px; 
                  <?php if (!empty($marco)): ?>
                      background-image: url('img/<?php echo $marco; ?>');
                  <?php endif; ?>
                  background-size: cover; background-position: center; 
                  display: flex; align-items: center; justify-content: center;">
                    
                  <img src="<?php 
                    if (isset($imagen) && $imagen != '') {
                        echo 'img/logos/' . $imagen;
                    } else {
                        echo 'https://bootdey.com/img/Content/avatar/avatar6.png';
                    }
                  ?>" alt="Admin" class="rounded-circle" width="100">
                </div>
                    <div class="mt-3">
                      <div class="mt-3">
                        <h4><?php echo $nick;?></h4>
                        
                        <p class="text-muted font-size-sm"><?php echo $descripcion;?></p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#proyectosFavoritosModal">
                          Proyectos Favoritos
                        </button>
                        <button  onclick="location.href='logout.php'" class="btn btn-primary">Cerrar Sesion</button>
                        <br>
                        <br>
                        <a href="#addEmployeeModal" class="btn btn-primary" data-toggle="modal"><span>Editar Perfil</span></a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inventarioModal">
                          Inventario
                        </button><br>
                        <br>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadImageModal">
                          Subir Imagen de Perfil
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
								
								
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter me-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
                    <a href= <?php echo $twitter;?> class="text-secondary"><?php echo $twitter;?></a>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram me-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
                    <a href= <?php echo $instagram;?> class="text-secondary"><?php echo $instagram;?></a>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook me-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
                    <a href= <?php echo $facebook;?> class="text-secondary"><?php echo $facebook;?></a>
                  </li>
                  
                </ul>
              </div>
            </div>
            
            <div class="col-md-8">
                            
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">nickname</h6>
                      
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $nick;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $email;?>
                    </div>
                  </div>
                  <hr>
                                
                  
                  <div class="row">
                    <div id="addEmployeeModal" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="modificarperfil.php" method="POST">
                            <div class="modal-header">						
                              <h4 class="modal-title">Perfil</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">					
                              <div class="form-group">
                                <label>nickname</label>
                                <input value="<?php echo $nick;?>" type="text" name="nick" id="nick" class="form-control" >
                              </div>
                              <div class="form-group">
                                <label>email</label>
                                <input value="<?php echo $email;?>" type="email"  name="email" id="email" class="form-control" >
                              </div>

                              <div class="form-group">
                                <label>descripcion</label>
                                <input value="<?php echo $descripcion;?>" type="textarea"  name="descripcion" id="descripcion" class="form-control" >
                              </div>

                              <div class="form-group">
                                <label>twitter</label>
                                <input value="<?php echo $twitter;?>" type="text"  name="twitter" id="twitter" class="form-control" placeholder="Ingresar URL completa">
                                
                              </div>
                              
                              <div class="form-group">
                                <label>instagram</label>
                                <input value="<?php echo $instagram;?>" type="text"  name="instagram" id="instagram" class="form-control" placeholder="Ingresar URL completa" >
                              </div>
                              
                              <div class="form-group">
                                <label>facebook</label>
                                <input value="<?php echo $facebook;?>" type="text"  name="facebook" id="facebook" class="form-control" placeholder="Ingresar URL completa">
                              </div>

                            </div>
                            <div class="modal-footer">
                              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                              <input type="submit" class="btn btn-success" value="Guardar" name="Guardar" id="Guardar">
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              

              
              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Info </i>Cryptomonedas</h6>
                      <small>Btc</small>
                      
                        <div ><h4>$20.156</h4></div>
                      
                      <small>Eth</small>
                      <div ><h4>$1.560</h4></div>
                      <small>Cardano</small>
                      <div ><h4>$1.00</h4></div>
                      <small>Axs</small>
                      <div ><h4>$16.00</h4></div>
                      <small>Rose</small>
                      <div ><h4>$0.50</h4></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Info</i>Monedas CryptoJuegos</h6>
                      <small>SLP</small>
                      <div ><h4>$0.005</h4></div>
                      <small>PVU</small>
                      <div ><h4>$0.00001</h4></div>
                      <small>SAND</small>
                      <div ><h4>$0.50</h4></div>
                      <small>MNFT</small>
                      <div ><h4>$0.00054</h4></div>
                      <small>ILV</small>
                      <div ><h4>$74.80</h4></div>
                    </div>
                  </div>
                </div>
              </div>



            </div>
          </div>

        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="proyectosFavoritosModal" tabindex="-1" role="dialog" aria-labelledby="proyectosFavoritosModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="proyectosFavoritosModalLabel">Proyectos Favoritos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Aquí puedes añadir el contenido de la ventana modal -->
        <p>Contenido de los proyectos favoritos...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="inventarioModal" tabindex="-1" role="dialog" aria-labelledby="inventarioModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inventarioModalLabel">Inventario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Aquí puedes añadir el contenido de la ventana modal -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="subir_imagen.php" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadImageModalLabel">Subir Imagen de Perfil</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="file" name="imagen_perfil" accept="image/*" required class="form-control">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Subir</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">

</script>
</body>
</html>
