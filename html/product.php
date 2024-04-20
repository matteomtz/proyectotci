<?php
$servername = "db"; // Nombre del servicio de MySQL en el archivo docker-compose.yml
$username = "usuario"; // Usuario de la base de datos
$password = "contraseña"; // Contraseña de la base de datos
$database = "proyectodb"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row['product_name'];
        $price = $row['price'];
    } else {
        echo "No se encontró el producto.";
        exit();
    }
} else {
    echo "ID de producto no proporcionado.";
    exit();
}

if(isset($_POST['update_product'])) {
    $new_product_name = $_POST['new_product_name'];
    $new_price = $_POST['new_price'];

    $sql_update = "UPDATE products SET product_name='$new_product_name', price=$new_price WHERE id=$product_id";
    if ($conn->query($sql_update) === TRUE) {
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error al modificar producto: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Modificar Producto</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="new_product_name">Nuevo Nombre del Producto:</label>
                <input type="text" class="form-control" id="new_product_name" name="new_product_name" value="<?php echo $product_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_price">Nuevo Precio:</label>
                <input type="number" class="form-control" id="new_price" name="new_price" value="<?php echo $price; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_product">Modificar Producto</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
