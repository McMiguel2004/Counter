<?php
// Configurar la localización por defecto
$idioma = 'es_ES'; // Idioma por defecto

// Comprobar si el usuario ha seleccionado un idioma a través de cookies o parámetros GET
if (isset($_COOKIE['lang'])) {
    $idioma = $_COOKIE['lang'];
} elseif (isset($_GET['lang'])) {
    // Si el idioma se selecciona a través de la URL (GET)
    $idioma = $_GET['lang'];
    setcookie('lang', $idioma, time() + (86400 * 30), "/"); // Guardar en cookie durante 30 días
}

// Configurar gettext
putenv("LC_ALL={$idioma}");
setlocale(LC_ALL, $idioma);
bindtextdomain("messages", __DIR__ . '/../locales');
bind_textdomain_codeset("messages", 'UTF-8');
textdomain("messages");
?>
