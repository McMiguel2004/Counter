<?php
require_once '../db/conexion.php';  // Cargamos la conexión a la base de datos
require_once '../includes/jwt.php'; // Incluimos las funciones para manejar JWT
require_once '../includes/funciones.php'; // Incluimos las funciones auxiliares

// **CORS y formato de respuesta**: Esto es necesario para permitir solicitudes de diferentes dominios (común en APIs).
header("Access-Control-Allow-Origin: *"); // Permitir solicitudes desde cualquier dominio
header("Content-Type: application/json"); // Definir que la respuesta será en formato JSON

// **Obtenemos los datos enviados por el cliente**: La API recibe datos en formato JSON y los procesa.
$data = json_decode(file_get_contents("php://input")); // Decodificamos el JSON recibido en el cuerpo de la solicitud

// **Verificamos si la solicitud es un POST y contiene los parámetros necesarios**: La API solo acepta solicitudes POST con ciertos datos.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($data->nombre) && isset($data->contrasena)) {
    $nombre = $data->nombre;       // Extraemos el nombre del usuario
    $contrasena = $data->contrasena; // Extraemos la contraseña

    // **Validamos las credenciales del usuario**: Esto es una verificación realizada por la API para saber si el usuario es válido.
    $usuario = verificarUsuario($pdo, $nombre, $contrasena);

    if ($usuario) {
        // Si el usuario es válido, generamos un JWT
        $jwt = generarJWT($usuario['Id'], $usuario['Nombre']);

        // Establecemos el token en una cookie para persistencia
        setcookie("token", $jwt, time() + 3600, "/"); // Cookie válida por 1 hora

        // **La API responde con un JSON**, que es el formato estándar para comunicar los resultados de la solicitud.
        echo json_encode([
            "mensaje" => "Inicio de sesión exitoso",
            "token" => $jwt
        ]);
    } else {
        // Si las credenciales son incorrectas, enviamos un mensaje de error en formato JSON
        echo json_encode([
            "mensaje" => "Credenciales incorrectas"
        ]);
    }
} else {
    // Si faltan parámetros o no es una solicitud POST, enviamos un mensaje de error
    echo json_encode([
        "mensaje" => "Faltan parámetros"
    ]);
}
?>
