<?php
// Habilitar errores en el navegador (solo para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Habilitar logs en archivo de errores
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');  // Archivo de log

// Incluir la conexión a la base de datos y la validación JWT
require_once __DIR__ . '/../../db/conexion.php';
require_once __DIR__ . '/../../includes/jwt.php';

// Verificar si el token está presente en las cookies
$usuarioAutenticado = null;
if (isset($_COOKIE['token'])) {
    try {
        // Verificamos y obtenemos los datos del usuario desde el JWT
        $usuarioAutenticado = verificarJWT($_COOKIE['token']);
        error_log("Usuario autenticado: " . json_encode($usuarioAutenticado));  // Log del usuario autenticado
    } catch (Exception $e) {
        // Si el token es inválido, mostrar un mensaje (sin detalles)
        error_log("Error en la validación del JWT: " . $e->getMessage());
        echo json_encode(["error" => "Token inválido o expirado"]);
        exit;  // Detener la ejecución si el token es inválido
    }
} else {
    error_log("Token no encontrado en las cookies.");
    echo json_encode(["error" => "Token no encontrado"]);
    exit;  // Detener la ejecución si no hay token
}

// Verificar si los datos del producto están presentes en la solicitud POST
if (!isset($_POST['nombreProducto'], $_POST['precioProducto'], $_POST['cantidad'])) {
    error_log("Datos faltantes en la solicitud POST: " . json_encode($_POST));  // Log si faltan datos
    echo json_encode(["error" => "Faltan datos en la solicitud"]);
    exit;
}

// Extraer datos del producto
$nombreProducto = $_POST['nombreProducto'];
$precioProducto = $_POST['precioProducto'];
$cantidad = (int)$_POST['cantidad'];  // Asegurarse de que la cantidad es un número entero

// Log de los datos recibidos
error_log("Datos recibidos: nombreProducto=$nombreProducto, precioProducto=$precioProducto, cantidad=$cantidad");

// Realizar la consulta para obtener el producto por nombre o precio
$stmt = $pdo->prepare("SELECT * FROM Productos WHERE Nombre = :nombreProducto OR Precio = :precioProducto LIMIT 1");
$stmt->bindParam(':nombreProducto', $nombreProducto, PDO::PARAM_STR);
$stmt->bindParam(':precioProducto', $precioProducto, PDO::PARAM_STR);
$stmt->execute();
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

// Log de la consulta a la base de datos
if ($producto) {
    error_log("Resultado de la consulta: " . json_encode($producto));
} else {
    error_log("Producto no encontrado: nombreProducto=$nombreProducto, precioProducto=$precioProducto");
}

// Verificar si el producto existe
if (!$producto) {
    echo json_encode(["error" => "Producto no encontrado"]);
    exit;
}

// Producto encontrado, log de éxito
error_log("Producto encontrado: " . json_encode($producto));

// Registrar la compra en la tabla 'Compras'
try {
    // Preparar la inserción en la tabla Compras
    $stmt = $pdo->prepare("INSERT INTO Compras (id_usuario, id_producto, nombre_producto, precio_producto, estado_compra) 
                           VALUES (:id_usuario, :id_producto, :nombre_producto, :precio_producto, 'pendiente')");
    // Asegúrate de que $usuarioAutenticado['Id'] contiene el valor correcto del ID del usuario
    $stmt->execute([
        ':id_usuario' => $usuarioAutenticado['id'],  // Suponiendo que el ID de usuario está disponible en el token
        ':id_producto' => $producto['id'],
        ':nombre_producto' => $producto['Nombre'],
        ':precio_producto' => $producto['Precio']
    ]);

    // Mostrar el mensaje de éxito con formato bonito
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Compra Exitosa</title>
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body {
                font-family: 'Roboto', sans-serif;
                background-color: #1d1f26;  /* Fondo negro */
                color: #fff;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
                overflow: hidden;
            }
            .alert-success {
                background-color: #3a3a3a;
                border-radius: 15px;
                animation: fallBounce 2s ease-in-out;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
                border: 3px solid #ff3b3b;  /* Borde rojo */
            }
            .display-4 {
                font-family: 'Orbitron', sans-serif;
                font-size: 2.5rem;
                color: #ff3b3b;  /* Rojo brillante */
                animation: fadeIn 1s ease-out;
            }
            .btn-danger {
            background-color: #ff5f57; /* Rojo neón */
            color: white;
            font-size: 1.2rem;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            width: 100%;
            box-shadow: 0 0 10px rgba(255, 95, 87, 0.3);
            }
            .btn-danger:hover {
            background-color: #c0392b;
            }
            .lead {
                color: #ff3b3b;  /* Rojo para el texto de abajo */
            }
            @keyframes fallBounce {
                0% {
                    transform: translateY(-100vh);
                    opacity: 0;
                }
                50% {
                    transform: translateY(30vh);
                    opacity: 1;
                }
                70% {
                    transform: translateY(-15vh);
                }
                100% {
                    transform: translateY(0);
                }
            }
            @keyframes fadeIn {
                0% {
                    opacity: 0;
                }
                100% {
                    opacity: 1;
                }
            }
        </style>
        <link href='https://fonts.googleapis.com/css2?family=Orbitron&display=swap' rel='stylesheet'>
    </head>
    <body>
        <div class='alert alert-success text-center'>
            <h2 class='display-4'>¡Compra completada con éxito!</h2>
            <p class='lead'>¡Gracias por comprar en <span class='font-weight-bold'>CSell!</span></p>
            <p class='mt-3'>
                <a href='/productos' class='btn btn-danger btn-lg'>Volver al inicio</a>
            </p>
        </div>
    </body>
    </html>
    ";
} catch (PDOException $e) {
    error_log("Error al registrar la compra: " . $e->getMessage());
    echo json_encode(["error" => "Hubo un error al procesar la compra. Intenta más tarde."]);
    exit;  // Detener la ejecución si ocurre un error en la compra
}
?>
