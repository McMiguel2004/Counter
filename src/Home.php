<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para registrar logs con detalles adicionales
function registrar_log($mensaje, $tipo = 'INFO') {
    $logFile = __DIR__ . '/logs.txt'; // Archivo de logs en la misma carpeta que este script
    $fecha = date('Y-m-d H:i:s');
    $tipos = [
        'INFO' => 'ℹ️',
        'ERROR' => '⚠️',
        'SUCCESS' => '✅'
    ];
    $icono = $tipos[$tipo] ?? '🔍';
    file_put_contents($logFile, "[$fecha] $icono [$tipo] $mensaje\n", FILE_APPEND);
}

// Habilitar la internacionalización con gettext
$idioma = 'es_ES'; // Idioma predeterminado
$idiomaCambiado = false;

// Verificar si el usuario ha seleccionado un idioma diferente
if (isset($_GET['lang'])) {
    $nuevoIdioma = $_GET['lang'];
    
    if ($nuevoIdioma == 'en') {
        $idioma = 'en_US';
        $idiomaCambiado = true;
    } elseif ($nuevoIdioma == 'es') {
        $idioma = 'es_ES';
        $idiomaCambiado = true;
    } else {
        registrar_log("Intento de cambiar a idioma no soportado: '$nuevoIdioma'", 'ERROR');
    }
}

// Registrar si el idioma no cambió
if (!$idiomaCambiado) {
    registrar_log("No se cambió el idioma. Se mantiene '$idioma'.", 'INFO');
}

// Establecer la configuración de idioma
putenv("LC_ALL=$idioma");
setlocale(LC_ALL, $idioma);

// Definir la ubicación de los archivos de traducción
$localesDir = __DIR__ . "/locales";
bindtextdomain("messages", $localesDir);
bind_textdomain_codeset("messages", "UTF-8");
textdomain("messages");

// Verificar si el archivo de traducción existe
$moFile = "$localesDir/$idioma/LC_MESSAGES/messages.mo";
if (!file_exists($moFile)) {
    registrar_log("No se encontró el archivo de traducción en '$moFile'", 'ERROR');
} else {
    registrar_log("Traducción cargada correctamente para '$idioma'", 'SUCCESS');
}

// Incluir archivos necesarios
require_once __DIR__ . '/../db/conexion.php';
require_once 'includes/jwt.php';      // Lógica del JWT
require_once 'includes/funciones.php'; // Funciones de la base de datos

// Comprobar si el usuario está autenticado mediante el token
$usuarioAutenticado = null;
if (isset($_COOKIE['token'])) {
    $usuarioData = verificarJWT($_COOKIE['token']);

    if ($usuarioData) {
        $usuarioId = $usuarioData['id'];
        
        // Consultamos la base de datos para obtener el usuario
        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE Id = :id");
        $stmt->bindParam(':id', $usuarioId);
        $stmt->execute();
        $usuarioAutenticado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioAutenticado) {
            registrar_log("Usuario autenticado: " . $usuarioAutenticado['Nombre'], 'SUCCESS');
        } else {
            registrar_log("Usuario con ID '$usuarioId' no encontrado en la base de datos.", 'ERROR');
        }
    } else {
        registrar_log("Token inválido o expirado.", 'ERROR');
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $idioma; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/Home.css" rel="stylesheet">
    <title><?php echo _('Autenticación'); ?></title>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="navbar-brand">Csell</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo _('Idioma'); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="?lang=es"><?php echo _('Español'); ?></a></li>
                            <li><a class="dropdown-item" href="?lang=en"><?php echo _('English'); ?></a></li>
                        </ul>
                    </li>
                    <?php if ($usuarioAutenticado): ?>
                       
                        <li class="nav-item">
                            <a class="nav-link" href="/productos"><?php echo _('Ver Productos'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/graficas"><?php echo _('Ver Gráficas'); ?></a>
                        </li>
                        <?php if ($usuarioAutenticado['admin'] == 1): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/modificar-productos"><?php echo _('Modificar Productos'); ?></a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="src/Sesion/logout.php"><?php echo _('Cerrar sesión'); ?></a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login"><?php echo _('Iniciar sesión'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register"><?php echo _('Registrar'); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Encabezado de bienvenida -->
    <div class="container">
        <div class="welcome-header text-center">
            <?php if ($usuarioAutenticado): ?>
                <h1><?php echo _('Bienvenido, ') . htmlspecialchars($usuarioAutenticado['Nombre']); ?></h1>
                <!-- Imagen y texto debajo del nombre del usuario -->
                <div class="mt-4">
                    <img src="assets/imagenes_productos/AWP | Dragon Lore.jpg" alt="AWP | Dragon Lore" class="img-fluid rounded" style="max-width: 80%; height: auto;">
                    <p class="mt-3 text-muted text-red-neon" style="font-size: 1.2rem; font-weight: 300;">
                        Somos una empresa dedicada a la venta de skins para el popular juego <strong>Counter-Strike: Global Offensive</strong>. 
                        Ofrecemos una amplia variedad de skins exclusivas y de alta calidad, como el famoso <em>AWP | Dragon Lore</em>, 
                        para que puedas mejorar tu experiencia de juego. ¡Explora nuestra tienda y encuentra el skin perfecto para ti!
                    </p>

                </div>
            <?php else: ?>
                <h1><?php echo _('Bienvenido, visitante'); ?></h1>
            <?php endif; ?>
        </div>

        <?php if (!$usuarioAutenticado): ?>
            <div class="alert alert-warning text-center" role="alert">
                <h4><?php echo _('Por favor inicie sesión para poder acceder a las funcionalidades de la página'); ?></h4>
            </div>
        <?php endif; ?>
    </div>

    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
