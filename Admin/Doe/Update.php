<?php
function UpdateById($conn, $table, $data)
{
    try {
        if ($table === "student" || $table === "faculty") {
            $Update = "Update person set 
        First_Name = '" . $data['First Name'] . "',
        Last_Name = '" . $data['Last Name'] . "',
        DOB = '" . $data['Date of Birth'] . "',
        Address = '" . $data['Address'] . "',
        City = '" . $data['City'] . "',
        Mobile = '" . $data['Mobile'] . "',
        Email = '" . $data['Email'] . "',
        Gender = '" . $data['Gender'] . "',
        Qualification = '" . $data['Qualification'] . "',
        Photo = '" . $data['Photo'] . "',
        Department_ID = '" . $data['Department'] . "',
        Joining_Date = '" . $data[($table == 'faculty') ? "Joining Date" : "Admission Date"] . "',
        Status = '" . $data['Status'] . "',
        Designation = '" . $data['Designation'] . "',
        Experience = '" . $data['Experience'] . "'
        where id = " . $data['ID'] . "";
            return mysqli_query($conn, $Update);
        }
        
        $Update = "Update $table set 
        Dept_Name = '" . $data['Dept_Name'] . "',
        Dept_Description = '" . $data['Dept_Description'] . "',
        Established_Year = '" . $data['Established_Year'] . "',
        Department_Status = '" . $data['Department_Status'] . "',
        HOD = '" . $data['HOD'] . "'
        where id = " . $data['ID'] . "";

        return mysqli_query($conn, $Update);
    } catch (Exception $e) {
        return $e;
    }
}

?>