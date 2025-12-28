<?php
$result;
require 'db/connection.php';
require 'Doe/Insert-Query.php';
require 'Doe/Find_Last_Entry_Query.php';

$id = findLastEntry($conn, 'person');

if ($id->num_rows > 0) {
    $row = $id->fetch_assoc();
    $id = $row['ID'] + 1;
}

$entity_type = isset($_GET['type']) ? $_GET['type'] : '';

if ($entity_type === 'student' || $entity_type === 'faculty') {

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

        $photo = $_FILES['avatar'];
        $target_dir = "Public/uploads/";
        $originalname = $photo['name'];
        $fileextension = pathinfo($originalname, PATHINFO_EXTENSION);
        $newfilename = $id . "_" . date('d-m-Y') . "." . $fileextension;
    }
    $data = [
        "First Name" => $_POST['firstName'],
        "Last Name" => $_POST['lastName'],
        "Date of Birth" => $_POST['dob'],
        "Address" => $_POST['address'],
        "City" => $_POST['city'],
        "Mobile" => $_POST['mobile'],
        "Email" => $_POST['email'],
        "Gender" => $_POST['gender'],
        "Qualification" => $_POST['qualification'],
        "Photo" => (move_uploaded_file($photo['tmp_name'], $target_dir . $newfilename)) ? $newfilename : 'SSASIT.png',
        "Department" => $_POST['department'],
        "Status" => $_POST['status'],
        ($entity_type == 'faculty') ? "Joining Date" : "Admission Date" => $_POST['admissionDate'],
        "Designation" => ($entity_type == 'student') ? "Student" : $_POST['designation'],
        "Experience" => isset($_POST['experience']) ? $_POST['experience'] : 0,
    ];
    $result = insert($conn, $data, $entity_type);
} else {
    $data = [
        "Department Name" => $_POST['departmentName'],
        "HOD Name" => $_POST['hodName'],
        "Established Year" => $_POST['establishedYear'],
        "Department Status" => $_POST['departmentStatus'],
        "Department Description" => $_POST['departmentDescription'],
    ];
    $result = insertDepartment($conn, $data);
}





if ($result) {
    header("Location: entities?type=$entity_type&status=success");
} else {
    echo "Error: " . mysqli_error($conn);
    // header("Location: entities?type=$entity_type&status=field");
}

mysqli_close($conn);
?>