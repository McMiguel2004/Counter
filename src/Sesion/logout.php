<?php
// Iniciar la sesión
session_start();

// Destruir todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Borrar cookies asociadas a la sesión si existen
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Forzar la expiración de cualquier cookie personalizada, por ejemplo, token de autenticación
setcookie('token', '', time() - 3600, '/');

// Enviar cabeceras para desactivar completamente la caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

// Redirigir al usuario a la página de inicio de sesión utilizando el enrutador
header("Location: /login");  // Asegúrate de que esta ruta esté correctamente configurada
exit;
