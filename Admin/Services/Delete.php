<?php
require 'db/connection.php';
require 'Doe/Delete_Record_Query.php';

$id = isset($_GET['Id']) ? $_GET['Id'] : '';
$table = isset($_GET['type']) ? $_GET['type'] : '';


$result = deleteRecord($conn, $id, $table);


if ($result) {
    header("Location: Entities_Record?type=$table&status=success");
} else {
    header("Location: Entities_Record?type=$table&status=field");
}

mysqli_close($conn);
?>