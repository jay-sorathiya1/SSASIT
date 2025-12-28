<?php
// require 'db/connection.php';

function allCount($conn, $designation, $status, $table)
{
    try {
        if ($table == 'department') {

            if ($status == '') {

                $Select = "select count(*) as total from $table";

                return mysqli_query($conn, $Select);
            }
            $Select = "select count(*) as total from $table where Department_Status = '" . $status . "'";

            return mysqli_query($conn, $Select);
        }



        if ($table === 'person') {
            if ($designation == '') {
                $Select = "select count(*) as total from $table where Designation != 'Student'";
                return mysqli_query($conn, $Select);
            }

            if ($status == '') {

                $Select = "select count(*) as total from $table where Designation = '" . $designation . "'";

                return mysqli_query($conn, $Select);
            }

            $Select = "select count(*) as total from $table where Designation = '" . $designation . "' and Status = '" . $status . "'";

            return mysqli_query($conn, $Select);
        }
    } catch (\Throwable $th) {

        echo $th;
    }
}
?>