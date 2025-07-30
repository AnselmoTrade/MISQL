<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="titulo">📚 Lista de Documentos PDF</h1>
        <ul class="lista-pdfs">
            <?php
            $query = "SELECT * FROM Pdfs ORDER BY fecha_subida DESC";
            $stmt = sqlsrv_query($conn, $query);

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<li class='item'>";
                echo "<h3>" . htmlspecialchars($row['titulo']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['descripcion']) . "</p>";
                echo "<a class='boton-ver' href='uploads/" . htmlspecialchars($row['archivo']) . "' target='_blank'>Ver PDF</a>";
                echo "</li>";
            }
            ?>
        </ul>
    </div>
    <script src="index.js"></script>
</body>
</html>
