<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Cargamos las dependencias del proyecto (Firebase JWT)
use \Firebase\JWT\JWT; // Importamos la clase JWT
use \Firebase\JWT\Key; // Importamos la clase Key para especificar claves y algoritmos

$key = "csforever";  // Clave secreta para firmar y validar los tokens. 

// **Función para generar un JWT**
function generarJWT($userId, $userName) {
    global $key; // Accedemos a la clave secreta definida globalmente

    // Definimos los datos del payload (contenido del token)
    $issuedAt = time(); // Momento en el que se emite el token
    $expirationTime = $issuedAt + 3600;  // Tiempo de expiración (1 hora)
    $payload = array(
        "iat" => $issuedAt,      // Fecha/hora de emisión
        "exp" => $expirationTime, // Fecha/hora de expiración
        "id" => $userId,         // ID del usuario
        "nombre" => $userName    // Nombre del usuario
    );

    // **Generar el token**: El JWT es lo que se envía y recibe entre el cliente y la API.
    return JWT::encode($payload, $key, 'HS256');
}

// **Función para verificar un JWT**
function verificarJWT($jwt) {
    global $key; // Accedemos a la clave secreta definida globalmente

    try {
        // **Decodificamos y verificamos el token**: Esto es lo que valida que la API sepa que el cliente está autenticado.
        $decoded = JWT::decode($jwt, new Key($key, 'HS256')); // Usamos la clase Key para especificar el algoritmo
        return (array) $decoded;  // Convertimos el objeto decodificado en un arreglo asociativo y lo devolvemos
    } catch (Exception $e) {
        // **Si el token no es válido o ha expirado**, devolvemos `null`, lo que indica que el acceso es denegado.
        return null;
    }
}

?>
