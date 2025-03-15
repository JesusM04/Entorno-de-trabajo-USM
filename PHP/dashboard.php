<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Si no está logueado, redirige a login
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Linkea tu CSS aquí -->
</head>
<body>

    <header>
        <h2>Bienvenido al Dashboard</h2>
        <button onclick="window.location.href='logout.php'">Cerrar sesión</button>
    </header>

    <!-- Ventanas o Secciones -->
    <div class="ventanas">
        <section id="ventanaInicio" class="ventana active">
            <h1>Bienvenido a la página de inicio</h1>
            <p>Contenido inicial de la página...</p>
        </section>
        <section id="ventanaServicios" class="ventana">
            <h1>Servicios</h1>
            <p>Contenido relacionado con servicios...</p>
        </section>
        <section id="ventanaContacto" class="ventana">
            <h1>Contacto</h1>
            <p>Contenido relacionado con contacto...</p>
        </section>
    </div>

    <script>
        // Aquí controlas el cambio entre ventanas
        const buttons = document.querySelectorAll('.nav-button');
        const windows = document.querySelectorAll('.ventana');

        buttons.forEach((button) => {
            button.addEventListener('click', (e) => {
                const target = e.target.dataset.target;

                // Cambiar a la ventana correspondiente
                windows.forEach((window) => {
                    window.classList.remove('active');
                });
                document.getElementById(target).classList.add('active');

                // Cambiar el estado de los botones
                buttons.forEach((btn) => {
                    btn.classList.remove('active');
                });
                e.target.classList.add('active');
            });
        });
    </script>

</body>
</html>
