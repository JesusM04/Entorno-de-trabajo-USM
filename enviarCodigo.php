<?php
session_start();

// Verifica si se ha enviado un correo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo'])) {
    $correo = $_POST['correo'];

    // Generar un código aleatorio de 6 dígitos
    $codigoRecuperacion = rand(100000, 999999);  // Código de 6 dígitos

    // Cifrado del código con OpenSSL
    $claveSecreta = "tuClaveSecreta123";  // Cambia esto por una clave segura y única
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));  // Generar un IV aleatorio
    $codigoCifrado = openssl_encrypt($codigoRecuperacion, 'aes-256-cbc', $claveSecreta, 0, $iv);
    
    // Aquí debes guardar el código cifrado y el IV en la base de datos para su posterior comparación
    // Por ejemplo, lo guardamos en una variable de sesión para demostración
    $_SESSION['codigoCifrado'] = $codigoCifrado;
    $_SESSION['iv'] = base64_encode($iv);  // Almacenamos el IV codificado en base64

    // Configuración del correo
    $asunto = "Código de Recuperación de Contraseña";
    $mensaje = "Tu código de recuperación es: $codigoRecuperacion. Si no solicitaste este código, ignora este correo.";
    $cabeceras = "From: no-reply@tusitio.com\r\n";
    $cabeceras .= "Reply-To: no-reply@tusitio.com\r\n";
    $cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Enviar el correo
    if (mail($correo, $asunto, $mensaje, $cabeceras)) {
        echo "El código de recuperación ha sido enviado a tu correo.";
    } else {
        echo "Hubo un error al enviar el correo. Intenta de nuevo más tarde.";
    }
}

?>



<?php
session_start();

// Verificar si se ha enviado el código de recuperación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'])) {
    $codigoIngresado = $_POST['codigo'];

    // Recuperar el código cifrado y el IV de la sesión
    if (isset($_SESSION['codigoCifrado']) && isset($_SESSION['iv'])) {
        $codigoCifrado = $_SESSION['codigoCifrado'];
        $iv = base64_decode($_SESSION['iv']);  // Decodificar el IV de base64

        // Clave secreta utilizada para el cifrado
        $claveSecreta = "tuClaveSecreta123";  // La misma clave que usaste al cifrar

        // Desencriptar el código cifrado
        $codigoDesencriptado = openssl_decrypt($codigoCifrado, 'aes-256-cbc', $claveSecreta, 0, $iv);

        // Comparar el código ingresado con el código desencriptado
        if ($codigoIngresado == $codigoDesencriptado) {
            echo "Código correcto. Ahora puedes proceder a cambiar tu contraseña.";
            // Aquí puedes redirigir al usuario a la página para cambiar la contraseña
        } else {
            echo "Error: El código ingresado no es válido.";
        }
    } else {
        echo "No se encontró el código cifrado en la sesión.";
    }
}
?>
