<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../db/conexion.php';
require_once __DIR__. '/../../includes/jwt.php'; // Incluir el archivo con la lógica del JWT

// Verificar si el usuario está autenticado mediante el token
$usuarioAutenticado = null;

if (isset($_COOKIE['token'])) {
    $usuarioData = verificarJWT($_COOKIE['token']);
    
    if ($usuarioData) {
        $usuarioId = $usuarioData['id'];

        // Consultar la base de datos para obtener la información del usuario
        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE Id = :id");
        $stmt->bindParam(':id', $usuarioId);
        $stmt->execute();
        $usuarioAutenticado = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Si el usuario no está autenticado, redirigir a la página de inicio de sesión
if (!$usuarioAutenticado) {
    header("Location: /login");
    exit();
}

// Búsqueda por ID (si se ha enviado)
$productoBuscado = null;
$idBusqueda = isset($_POST['buscar_id']) ? $_POST['buscar_id'] : '';

// Si hay una ID de búsqueda, se realiza la búsqueda
if (!empty($idBusqueda)) {
    $stmt = $pdo->prepare("SELECT * FROM Productos WHERE id = :id");
    $stmt->bindParam(':id', $idBusqueda);
    $stmt->execute();
    $productoBuscado = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtener todos los productos si no se busca por ID
if (empty($idBusqueda)) {
    $stmt = $pdo->query("SELECT * FROM Productos");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['buscar_id'])) {
    $idProducto = $_POST['id'];
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : null;
    $precio = !empty($_POST['precio']) ? $_POST['precio'] : null;
    $precision = !empty($_POST['precision']) ? $_POST['precision'] : null;
    $estado = !empty($_POST['estado']) ? $_POST['estado'] : null;

    try {
        // Crear la consulta SQL para actualizar el producto
        $query = "UPDATE Productos SET 
                    Nombre = COALESCE(:nombre, Nombre), 
                    Precio = COALESCE(:precio, Precio), 
                    PrecisionValue = COALESCE(:precision, PrecisionValue), 
                    Estado = COALESCE(:estado, Estado) 
                  WHERE id = :id";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':precision' => $precision,
            ':estado' => $estado,
            ':id' => $idProducto
        ]);

        // Redirigir después de la actualización para evitar el reenvío del formulario
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();  // Detener el script después de redirigir
    } catch (PDOException $e) {
        echo "<h1 class='text-center text-danger'>Error al actualizar el producto: " . $e->getMessage() . "</h1>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/modificar.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Gestión de Productos</h1>

<form method="POST" class="mb-4">
    <div class="input-group">
        <input type="number" name="buscar_id" class="form-control" placeholder="Buscar por ID" value="<?php echo $idBusqueda; ?>" style="color: white; background-color: #444;">
        <button type="submit" class="btn btn-secondary" style="color: white; background-color: #555; border: 1px solid #888;">Buscar</button>
    </div>
</form>

    <?php
    // Mostrar el producto encontrado si existe
    if ($productoBuscado) {
        echo '<h4>Producto encontrado:</h4>';
        echo '<table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Precisión</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';
        
        echo '<tr>
                <form method="POST">
                    <td><input type="text" name="id" value="' . $productoBuscado['id'] . '" readonly class="form-control"></td>
                    <td><input type="text" name="nombre" value="' . $productoBuscado['Nombre'] . '" class="form-control"></td>
                    <td><input type="number" name="precio" value="' . $productoBuscado['Precio'] . '" class="form-control" step="0.01"></td>
                    <td><input type="number" name="precision" value="' . $productoBuscado['PrecisionValue'] . '" class="form-control" step="0.000000000001"></td>
                    <td><input type="text" name="estado" value="' . $productoBuscado['Estado'] . '" class="form-control"></td>
                    <td>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </td>
                </form>
              </tr>';
        echo '</tbody></table>';
    } else {
        // Si no se encuentra el producto, mostramos el mensaje
        if (!empty($idBusqueda)) {
            echo '<p class="text-center text-danger">Producto no encontrado.</p>';
        }

        // Si no se está buscando, mostramos todos los productos
        if (empty($idBusqueda)) {
            if ($productos) {
                echo '<table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Precisión</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';
                
                foreach ($productos as $producto) {
                    echo '<tr>
                            <form method="POST">
                                <td><input type="text" name="id" value="' . $producto['id'] . '" readonly class="form-control"></td>
                                <td><input type="text" name="nombre" value="' . $producto['Nombre'] . '" class="form-control"></td>
                                <td><input type="number" name="precio" value="' . $producto['Precio'] . '" class="form-control" step="0.01"></td>
                                <td><input type="number" name="precision" value="' . $producto['PrecisionValue'] . '" class="form-control" step="0.000000000001"></td>
                                <td><input type="text" name="estado" value="' . $producto['Estado'] . '" class="form-control"></td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </td>
                            </form>
                        </tr>';
                }

                echo '</tbody></table>';
            } else {
                echo '<p class="text-center">No se encontraron productos.</p>';
            }
        }
    }
    ?>

    <div class="text-center mt-5">
        <a href="/" class="btn btn-danger btn-lg">Volver al Inicio</a>
    </div>
</div>

<!-- Incluyendo los scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
