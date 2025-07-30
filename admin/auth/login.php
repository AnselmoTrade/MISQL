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
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Administrador</title>
</head>
<body>
    <h2>Iniciar Sesión (Administrador)</h2>
    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br>
        <button type="submit">Entrar</button>
    </form>
    <p style="color:red;"><?php echo $mensaje; ?></p>
</body>
</html>
