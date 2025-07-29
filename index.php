<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Documentos</title>
</head>
<style>
    background-color: #f4f4f4;
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
    }
    h1 {
        color: #333;
    }
    ul {
        list-style-type: none;
        padding: 0;
    }
    li {
        background: #fff;
        margin: 10px 0;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>
<body>
    <h1>Lista de PDFs</h1>
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
