<?php
require 'DB/connection.php';
require 'Doe/Update.php';
require 'Doe/ViewAll-Query.php';

$entity_type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Validate required parameters
if (empty($id) || empty($entity_type)) {
    header("Location: Dashboard");
    exit();
}

// Validate form submission
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: Edit_Record?type=$entity_type&id=$id");
    exit();
}

// Function to validate and sanitize input
function validateInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to validate required fields
function validateRequiredFields($fields) {
    foreach ($fields as $field => $value) {
        if (empty(trim($value))) {
            return false;
        }
    }
    return true;
}

if ($entity_type === 'student' || $entity_type === 'faculty') {

    // Get current record data to preserve existing photo if no new one is uploaded
    $current_record = FindByID($conn, $id, $entity_type);
    $current_data = [];
    if ($current_record && $current_record->num_rows > 0) {
        $current_data = $current_record->fetch_assoc();
    }

    // Validate required fields
    $required_fields = [
        'firstName' => $_POST['firstName'] ?? '',
        'lastName' => $_POST['lastName'] ?? '',
        'dob' => $_POST['dob'] ?? '',
        'address' => $_POST['address'] ?? '',
        'city' => $_POST['city'] ?? '',
        'mobile' => $_POST['mobile'] ?? '',
        'email' => $_POST['email'] ?? '',
        'gender' => $_POST['gender'] ?? '',
        'qualification' => $_POST['qualification'] ?? '',
        'department' => $_POST['department'] ?? '',
        'status' => $_POST['status'] ?? '',
        'admissionDate' => $_POST['admissionDate'] ?? ''
    ];

    if ($entity_type === 'faculty') {
        $required_fields['designation'] = $_POST['designation'] ?? '';
    }

    if (!validateRequiredFields($required_fields)) {
        header("Location: Edit_Record?type=$entity_type&id=$id&status=validation");
        exit();
    }

    // Handle photo upload
    $photo_filename = $current_data['Photo'] ?? 'SSASIT.png'; // Keep existing photo by default

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['avatar'];
        $target_dir = "Public/uploads/";

        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        $file_type = mime_content_type($photo['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            // Validate file size (5MB max)
            if ($photo['size'] <= 5 * 1024 * 1024) {
                $originalname = $photo['name'];
                $fileextension = pathinfo($originalname, PATHINFO_EXTENSION);
                $newfilename = $id . "_" . date('Y-m-d_H-i-s') . "." . $fileextension;

                if (move_uploaded_file($photo['tmp_name'], $target_dir . $newfilename)) {
                    // Delete old photo if it's not the default
                    if ($current_data['Photo'] && $current_data['Photo'] !== 'SSASIT.png' && file_exists($target_dir . $current_data['Photo'])) {
                        unlink($target_dir . $current_data['Photo']);
                    }
                    $photo_filename = $newfilename;
                }
            }
        }
    }

    $data = [
        "ID" => $id,
        "First Name" => validateInput($_POST['firstName']),
        "Last Name" => validateInput($_POST['lastName']),
        "Date of Birth" => validateInput($_POST['dob']),
        "Address" => validateInput($_POST['address']),
        "City" => validateInput($_POST['city']),
        "Mobile" => validateInput($_POST['mobile']),
        "Email" => validateInput($_POST['email']),
        "Gender" => validateInput($_POST['gender']),
        "Qualification" => validateInput($_POST['qualification']),
        "Photo" => $photo_filename,
        "Department" => validateInput($_POST['department']),
        "Status" => validateInput($_POST['status']),
        ($entity_type == 'faculty') ? "Joining Date" : "Admission Date" => validateInput($_POST['admissionDate']),
        "Designation" => ($entity_type == 'student') ? "Student" : validateInput($_POST['designation']),
        "Experience" => isset($_POST['experience']) ? (int)$_POST['experience'] : 0,
    ];

    $result = UpdateById($conn, $entity_type, $data);
} else {
    $data = [
        "Department Name" => $_POST['departmentName'],
        "HOD Name" => $_POST['hodName'],
        "Established Year" => $_POST['establishedYear'],
        "Department Status" => $_POST['departmentStatus'],
        "Department Description" => $_POST['departmentDescription'],
    ];


    $result = UpdateById($conn, $entity_type, $data);
}





// Handle response
if ($result) {
    // echo $result;
    header("Location: Edit_Record?type=$entity_type&id=$id&status=success");
    exit();
} else {
    error_log("Database Error: " . mysqli_error($conn));
    header("Location: Edit_Record?type=$entity_type&id=$id&status=error");
    exit();
}

// mysqli_close($conn);
?>