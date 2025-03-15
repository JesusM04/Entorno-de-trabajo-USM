<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Método POST recibido correctamente.";
} else {
    echo "Error: Método no permitido.";
}
?>