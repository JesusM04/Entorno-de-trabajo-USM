<?php
session_start();  // Iniciar sesión

// Si estás usando una conexión a la base de datos (ejemplo con MySQLi)
if (isset($conexion)) {
    // Si tienes una conexión abierta con la base de datos, la cerramos
    mysqli_close($conexion);
}

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir a la página de logout (por ejemplo, "gracias.html")
header("Location: gracias.html");
exit();
?>
