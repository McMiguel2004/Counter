<?php
require_once 'includes/jwt.php';

// Verificar si el token de autenticación está presente en las cookies
$usuarioAutenticado = null;
if (isset($_COOKIE['token'])) {
    try {
        $usuarioAutenticado = verificarJWT($_COOKIE['token']);
    } catch (Exception $e) {
        // Manejar token inválido (opcional)
        $usuarioAutenticado = null;
    }
}

// Obtener la ruta actual desde la URL
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($path, '/'); // Eliminar las barras inicial y final

// Routing básico
switch ($path) {
    case '':
    case 'home':
        require_once 'src/Home.php';
        break;

    case 'login':
        require_once 'src/Sesion/login.php';
        break;

    case 'register':
        require_once 'src/Sesion/registrar.php';
        break;

    case 'productos':
        require_once 'src/Productos/productos.php';
        break;


    case 'modificar-productos':
        require_once 'src/Panel/Modificar-productos.php';
        break;

    case 'comprar':
        require_once 'src/Productos/comprar.php';
        break;

    case 'graficas':
        require_once 'src/Graficas/graficas.php';
        break;

    default:
        // Si no se encuentra la ruta, mostrar error 404
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 - Página no encontrada</h1>";
        exit();
}
?>
