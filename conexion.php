<?php
try {
    $conn = new PDO(
        "sqlsrv:server = tcp:sql-anselmo.database.windows.net,1433; Database = anselmo",
        "Anselmo",
        "@71almercO"
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error al conectar con la base de datos (PDO).";
    die(print_r($e));
}
?>
