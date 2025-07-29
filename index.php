<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Documentos</title>
</head>
<body>
    <h1 class="titulo">Lista de PDFs</h1>
    <ul>
        <?php
        $query = "SELECT * FROM Pdfs ORDER BY fecha_subida DESC";
        $stmt = sqlsrv_query($conn, $query);

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<li>";
            echo "<h3>" . htmlspecialchars($row['titulo']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['descripcion']) . "</p>";
            echo "<a href='uploads/" . htmlspecialchars($row['archivo']) . "' target='_blank'>Ver PDF</a>";
            echo "</li><hr>";
        }
        ?>
    </ul>
</body>
</html>
