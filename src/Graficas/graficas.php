<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../db/conexion.php';
require_once __DIR__ . '/../../includes/jwt.php'; // Archivo donde tienes la función verificarJWT()

// Verificar si el usuario está autenticado
$usuarioAutenticado = null;
if (isset($_COOKIE['token'])) {
    // Verificar el token JWT
    $usuarioData = verificarJWT($_COOKIE['token']);
    
    if ($usuarioData) {
        // Obtener datos del usuario desde la base de datos
        $usuarioId = $usuarioData['id'];
        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE Id = :id");
        $stmt->bindParam(':id', $usuarioId);
        $stmt->execute();
        $usuarioAutenticado = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Si no hay usuario autenticado, redirigir a la página de inicio de sesión
if (!$usuarioAutenticado) {
    header("Location: /login");
    exit();
}

// Consulta para obtener el total de compras y el precio promedio por producto
$query = "
    SELECT nombre_producto, COUNT(*) as total_compras, AVG(precio_producto) as promedio_precio
    FROM Compras
    GROUP BY nombre_producto
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Extraemos los datos para el gráfico
$productos = [];
$total_compras = [];
$promedio_precio = [];
foreach ($compras as $compra) {
    $productos[] = $compra['nombre_producto'];
    $total_compras[] = (int) $compra['total_compras'];
    $promedio_precio[] = (float) $compra['promedio_precio'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficas de Compras</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="assets/css/graficas.css" rel="stylesheet">
</head>
<body>

    <h1>Gráfico de Compras por Producto</h1>
    
    <p>
        Este gráfico muestra el número total de compras realizadas por cada producto. 
        Puede ser útil para visualizar qué productos están siendo más adquiridos en la tienda.
    </p>

    <div class="chart-container">
        <canvas id="comprasChart"></canvas>
    </div>

    <div class="text-center mt-5" style="margin-top: 30px;">
        <a href="/" class="btn btn-danger btn-lg">Volver al Inicio</a>
    </div>

    <script>
        const productos = <?php echo json_encode($productos); ?>;
        const totalCompras = <?php echo json_encode($total_compras); ?>;
        const promedioPrecio = <?php echo json_encode($promedio_precio); ?>;

        const ctx = document.getElementById('comprasChart').getContext('2d');
        const comprasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productos,
                datasets: [{
                    label: 'Total de Compras',
                    data: totalCompras,
                    backgroundColor: 'rgba(255, 0, 0, 0.7)',
                    borderColor: 'rgba(255, 0, 0, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 16, family: "'Arial', sans-serif", weight: 'bold', color: '#b0b0b0' },
                            color: '#b0b0b0'
                        },
                        grid: { color: '#b0b0b0' }
                    },
                    x: {
                        ticks: {
                            font: { size: 16, family: "'Arial', sans-serif", weight: 'bold', color: '#b0b0b0' },
                            color: '#b0b0b0'
                        },
                        grid: { color: '#b0b0b0' }
                    }
                },
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(255, 0, 0, 0.8)',
                        bodyFont: { size: 14, family: "'Arial', sans-serif", weight: 'bold', color: '#b0b0b0' },
                        titleFont: { size: 16, family: "'Arial', sans-serif", weight: 'bold', color: '#b0b0b0' },
                        callbacks: {
                            afterBody: function(tooltipItem) {
                                const index = tooltipItem[0].dataIndex;
                                return `💵 Precio Promedio: $${promedioPrecio[index].toFixed(2)}`;
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
