<?php
$host = "localhost";
$user = "root"; 
$pass = "";      
$dbname = "bdprueba";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("❌ Fallo al conectar a la BD: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa a la base de datos.";
}
?>
