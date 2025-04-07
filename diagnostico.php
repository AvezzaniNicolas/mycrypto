<?php
// diagnostico.php
echo "<h2>Diagnóstico de conexión MySQL</h2>";

// 1. Verificar si MySQL está instalado
echo "<p>1. Extensión MySQLi: " . (extension_loaded('mysqli') ? "✅ Instalada" : "❌ No instalada") . "</p>";

// 2. Intentar conexión básica
echo "<p>2. Intentando conectar con credenciales por defecto (root/sin contraseña)... ";
$test_con = @new mysqli('127.0.0.1', 'root', '');
if ($test_con->connect_error) {
    echo "❌ Falló: " . $test_con->connect_error . "</p>";
} else {
    echo "✅ Éxito!</p>";
    $test_con->close();
}

// 3. Verificar existencia de la base de datos
echo "<p>3. Verificando existencia de la base de datos 'mycrypto'... ";
$test_con = @new mysqli('127.0.0.1', 'root', '');
if ($result = $test_con->query("SHOW DATABASES LIKE 'mycrypto'")) {
    echo $result->num_rows > 0 ? "✅ Existe" : "❌ No existe";
    $result->close();
} else {
    echo "❌ Error al verificar: " . $test_con->error;
}
$test_con->close();

// 4. Verificar privilegios de usuario
echo "<p>4. Verificando usuarios y privilegios... ";
$test_con = @new mysqli('127.0.0.1', 'root', '');
if ($result = $test_con->query("SELECT User, Host FROM mysql.user")) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>Usuario: " . $row['User'] . "@" . $row['Host'] . "</li>";
    }
    echo "</ul>";
    $result->close();
} else {
    echo "❌ Error al verificar usuarios";
}
$test_con->close();
?>