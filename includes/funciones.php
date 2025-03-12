<?php
// **Función para verificar si un usuario existe y sus credenciales son correctas**
function verificarUsuario($pdo, $nombre, $contrasena) {
    // Preparamos una consulta SQL para buscar un usuario por su nombre
    $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE Nombre = :nombre");
    $stmt->bindParam(':nombre', $nombre); // Asignamos el valor del nombre como parámetro
    $stmt->execute(); // Ejecutamos la consulta

    // Recuperamos el resultado (el usuario encontrado, si existe)
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // **Verificamos si el usuario existe y si la contraseña coincide**: Esto es necesario para que la API autentique a los usuarios.
    if ($usuario && password_verify($contrasena, $usuario['Contrasena'])) {
        return $usuario;  // Si es válido, devolvemos los datos del usuario
    }

    // Si no coincide o el usuario no existe, devolvemos `null`
    return null;
}
?>
