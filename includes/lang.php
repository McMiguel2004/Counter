<?php
function cargarTraducciones($idioma) {
    $archivo = __DIR__ . "/../locales/$idioma.json";
    if (file_exists($archivo)) {
        $json = file_get_contents($archivo);
        return json_decode($json, true);
    }
    return [];
}

// Detectar el idioma
$idioma = $_GET['lang'] ?? 'es'; // Predeterminado español
if (!in_array($idioma, ['es', 'en'])) {
    $idioma = 'es'; // Idioma por defecto
}

$traducciones = cargarTraducciones($idioma);

function __(string $clave) {
    global $traducciones;
    return $traducciones[$clave] ?? $clave;
}
?>
