<?php
class DatabaseOptimizer {
    private $conn;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->conn = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Conexión fallida: " . $exception->getMessage();
        }
    }

    // Método para obtener todas las tablas de la base de datos
    public function getTables() {
        $query = "SHOW TABLES";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Método para analizar todas las tablas
    public function analyzeTables() {
        $tables = $this->getTables();
        foreach ($tables as $table) {
            $this->analyzeTable($table);
        }
    }

    // Método para optimizar todas las tablas
    public function optimizeTables() {
        $tables = $this->getTables();
        foreach ($tables as $table) {
            $this->optimizeTable($table);
        }
    }

    // Método para verificar todas las tablas
    public function checkTables() {
        $tables = $this->getTables();
        foreach ($tables as $table) {
            $this->checkTable($table);
        }
    }

    // Método para analizar una tabla específica
    public function analyzeTable($table) {
        $query = "ANALYZE TABLE {$table}";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            echo "Tabla '{$table}' analizada con éxito.<br>";
        } else {
            echo "Error al analizar la tabla '{$table}'.<br>";
        }
    }

    // Método para optimizar una tabla específica
    public function optimizeTable($table) {
        $query = "OPTIMIZE TABLE {$table}";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            echo "Tabla '{$table}' optimizada con éxito.<br>";
        } else {
            echo "Error al optimizar la tabla '{$table}'.<br>";
        }
    }

    // Método para verificar una tabla específica
    public function checkTable($table) {
        $query = "CHECK TABLE {$table}";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            echo "Tabla '{$table}' verificada con éxito.<br>";
        } else {
            echo "Error al verificar la tabla '{$table}'.<br>";
        }
    }
}

// Crear una instancia de la clase DatabaseOptimizer
$host = 'localhost';
$dbname = 'nombre_de_tu_base_de_datos';
$username = 'tu_usuario';
$password = 'tu_contraseña';

$optimizer = new DatabaseOptimizer($host, $dbname, $username, $password);

// Analizar, optimizar y verificar todas las tablas de la base de datos
echo "<h2>Analizando todas las tablas...</h2>";
$optimizer->analyzeTables();

echo "<h2>Optimizando todas las tablas...</h2>";
$optimizer->optimizeTables();

echo "<h2>Verificando todas las tablas...</h2>";
$optimizer->checkTables();
?>

<!-- Para crear un script PHP que se encargue de analizar y optimizar la base de datos (en este caso, para una base de datos MySQL), podemos usar algunas funciones específicas de MySQL como OPTIMIZE TABLE, ANALYZE TABLE, y CHECK TABLE que permiten mantener la base de datos en un estado óptimo.

<!-- Explicación del Código:
Clase DatabaseOptimizer:

Esta clase recibe los parámetros de conexión a la base de datos y establece una conexión PDO.
Utiliza tres funciones principales (analyzeTable(), optimizeTable(), checkTable()) que ejecutan las consultas SQL necesarias para analizar, optimizar y verificar las tablas.
Utiliza la función SHOW TABLES para obtener todas las tablas de la base de datos y luego ejecuta los métodos correspondientes sobre cada tabla.
Métodos:

getTables(): Obtiene todas las tablas de la base de datos con la consulta SHOW TABLES.
analyzeTable($table): Ejecuta el comando SQL ANALYZE TABLE, que actualiza las estadísticas sobre la distribución de los datos en la tabla para optimizar las consultas.
optimizeTable($table): Ejecuta el comando SQL OPTIMIZE TABLE, que reorganiza y optimiza el almacenamiento de la tabla para mejorar el rendimiento.
checkTable($table): Ejecuta el comando SQL CHECK TABLE, que verifica si la tabla tiene algún error en su estructura.
Instanciación y ejecución:

Se crea una instancia de la clase DatabaseOptimizer con las credenciales de la base de datos.
Luego, se llaman a los métodos analyzeTables(), optimizeTables(), y checkTables() para analizar, optimizar y verificar todas las tablas de la base de datos.
2. Cómo Funciona en la Práctica:
Al ejecutar este script, se mostrará el progreso en la pantalla:
"Analizando todas las tablas..."
"Optimizando todas las tablas..."
"Verificando todas las tablas..."
Estos mensajes indican que se están ejecutando las operaciones correspondientes en todas las tablas de la base de datos.
3. Consideraciones Importantes:
Seguridad: Asegúrate de que el script sea accesible solo para usuarios autorizados. No lo dejes disponible en un entorno de producción sin protecciones adecuadas.
Rendimiento: Las operaciones ANALYZE, OPTIMIZE y CHECK pueden ser costosas en términos de tiempo si tienes tablas muy grandes. Si la base de datos es muy grande, puede ser necesario realizar estas tareas durante horas de bajo tráfico o en segundo plano.
Errores y Logs: Si alguna de las operaciones falla, el script imprimirá un mensaje de error para que puedas tomar acciones correctivas.
4. Ampliación:
Puedes ampliar este script agregando otras operaciones de mantenimiento como:

Reparar tablas corruptas con REPAIR TABLE.
Limpiar tablas de logs o sesiones si la base de datos tiene tablas que acumulan datos de logs y no se utilizan mucho.
Este script debe ayudarte a mantener tu base de datos en buen estado realizando tareas de mantenimiento periódicas como análisis, optimización y verificación de las tablas. -->