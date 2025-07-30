<?php
session_start();
include '../conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM Administradores WHERE usuario = ?";
    $params = [$usuario];
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $hash = $row['contrasena'];
        if (password_verify($contrasena, $hash)) {
            $_SESSION['admin'] = $usuario;
            header("Location: panel.php");
            exit;
        } else {
            $mensaje = "❌ Contraseña incorrecta.";
        }
    } else {
        $mensaje = "❌ Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        <?php if ($mensaje): ?>
            <p class="error"><?php echo $mensaje; ?></p>
        <?php endif; ?>
    </div>
    <script src="login.js"></script>
</body>
</html>

