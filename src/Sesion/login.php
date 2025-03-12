<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Incluir los archivos necesarios con rutas absolutas
require_once __DIR__ . '/../../db/conexion.php';
require_once __DIR__ . '/../../includes/jwt.php';
require_once __DIR__ . '/../../includes/funciones.php';

// Comprobar si ya hay un token (usuario autenticado)
if (isset($_COOKIE['token'])) {
    try {
        // Verificar el token
        $usuario = verificarJWT($_COOKIE['token']);

        // Si el token es válido, redirigir a la página principal
        header("Location: /");
        exit();
    } catch (Exception $e) {
        // El token no es válido, mostrar el error y continuar con el login
        $errorToken = "El token de autenticación no es válido. Por favor, inicie sesión nuevamente.";
    }
}

// Si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos enviados desde el formulario
    $nombre = $_POST['nombre'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // Verificar las credenciales del usuario
    $usuario = verificarUsuario($pdo, $nombre, $contrasena);

    if ($usuario) {
        // Si el usuario es válido, generar el JWT
        $jwt = generarJWT($usuario['Id'], $usuario['Nombre']);

        // Establecer el token como cookie (para persistencia)
        setcookie("token", $jwt, time() + 3600, "/");  // Expira en 1 hora

        // Redirigir al usuario a la página principal
        header("Location: /");
        exit();
    } else {
        $errorCredenciales = "Credenciales incorrectas. Por favor, verifique su nombre de usuario y contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">

</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Iniciar sesión</h2>

                    <!-- Mostrar los mensajes de error -->
                    <?php if (isset($errorToken)) { echo '<div class="alert alert-danger">' . $errorToken . '</div>'; } ?>
                    <?php if (isset($errorCredenciales)) { echo '<div class="alert alert-danger">' . $errorCredenciales . '</div>'; } ?>

                    <form method="POST" action="/login">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" style="color: white;" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" style="color: white;" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                    </form>

                    <div class="text-center mt-3">
                        <p>¿No tienes cuenta? <a href="/register">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
