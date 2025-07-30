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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2 class="login-title">Iniciar Sesión</h2>
        <form method="POST" class="login-form">
            <input type="text" name="usuario" class="login-input" placeholder="Usuario" required>
            <input type="password" name="contrasena" class="login-input" placeholder="Contraseña" required>
            <button type="submit" class="login-button">Entrar</button>
        </form>
        <?php if ($mensaje): ?>
            <p class="login-error"><?php echo $mensaje; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>


