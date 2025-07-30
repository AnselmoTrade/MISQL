<?php
include 'conexion.php';

if (isset($_POST['subir'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $archivoNombre = $_FILES['archivo']['name'];
    $archivoTemp = $_FILES['archivo']['tmp_name'];
    $archivoDestino = "uploads/" . basename($archivoNombre);

    // Validar que sea PDF
    $extension = strtolower(pathinfo($archivoNombre, PATHINFO_EXTENSION));
    if ($extension != "pdf") {
        echo "<p style='color:red;'>Solo se permiten archivos PDF.</p>";
        exit;
    }

    // Subir archivo
    if (move_uploaded_file($archivoTemp, $archivoDestino)) {
        $query = "INSERT INTO Pdfs (titulo, descripcion, archivo, fecha_subida)
                  VALUES (?, ?, ?, GETDATE())";

        $params = [$titulo, $descripcion, $archivoNombre];
        $stmt = sqlsrv_query($conn, $query, $params);

        if ($stmt) {
            echo "<p style='color:green;'>PDF subido correctamente.</p>";
            header("Location: panel.php");
            exit;
        } else {
            echo "<p style='color:red;'>Error al guardar en la base de datos.</p>";
        }
    } else {
        echo "<p style='color:red;'>Error al subir el archivo.</p>";
    }
}
?>
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir PDF</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>📤 Subir Nuevo PDF</h1>
        <form action="subir.php" method="POST" enctype="multipart/form-data">
            <label>Título:</label><br>
            <input type="text" name="titulo" required><br><br>

            <label>Descripción:</label><br>
            <textarea name="descripcion" rows="4" required></textarea><br><br>

            <label>Seleccionar PDF:</label><br>
            <input type="file" name="archivo" accept="application/pdf" required><br><br>

            <button type="submit" name="subir">Subir PDF</button>
        </form>
        <br>
        <a href="panel.php">⬅ Volver al panel</a>
    </div>
</body>
</html>
