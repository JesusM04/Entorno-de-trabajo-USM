<?php
// Primero, necesitas una clase para la configuración de la base de datos. Usaremos PDO para conectar a la base de datos, lo que nos permitirá tener un acceso más seguro y flexible.
class Database {
    private $host = 'localhost';
    private $db_name = 'nombre_de_tu_base_de_datos';
    private $username = 'tu_usuario';
    private $password = 'tu_contraseña';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Conexión fallida: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

<!-- Esta clase base se encargará de la interacción básica con la base de datos para poder hacer consultas, insertar, actualizar y eliminar. -->
<?php
class ORM {
    private $conn;
    private $table;

    public function __construct($table) {
        $this->conn = (new Database())->getConnection(); // Obtiene la conexión de la clase Database
        $this->table = $table; // Nombre de la tabla
    }

    // Método para obtener todos los registros de una tabla
    public function all() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener un solo registro por su ID
    public function find($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para insertar un nuevo registro
    public function create($data) {
        $columns = implode(", ", array_keys($data));  // "campo1, campo2, campo3"
        $placeholders = ":" . implode(", :", array_keys($data));  // ":campo1, :campo2, :campo3"

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    // Método para actualizar un registro
    public function update($id, $data) {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ", "); // Remueve la última coma

        $query = "UPDATE {$this->table} SET $set WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    // Método para eliminar un registro
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>

<!-- Ahora que tienes las clases de base de datos y ORM listas, puedes crear objetos de la clase ORM y utilizarlos para interactuar con la base de datos. -->
<?php
// Incluir las clases necesarias
require_once 'Database.php';
require_once 'ORM.php';

// Crear una instancia de ORM para una tabla específica, por ejemplo, 'usuarios'
$usuarios = new ORM('usuarios');

// Obtener todos los usuarios
$all_users = $usuarios->all();
echo '<pre>';
print_r($all_users); // Muestra todos los usuarios
echo '</pre>';

// Obtener un usuario por su ID
$user = $usuarios->find(1);
echo '<pre>';
print_r($user); // Muestra el usuario con ID = 1
echo '</pre>';

// Crear un nuevo usuario
$new_user_data = [
    'nombre' => 'Juan',
    'email' => 'juan@example.com',
    'password' => '1234'
];
$new_user_id = $usuarios->create($new_user_data);
echo "Nuevo usuario creado con ID: $new_user_id";

// Actualizar un usuario
$update_data = [
    'nombre' => 'Juan Pérez',
    'email' => 'juanperez@example.com'
];
$update_result = $usuarios->update(1, $update_data);
echo $update_result ? "Usuario actualizado con éxito." : "Error al actualizar el usuario.";

// Eliminar un usuario
$delete_result = $usuarios->delete(2);
echo $delete_result ? "Usuario eliminado con éxito." : "Error al eliminar el usuario.";
?>


<!-- 
Explicación del Código:
Conexión a la base de datos:
La clase Database se encarga de establecer la conexión a la base de datos con PDO. Puedes cambiar los parámetros de conexión (nombre de la base de datos, usuario y contraseña) según tu configuración.
ORM:
La clase ORM es genérica y puede ser utilizada con cualquier tabla. Solo necesitas pasar el nombre de la tabla al crear una nueva instancia de la clase.
Los métodos all(), find(), create(), update() y delete() te permiten hacer consultas y modificaciones básicas a la base de datos.
Los datos se pasan como arrays asociativos, donde las claves corresponden a los nombres de las columnas de la tabla y los valores son los datos que se insertarán o actualizarán.
4. Consideraciones Finales:
Este ejemplo es sencillo y básico. En un entorno de producción, puedes querer agregar más validaciones, manejo de excepciones y seguridad (por ejemplo, validación de entradas, protección contra SQL injection, etc.).

Cifrado de contraseñas: Si vas a trabajar con contraseñas, asegúrate de cifrarlas antes de guardarlas en la base de datos, por ejemplo usando password_hash() para crear un hash seguro de la contraseña y password_verify() para verificarla cuando el usuario inicie sesión.

Este entorno te proporcionará una forma más estructurada y fácil de interactuar con tu base de datos sin tener que escribir SQL directamente en cada parte de tu código. ¡Espero que esto te sirva! -->