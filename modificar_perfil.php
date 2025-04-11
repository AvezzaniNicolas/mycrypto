<?php
session_start();
require 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['logueado'])) {
    header("Location: login.php");
    exit;
}

// Obtener permisos del usuario
$idrol = $_SESSION['rol'];
$permiso_admin = false;
$permiso = mysqli_query($conexion, "SELECT p.descripcion FROM permisos AS p, permiso_roles AS pr 
                                   WHERE p.idpermiso = pr.idpermiso AND pr.idrol = $idrol");

while($r = mysqli_fetch_array($permiso)) {
    if ($r['descripcion'] == 'modificar usuario') {
        $permiso_admin = true;
        break;
    }
}

if (!$permiso_admin) {
    header("Location: perfil.php");
    exit;
}

// Verificar si se recibió el ID del usuario a modificar
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin/usuarios.php");
    exit;
}

$userId = intval($_GET['id']);

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y sanitizar los datos
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $nickname = mysqli_real_escape_string($conexion, $_POST['nickname']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $idestado = intval($_POST['idestado']);
    
    // Actualizar los datos del usuario
    $query = "UPDATE usuarios SET 
              nombre = '$nombre',
              apellido = '$apellido',
              nickname = '$nickname',
              email = '$email',
              descripcion = '$descripcion',
              idestado = $idestado
              WHERE idusuario = $userId";
    
    if (mysqli_query($conexion, $query)) {
        $_SESSION['mensaje'] = "Perfil actualizado correctamente";
    } else {
        $_SESSION['error'] = "Error al actualizar el perfil: " . mysqli_error($conexion);
    }
    
    // Redirigir para evitar reenvío del formulario
    header("Location: modificar_perfil.php?id=$userId");
    exit;
}

// Obtener datos del usuario a modificar
$userQuery = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario = $userId");
$user = mysqli_fetch_assoc($userQuery);

if (!$user) {
    header("Location: admin/usuarios.php");
    exit;
}

// Obtener lista de estados
$estados = [];
$query_estados = mysqli_query($conexion, "SELECT * FROM estados");
while ($estado = mysqli_fetch_assoc($query_estados)) {
    $estados[] = $estado;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Perfil de <?php echo htmlspecialchars($user['nombre']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="admin/css/perfil.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="admin/css/EstilosAdicionalesABM.css" rel="stylesheet">
</head>
<body>

<?php include("header_usuario.php"); ?>

<div class="container">
    <h1>Modificar Perfil de Usuario</h1>
    
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['mensaje']); unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="modificar_perfil.php?id=<?php echo $userId; ?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($user['apellido']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="nickname">Nickname:</label>
            <input type="text" id="nickname" name="nickname" value="<?php echo htmlspecialchars($user['nickname']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($user['descripcion']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="idestado">Estado:</label>
            <select id="idestado" name="idestado" required>
                <?php foreach ($estados as $estado): ?>
                    <option value="<?php echo $estado['idestado']; ?>" <?php echo ($estado['idestado'] == $user['idestado']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($estado['descripcion']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="ver_perfil.php?id=<?php echo $userId; ?>" class="btn btn-default">Cancelar</a>
        </div>
    </form>
    
    <div class="additional-actions">
        <h3>Acciones adicionales</h3>
        <ul>
            <li><a href="admin/editar_redes.php?id=<?php echo $userId; ?>">Editar redes sociales</a></li>
            <li><a href="admin/editar_favoritos.php?id=<?php echo $userId; ?>">Editar criptomonedas favoritas</a></li>
            <li><a href="admin/cambiar_rol.php?id=<?php echo $userId; ?>">Cambiar rol del usuario</a></li>
        </ul>
    </div>
</div>
<script src="js/perfil/main.js"></script>
<script src="js/perfil/darkModeModule.js"></script>
</body>
</html>