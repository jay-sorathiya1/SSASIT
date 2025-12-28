<?php
// require 'db/connection.php';

function viewAll($conn, $view_type)
{
    try {
        if ($view_type === 'department') {
            $Select = "select * from department";
        }
        elseif ($view_type === 'student') {
            $Select = "select * from person where Designation = '" . $view_type . "'";
            // $Select = "select * from person";
        }
        else {
            $Select = "select * from person where Designation != 'student'";
        }
        return mysqli_query($conn, $Select);
    } catch (\Throwable $th) {
        echo $th;
    }
}

function FindByID($conn, $id, $table)
{
    try {
        if ($table === 'department') {
            $Select = "select * from $table where ID = '" . $id . "'";
            return mysqli_query($conn, $Select);
        }
        $Select = "select * ,d.Dept_Name from person as p join department as d on p.Department_ID = d.Dept_ID where ID = '" . $id . "'";
        return mysqli_query($conn, $Select);
    } catch (\Throwable $th) {
        echo $th;
    }
}

?>