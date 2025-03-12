<?php
// Incluir los archivos necesarios
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir los archivos necesarios con rutas absolutas
require_once __DIR__ . '/../../db/conexion.php';
require_once __DIR__ . '/../../includes/jwt.php';
require_once __DIR__ . '/../../includes/funciones.php';

// Si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos enviados desde el formulario
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];
    $confirmarContrasena = $_POST['confirmar_contrasena'];

    // Validar que las contraseñas coincidan
    if ($contrasena !== $confirmarContrasena) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE Nombre = :nombre");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioExistente) {
            $error = "El usuario ya existe.";
        } else {
            // Cifrar la contraseña antes de almacenarla
            $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

            // Preparar la consulta de inserción
            $sql = "INSERT INTO Usuarios (Nombre, Contrasena) VALUES (:nombre, :contrasena)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':contrasena', $contrasenaHash);

            if ($stmt->execute()) {
                // Redirigir al usuario al login
                header("Location: /login");
                exit();
            } else {
                $error = "Error al crear el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/registrar.css" rel="stylesheet">

</head>
<body class="bg-light">


<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                        <h3 class="card-title text-center mb-4">Crear cuenta</h3>

                        <!-- Mostrar los mensajes de error -->
                        <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>

                        <form method="POST" action="/register">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" style="color: white;" required>
                            </div>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" style="color: white;" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmar_contrasena" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" style="color: white;" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Registrar</button>
                        </form>

                        <div class="mt-3 text-center">
                            <p class="mb-0">¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
