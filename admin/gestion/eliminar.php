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

// Obtener el nombre del archivo
$query = "SELECT titulo, archivo FROM Pdfs WHERE id = ?";
$stmt = sqlsrv_query($conn, $query, [$id]);
$pdf = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if (!$pdf) {
    die("PDF no encontrado.");
}

$archivo = "../uploads/" . $pdf['archivo'];

// Si se confirma la eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "DELETE FROM Pdfs WHERE id = ?";
    $stmt = sqlsrv_query($conn, $query, [$id]);

    if ($stmt && file_exists($archivo)) {
        unlink($archivo);
    }

    header("Location: panel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Eliminación</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>¿Eliminar PDF?</h2>
        <p>¿Estás seguro de que deseas eliminar el archivo <strong><?php echo htmlspecialchars($pdf['titulo']); ?></strong>?</p>

        <form method="POST">
            <button type="submit" class="button">Sí, eliminar</button>
            <a href="panel.php" class="button" style="background-color: var(--color-principal);">Cancelar</a>
        </form>
    </div>
    <script src="eliminar.js"></script>
</body>
</html>
