<?php
// require 'db/connection.php';

function findLastEntry($conn, $table)
{
    try {
        $Select = "select ID from $table order by id desc limit 1";
        return mysqli_query($conn, $Select);
    } catch (\Throwable $th) {
        echo $th;
    }
}

?>