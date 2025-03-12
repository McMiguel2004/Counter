<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../db/conexion.php'; // Ruta corregida

// Cargar la librería Twig
require_once __DIR__ . '/../../vendor/autoload.php'; // Ruta corregida

// Configuración de Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates'); // Ruta corregida
$twig = new \Twig\Environment($loader);

// Verificar si el usuario está autenticado
$usuarioAutenticado = null;
if (isset($_COOKIE['token'])) {
    // Verificar el token
    $usuarioData = verificarJWT($_COOKIE['token']);
    
    if ($usuarioData) {
        // Recuperamos los datos del usuario
        $usuarioId = $usuarioData['id'];
        
        // Consultamos la base de datos para obtener el usuario y verificar su rol
        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE Id = :id");
        $stmt->bindParam(':id', $usuarioId);
        $stmt->execute();
        $usuarioAutenticado = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Si el usuario no está autenticado, redirigir o mostrar error
if (!$usuarioAutenticado) {
    header("Location: /login"); // Redirigir al login
    exit;
}

// Consultas SQL para obtener los datos de los productos
$queryProductos = "SELECT * FROM Productos"; // Obtener todos los productos

// Ejecutar la consulta y obtener los resultados
$stmtProductos = $pdo->query($queryProductos);

// Obtener los datos de la tabla Productos
$productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

// Ordenar los productos por precio de mayor a menor
usort($productos, function($a, $b) {
    return $b['Precio'] - $a['Precio']; // Comparar precios de mayor a menor
});

// Pasar los datos a la plantilla Twig
foreach ($productos as &$producto) {
    // Determinar la URL basada en el campo 'Pagina' y asignar la categoría
    if ($producto['Pagina'] == 'Buff') {
        $producto['PaginaUrl'] = 'https://buff.market';
        $producto['PaginaNombre'] = 'Buff';
        $producto['Categoria'] = 'buf'; // Agregar categoría 'buf'
    } elseif ($producto['Pagina'] == 'csfloat') {
        $producto['PaginaUrl'] = 'https://csfloat.com/search';
        $producto['PaginaNombre'] = 'CSFloat';
        $producto['Categoria'] = 'csfloat'; // Agregar categoría 'csfloat'
    } else {
        $producto['PaginaUrl'] = '#'; // Enlace por defecto si no es 'Buff' ni 'csfloat'
        $producto['PaginaNombre'] = 'Sin Página';
        $producto['Categoria'] = 'otros'; // Agregar categoría 'otros' si no es 'Buff' ni 'csfloat'
    }

    // Cargar la imagen del producto de manera local desde la carpeta /assets
    $producto['Imagen'] = '/assets/imagenes_productos/' . $producto['Nombre'] . '.jpg'; // Asumiendo que las imágenes tienen la misma base de nombre y extensión jpg
}

// Renderizar la plantilla con los datos
echo $twig->render('productos.twig', [
    'productos' => $productos,
    'usuarioAutenticado' => $usuarioAutenticado
]);
?>
