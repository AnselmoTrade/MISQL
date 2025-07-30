<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../conexion.php';

// Subida de PDF
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $archivo = $_FILES['archivo'];

    if ($archivo['error'] === 0) {
        $nombreArchivo = time() . "_" . basename($archivo['name']);
        $rutaDestino = "../uploads/" . $nombreArchivo;

        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            $query = "INSERT INTO Pdfs (titulo, descripcion, archivo) VALUES (?, ?, ?)";
            $params = [$titulo, $descripcion, $nombreArchivo];
            $stmt = sqlsrv_query($conn, $query, $params);
            $mensaje = $stmt ? "✅ PDF subido correctamente." : "❌ Error al guardar en la base de datos.";
        } else {
            $mensaje = "❌ Error al mover el archivo.";
        }
    } else {
        $mensaje = "❌ Error al subir el archivo.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Administrador</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?php echo $_SESSION['admin']; ?> | <a href="logout.php">Cerrar sesión</a></h2>

        <h3>Subir nuevo PDF</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Título" required>
            <textarea name="descripcion" placeholder="Descripción" required></textarea>
            <input type="file" name="archivo" accept="application/pdf" required>
            <button type="submit" id="btnSubir">Subir PDF</button>
        </form>

        <?php if ($mensaje): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <h3>Listado de PDFs</h3>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = sqlsrv_query($conn, "SELECT * FROM Pdfs ORDER BY fecha_subida DESC");
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                    echo "<td><a href='../uploads/" . htmlspecialchars($row['archivo']) . "' target='_blank'>Ver</a></td>";
                    echo "<td>
                            <a class='editar' href='editar.php?id={$row['id']}'>Editar</a> |
                            <a class='eliminar' href='eliminar.php?id={$row['id']}' onclick=\"return confirm('¿Seguro que deseas eliminar este PDF?');\">Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="panel.js"></script>
</body>
</html>
