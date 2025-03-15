<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php'; // Conectar a la BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signUp'])) {
        // Capturar y limpiar los datos
        $user = trim($_POST['User']);
        $correo = trim($_POST['Correo']);
        $correo_respaldo = trim($_POST['CorreoR']);
        $password = trim($_POST['Password']);
        $cedula = trim($_POST['CedulaIden']);
        // Si el tipo no está definido, asignar "cliente" por defecto
        $tipo = isset($_POST['Tipo']) && in_array($_POST['Tipo'], ['artista', 'cliente']) ? trim($_POST['Tipo']) : 'cliente';

        // $tipo = trim($_POST['Tipo']); // Tipo de usuario: artista o cliente

        // Validaciones básicas
        if (empty($user) || empty($correo) || empty($password) || empty($cedula) || empty($tipo)) {
            die("❌ Error: Todos los campos son obligatorios.");
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || ($correo_respaldo && !filter_var($correo_respaldo, FILTER_VALIDATE_EMAIL))) {
            die("❌ Error: Formato de correo inválido.");
        }

        if (!in_array($tipo, ['artista', 'cliente'])) {
            die("❌ Error: Tipo de usuario inválido.");
        }

        // Verificar si el correo, correo de respaldo o cédula ya existen
        $stmt = $conn->prepare("SELECT id FROM Usuario WHERE correo = ? OR correo_respaldo = ? OR cedula_identidad = ?");
        $stmt->bind_param("sss", $correo, $correo_respaldo, $cedula);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            die("❌ Error: El correo, correo de respaldo o cédula ya están registrados.");
        }
        $stmt->close();

        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insertar nuevo usuario
        $stmt = $conn->prepare("INSERT INTO Usuario (nombre, correo, correo_respaldo, contrasena, cedula_identidad, tipo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $user, $correo, $correo_respaldo, $hashed_password, $cedula, $tipo);

        if ($stmt->execute()) {
            $usuario_id = $stmt->insert_id; // Obtener el ID del usuario insertado

            // Insertar en la tabla correspondiente (Artista o Cliente)
            if ($tipo == "artista") {
                $stmt2 = $conn->prepare("INSERT INTO Artista (usuario_id) VALUES (?)");
            } else {
                $stmt2 = $conn->prepare("INSERT INTO Cliente (usuario_id) VALUES (?)");
            }
            $stmt2->bind_param("i", $usuario_id);
            $stmt2->execute();
            $stmt2->close();

            echo "✅ Usuario registrado correctamente.";
        } else {
            echo "❌ Error al registrar el usuario.";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "❌ Error: Método no permitido.";
}
?>
