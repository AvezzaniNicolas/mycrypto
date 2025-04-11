<?php
session_start();
require '../conexion.php';

// Verificar permisos de administrador
if (!isset($_SESSION['logueado'])) {
    header("Location: ../login.php");
    exit;
}

$idrol_admin = $_SESSION['rol'];
$permiso_admin = false;
$permiso = mysqli_query($conexion, "SELECT p.descripcion FROM permisos AS p, permiso_roles AS pr 
                                  WHERE p.idpermiso = pr.idpermiso AND pr.idrol = $idrol_admin");

while($r = mysqli_fetch_array($permiso)) {
    if ($r['descripcion'] == 'modificar usuario') {
        $permiso_admin = true;
        break;
    }
}

if (!$permiso_admin) {
    header("Location: ../perfil.php");
    exit;
}

// Verificar ID de usuario
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: usuarios.php");
    exit;
}

$userId = intval($_GET['id']);

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevoRol = intval($_POST['nuevo_rol']);
    
    // Validar que el rol exista
    $query_rol = mysqli_query($conexion, "SELECT * FROM roles WHERE idrol = $nuevoRol");
    if (mysqli_num_rows($query_rol) == 0) {
        $_SESSION['error'] = "El rol seleccionado no existe";
        header("Location: cambiar_rol.php?id=$userId");
        exit;
    }
    
    // Eliminar roles actuales
    mysqli_query($conexion, "DELETE FROM rol_usuarios WHERE idusuario = $userId");
    
    // Asignar nuevo rol
    if (mysqli_query($conexion, "INSERT INTO rol_usuarios (idrol, idusuario) VALUES ($nuevoRol, $userId)")) {
        $_SESSION['mensaje'] = "Rol actualizado correctamente";
    } else {
        $_SESSION['error'] = "Error al actualizar el rol: " . mysqli_error($conexion);
    }
    
    header("Location: cambiar_rol.php?id=$userId");
    exit;
}

// Obtener datos del usuario
$userQuery = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario = $userId");
$user = mysqli_fetch_assoc($userQuery);

if (!$user) {
    header("Location: usuarios.php");
    exit;
}

// Obtener rol actual del usuario
$rolActual = 0;
$query_rol_actual = mysqli_query($conexion, "SELECT idrol FROM rol_usuarios WHERE idusuario = $userId");
if ($rol = mysqli_fetch_assoc($query_rol_actual)) {
    $rolActual = $rol['idrol'];
}

// Obtener todos los roles disponibles
$roles = [];
$query_roles = mysqli_query($conexion, "SELECT * FROM roles");
while ($rol = mysqli_fetch_assoc($query_roles)) {
    $roles[] = $rol;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Rol de <?php echo htmlspecialchars($user['nombre']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="css/perfil.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/EstilosAdicionalesABM.css" rel="stylesheet">
</head>
<body>

<?php include("header_admin.php"); ?>

<div class="container">
    <h1>Cambiar Rol de Usuario</h1>
    
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['mensaje']); unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <div class="user-info">
        <h2><?php echo htmlspecialchars($user['nombre'] . ' ' . htmlspecialchars($user['apellido'])); ?></h2>
    </div>
        <p>Usuario: <?php echo htmlspecialchars($user['nickname']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    
    <form method="POST" action="cambiar_rol.php?id=<?php echo $userId; ?>">
        <div class="form-group">
            <label for="nuevo_rol">Seleccionar nuevo rol:</label>
            <select id="nuevo_rol" name="nuevo_rol" required class="form-control">
                <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['idrol']; ?>" <?php echo ($rol['idrol'] == $rolActual) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($rol['descripcion']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cambiar Rol</button>
            <a href="../ver_perfil.php?id=<?php echo $userId; ?>" class="btn btn-default">Cancelar</a>
        </div>
    </form>
</div>
<script src="../js/perfil/main.js"></script>
<script src="../js/perfil/darkModeModule.js"></script>
</body>
</html>