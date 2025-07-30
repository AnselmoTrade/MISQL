<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no válido.");
}

$mensaje = "";

// Actualizar datos si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    $query = "UPDATE Pdfs SET titulo = ?, descripcion = ? WHERE id = ?";
    $params = [$titulo, $descripcion, $id];
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt) {
        header("Location: panel.php");
        exit;
    } else {
        $mensaje = "Error al actualizar.";
    }
}

// Obtener datos actuales
$query = "SELECT * FROM Pdfs WHERE id = ?";
$stmt = sqlsrv_query($conn, $query, [$id]);
$pdf = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if (!$pdf) {
    die("PDF no encontrado.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar PDF</title>
    <script src="editar.js"></script>
    <link rel="stylesheet" href="admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h2>Editar PDF</h2>
    <form method="POST">
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($pdf['titulo']); ?>" required><br>
        <textarea name="descripcion" required><?php echo htmlspecialchars($pdf['descripcion']); ?></textarea><br>
        <button type="submit">Guardar Cambios</button>
    </form>
    <p style="color:red;"><?php echo $mensaje; ?></p>
    <a href="panel.php">← Volver</a>
</body>
</html>
