<?php
// FORZAR ERRORES PARA DEPURACIÓN
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "artshop";

try {
    // HABILITAR REPORTES DE ERRORES EN MYSQLI
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // CONECTAR A LA BASE DE DATOS
    $conn = new mysqli($host, $user, $pass, $dbname);

    // FORZAR UTF-8 PARA EVITAR PROBLEMAS DE CODIFICACIÓN
    $conn->set_charset("utf8mb4");

    echo "✅ Conexión exitosa a la base de datos.";
} catch (mysqli_sql_exception $e) {
    // CAPTURAR ERRORES Y MOSTRAR MENSAJE DETALLADO
    die("❌ Error de conexión: " . $e->getMessage());
}
?>
