<?php
// Datos de conexión a la base de datos
$host = 'localhost';  // Host de la base de datos (puede ser una IP o 'localhost')
$dbname = 'tienda_juegos';  // Nombre de la base de datos
$username = 'usuario';  // Nombre de usuario para la conexión
$password = 'usuario';  // Contraseña del usuario

try {
    // Crear una nueva instancia de PDO para la conexión
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configurar el modo de error de PDO para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si ocurre un error, se captura y muestra un mensaje
    echo "Error de conexión: " . $e->getMessage();
}
?>
