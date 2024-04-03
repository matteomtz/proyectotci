<?php
// Configuración de la conexión a la base de datos
$servername = "db"; // Nombre del servicio de MySQL en el archivo docker-compose.yml
$username = "usuario"; // Usuario de la base de datos
$password = "contraseña"; // Contraseña de la base de datos
$database = "proyectodb"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Función para mostrar los mensajes de éxito o error
function showMessage($message, $type = 'success') {
    echo "<div class='alert alert-$type' role='alert'>$message</div>";
}

// Operación de agregar usuario
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, email) VALUES ('$username', '$email')";
    if ($conn->query($sql) === TRUE) {
        showMessage("Usuario agregado correctamente.");
    } else {
        showMessage("Error al agregar usuario: " . $conn->error, 'danger');
    }
}

// Operación de agregar producto
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (product_name, price) VALUES ('$product_name', '$price')";
    if ($conn->query($sql) === TRUE) {
        showMessage("Producto agregado correctamente.");
    } else {
        showMessage("Error al agregar producto: " . $conn->error, 'danger');
    }
}

// Operación de eliminar usuario
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM users WHERE id = $user_id";
    if ($conn->query($sql) === TRUE) {
        showMessage("Usuario eliminado correctamente.");
    } else {
        showMessage("Error al eliminar usuario: " . $conn->error, 'danger');
    }
}

// Operación de eliminar producto
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM products WHERE id = $product_id";
    if ($conn->query($sql) === TRUE) {
        showMessage("Producto eliminado correctamente.");
    } else {
        showMessage("Error al eliminar producto: " . $conn->error, 'danger');
    }
}

// Obtener usuarios
$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);

// Obtener productos
$sql_products = "SELECT * FROM products";
$result_products = $conn->query($sql_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Tienda - CRUD</h1>

        <!-- Agregar Usuario -->
        <h2>Agregar Usuario</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_user">Agregar Usuario</button>
        </form>

        <!-- Agregar Producto -->
        <h2>Agregar Producto</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="product_name">Nombre del Producto:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="price">Precio:</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_product">Agregar Producto</button>
        </form>

        <!-- Listar Usuarios -->
        <h2>Usuarios</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_users->num_rows > 0) {
                    while($row = $result_users->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>
                                <form method='post' action=''>
                                    <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                                    <button type='submit' class='btn btn-danger' name='delete_user'>Eliminar</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No se encontraron usuarios</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Listar Productos -->
        <h2>Productos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_products->num_rows > 0) {
                    while($row = $result_products->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>
                                <form method='post' action=''>
                                    <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                                    <button type='submit' class='btn btn-danger' name='delete_product'>Eliminar</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No se encontraron productos</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>
