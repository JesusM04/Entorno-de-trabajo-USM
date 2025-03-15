<?php
session_start();
include 'connect.php'; // Asegúrate de que el archivo de conexión esté correcto

// Depuración: Verificar los datos que recibimos
echo '<pre>';
var_dump($_POST); // Muestra los datos del formulario enviados
echo '</pre>';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    if (isset($_POST['nombre']) && isset($_POST['password'])) {
        // Recogemos los valores del formulario y los limpiamos
        $nombre = trim($_POST['nombre']);
        $password = trim($_POST['password']);

        // Depuración: Verificar los datos recibidos
        echo '<pre>';
        var_dump($nombre, $password); // Muestra el valor de nombre y contraseña recibidos
        echo '</pre>';

        // Verificar si los campos están vacíos
        if (empty($nombre) || empty($password)) {
            $error = "Por favor ingrese ambos campos.";
            echo $error; // Mostrar el error si algún campo está vacío
        } else {
            // Consulta a la base de datos
            $stmt = $conn->prepare("SELECT id, contrasena FROM Usuario WHERE nombre = ?");
            $stmt->bind_param("s", $nombre); // Asegúrate de usar la variable correcta ($nombre)
            $stmt->execute();
            $stmt->store_result();

            // Depuración: Verificar cuántos resultados encontramos
            echo '<pre>';
            var_dump($stmt->num_rows); // Muestra la cantidad de resultados encontrados
            echo '</pre>';

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($usuario_id, $hashed_password);
                $stmt->fetch();

                // Depuración: Verificar los resultados de la base de datos
                echo '<pre>';
                var_dump($usuario_id, $hashed_password); // Muestra el ID del usuario y la contraseña hasheada
                echo '</pre>';

                // Verificar la contraseña
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $usuario_id; // Guardamos el ID del usuario en la sesión
                    echo "Redirigiendo a user.html..."; // Mensaje de depuración
                    header("Location: ../HTML/user.html");
                    exit();
                } else {
                    $error = "Contraseña incorrecta.";
                    echo $error; // Mostrar mensaje de error si la contraseña no coincide
                }
            } else {
                $error = "Usuario no encontrado.";
                echo $error; // Mostrar mensaje de error si no encontramos el usuario
            }
            $stmt->close();
        }
    } else {
        $error = "Datos no enviados correctamente.";
        echo $error; // Mostrar mensaje de error si los datos no se han enviado correctamente
    }

    $conn->close();
}
?>
