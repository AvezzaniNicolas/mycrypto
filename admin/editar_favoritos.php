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

// Procesar adición de nueva criptomoneda
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_cripto'])) {
    $crypto_id = mysqli_real_escape_string($conexion, $_POST['crypto_id']);
    $crypto_nombre = mysqli_real_escape_string($conexion, $_POST['crypto_nombre']);
    
    // Verificar si ya existe
    $existe = mysqli_query($conexion, "SELECT * FROM usuario_favoritos 
                                     WHERE idusuario = $userId AND crypto_id = '$crypto_id'");
    
    if (mysqli_num_rows($existe) == 0) {
        $query = "INSERT INTO usuario_favoritos (idusuario, crypto_id, crypto_nombre) 
                 VALUES ($userId, '$crypto_id', '$crypto_nombre')";
        
        if (mysqli_query($conexion, $query)) {
            $_SESSION['mensaje'] = "Criptomoneda agregada correctamente";
        } else {
            $_SESSION['error'] = "Error al agregar: " . mysqli_error($conexion);
        }
    } else {
        $_SESSION['error'] = "Esta criptomoneda ya está en favoritos";
    }
    
    header("Location: editar_favoritos.php?id=$userId");
    exit;
}

// Procesar eliminación de criptomoneda
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_cripto'])) {
    $idfavorito = intval($_POST['idfavorito']);
    
    $query = "DELETE FROM usuario_favoritos WHERE idfavorito = $idfavorito AND idusuario = $userId";
    
    if (mysqli_query($conexion, $query)) {
        $_SESSION['mensaje'] = "Criptomoneda eliminada correctamente";
    } else {
        $_SESSION['error'] = "Error al eliminar: " . mysqli_error($conexion);
    }
    
    header("Location: editar_favoritos.php?id=$userId");
    exit;
}

// Obtener datos del usuario
$userQuery = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusuario = $userId");
$user = mysqli_fetch_assoc($userQuery);

if (!$user) {
    header("Location: usuarios.php");
    exit;
}

// Obtener criptomonedas favoritas del usuario
$favoritos = [];
$query_favoritos = mysqli_query($conexion, "SELECT * FROM usuario_favoritos WHERE idusuario = $userId");
while ($fav = mysqli_fetch_assoc($query_favoritos)) {
    $favoritos[] = $fav;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Favoritos de <?php echo htmlspecialchars($user['nombre']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="css/perfil.css" rel="stylesheet">
    <link href="css/EstilosAdicionalesABM.css" rel="stylesheet">
    <style>
        .cripto-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .cripto-item {
            background:rgb(233, 233, 233);
            padding: 10px 15px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .remove-cripto {
            color: #ff4444;
            cursor: pointer;
            background: none;
            border: none;
        }
        .select2-container {
            width: 100% !important;
            margin-bottom: 15px;
        }
        .select2-results__option {
            display: flex;
            align-items: center;
        }
        .crypto-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<?php include("header_admin.php"); ?>

<div class="container">
    <h1>Editar Criptomonedas Favoritas</h1>
    
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['mensaje']); unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <div class="user-info">
        <h2><?php echo htmlspecialchars($user['nombre'] . ' ' . htmlspecialchars($user['apellido'])); ?></h2>
        <p>Usuario: <?php echo htmlspecialchars($user['nickname']); ?></p>
    </div>
    
    <div class="current-favorites">
        <h3>Criptomonedas favoritas actuales</h3>
        
        <?php if (empty($favoritos)): ?>
            <p>Este usuario no tiene criptomonedas favoritas aún.</p>
        <?php else: ?>
            <div class="cripto-list">
                <?php foreach ($favoritos as $fav): ?>
                    <div class="cripto-item">
                        <span><?php echo htmlspecialchars($fav['crypto_nombre']); ?></span>
                        <form method="POST" action="editar_favoritos.php?id=<?php echo $userId; ?>" style="display: inline;">
                            <input type="hidden" name="idfavorito" value="<?php echo $fav['idfavorito']; ?>">
                            <button type="submit" name="eliminar_cripto" class="remove-cripto" title="Eliminar">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="add-favorite">
        <h3>Agregar nueva criptomoneda</h3>
        
        <form method="POST" action="editar_favoritos.php?id=<?php echo $userId; ?>">
            <div class="form-group">
                <label for="crypto_search">Buscar criptomoneda:</label>
                <select id="crypto_search" class="crypto-select" style="width: 100%"></select>
            </div>
            
            <input type="hidden" id="crypto_id" name="crypto_id" required>
            <input type="hidden" id="crypto_nombre" name="crypto_nombre" required>
            
            <div class="form-actions">
                <button type="submit" name="agregar_cripto" class="btn btn-primary">Agregar</button>
                <a href="../ver_perfil.php?id=<?php echo $userId; ?>" class="btn btn-default">Terminar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Inicializar Select2 con búsqueda en tiempo real
    $('.crypto-select').select2({
        placeholder: "Busque una criptomoneda...",
        minimumInputLength: 2,
        ajax: {
            url: 'https://api.coingecko.com/api/v3/search',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    query: params.term
                };
            },
            processResults: function (data) {
                var results = [];
                $.each(data.coins, function(index, coin) {
                    results.push({
                        id: coin.id,
                        text: coin.name + ' (' + coin.symbol.toUpperCase() + ')',
                        icon: coin.thumb,
                        name: coin.name
                    });
                });
                return {
                    results: results
                };
            },
            cache: true
        },
        templateResult: formatCrypto,
        templateSelection: formatCryptoSelection
    });

    // Cuando se selecciona una criptomoneda
    $('.crypto-select').on('select2:select', function (e) {
        var data = e.params.data;
        $('#crypto_id').val(data.id);
        $('#crypto_nombre').val(data.name);
    });

    // Formatear los resultados de búsqueda
    function formatCrypto(coin) {
        if (!coin.id) { return coin.text; }
        var $result = $(
            '<span><img src="' + coin.icon + '" class="crypto-icon"/> ' + coin.text + '</span>'
        );
        return $result;
    }

    // Formatear la selección actual
    function formatCryptoSelection(coin) {
        if (!coin.id) { return coin.text; }
        return coin.text;
    }
});
</script>
<script src="../js/perfil/main.js"></script>
<script src="../js/perfil/darkModeModule.js"></script>
</body>
</html>