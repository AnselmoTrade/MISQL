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

// Obtener nombre del archivo
$query = "SELECT archivo FROM Pdfs WHERE id = ?";
$stmt = sqlsrv_query($conn, $query, [$id]);
$pdf = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if (!$pdf) {
    die("PDF no encontrado.");
}

$archivo = "../uploads/" . $pdf['archivo'];

// Eliminar de base de datos
$query = "DELETE FROM Pdfs WHERE id = ?";
$stmt = sqlsrv_query($conn, $query, [$id]);

// Eliminar archivo del servidor si existe
if ($stmt && file_exists($archivo)) {
    unlink($archivo);
}

header("Location: panel.php");
exit;
