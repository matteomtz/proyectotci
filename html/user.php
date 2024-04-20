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
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $email = $row['email'];
    } else {
        echo "No se encontró el usuario.";
        exit();
    }
} else {
    echo "ID de usuario no proporcionado.";
    exit();
}

if(isset($_POST['update_user'])) {
    $new_username = $_POST['new_username'];
    $new_email = $_POST['new_email'];

    $sql_update = "UPDATE users SET username='$new_username', email='$new_email' WHERE id=$user_id";
    if ($conn->query($sql_update) === TRUE) {
        header("Location: index.php"); // Redirigir a la página principal después de la modificación
        exit();
    } else {
        echo "Error al modificar usuario: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Modificar Usuario</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="new_username">Nuevo Nombre de Usuario:</label>
                <input type="text" class="form-control" id="new_username" name="new_username" value="<?php echo $username; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_email">Nuevo Email:</label>
                <input type="email" class="form-control" id="new_email" name="new_email" value="<?php echo $email; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_user">Modificar Usuario</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>

