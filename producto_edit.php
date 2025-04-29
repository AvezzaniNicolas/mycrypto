<?php

require ("conexion.php");
session_start();

// Si viene con id, es edición
$modoEdicion = isset($_GET['id']) && is_numeric($_GET['id']);
$producto = [
    'idproducto' => '',
    'nombre_producto' => '',
    'imagen' => '',
    'precio' => '',
    'idestado' => 1,
    'idcategoria' => '',
    'descripcion' => '',
    'destacado' => false
];

if ($modoEdicion) {
    $id = $_GET['id'];
    $query = mysqli_query($conexion, "SELECT * FROM productos WHERE idproducto = $id");
    if ($query && mysqli_num_rows($query) > 0) {
        $producto = mysqli_fetch_assoc($query);
    } else {
        echo "Producto no encontrado.";
        exit;
    }
}

// Obtener categorías activas
$categorias = mysqli_query($conexion, "SELECT id, nombre FROM productos_categoria WHERE activo = 1");
?>

<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MyCrypto</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--Boostrap Carrousel-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
    </head>
<body class="container mt-5">
<?php include 'header.php' ?>
<h2><?php echo $modoEdicion ? "Editar" : "Crear nuevo"; ?> producto</h2>

<form action="producto_guardar.php" method="POST" enctype="multipart/form-data">
  <?php if ($modoEdicion): ?>
    <input type="hidden" name="idproducto" value="<?php echo $producto['idproducto']; ?>">
  <?php endif; ?>

  <div class="form-group">
    <label>Nombre del producto</label>
    <input type="text" name="nombre_producto" class="form-control" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required>
  </div>

  <div class="form-group">
    <label>Imagen <?php echo $modoEdicion && $producto['imagen'] ? "(actual)" : ""; ?></label><br>
    <?php if ($modoEdicion && $producto['imagen']): ?>
      <img src="img/<?php echo $producto['imagen']; ?>" width="100"><br><br>
    <?php endif; ?>
    <input type="file" name="imagen" class="form-control-file" accept="image/*" >
  </div>

  <div class="form-group">
    <label>Precio</label>
    <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $producto['precio']; ?>" required>
  </div>

  <div class="form-group">
    <label>Descripcion</label>
    <input type="textarea" name="descripcion" class="form-control" value="<?php echo htmlspecialchars($producto['descripcion']); ?>" required>
  </div>

  <div class="form-group">
    <label>Estado</label>
    <select name="idestado" class="form-control" required>
      <option value="1" <?php echo $producto['idestado'] == 1 ? 'selected' : ''; ?>>Habilitado</option>
      <option value="0" <?php echo $producto['idestado'] == 0 ? 'selected' : ''; ?>>Deshabilitado</option>
    </select>
  </div>

  <div class="form-group">
    <label>Destacado</label>
    <select name="destacado" class="form-control" required>
      <option value="1" <?php echo $producto['destacado'] == 1 ? 'selected' : ''; ?>>Destacado</option>
      <option value="0" <?php echo $producto['destacado'] == 0 ? 'selected' : ''; ?>>No Destacado</option>
    </select>
  </div>

  <div class="form-group">
    <label>Categoría</label>
    <select name="idcategoria" class="form-control" required>
      <?php while($cat = mysqli_fetch_assoc($categorias)): ?>
        <option value="<?php echo $cat['id']; ?>" <?php echo $producto['idcategoria'] == $cat['id'] ? 'selected' : ''; ?>>
          <?php echo $cat['nombre']; ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <button type="submit" class="btn btn-<?php echo $modoEdicion ? 'primary' : 'success'; ?>">
    <?php echo $modoEdicion ? 'Guardar Cambios' : 'Crear Producto'; ?>
  </button>
</form>
<?php include 'footer.php' ?>
</body>
</html>
