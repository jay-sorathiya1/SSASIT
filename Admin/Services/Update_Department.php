<?php
// REDESIGNED: Clean, secure department update service
require 'db/connection.php';
require 'Doe/Update.php';
require 'Doe/ViewAll-Query.php';

// IMPROVED: Get department ID from POST data (more secure)
$dept_id = $_POST['dept_id'] ?? '';

// ENHANCED: Comprehensive validation
if (empty($dept_id)) {
    header("Location: View_Departments?status=error&message=missing_id");
    exit();
}

// IMPROVED: Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: Edit_Department?id=$dept_id&status=error");
    exit();
}

// OPTIMIZED: Clean validation functions
function validateInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function validateRequiredFields($fields) {
    foreach ($fields as $field => $value) {
        if (empty(trim($value))) {
            return false;
        }
    }
    return true;
}

// FIXED: Updated field names to match new form
$required_fields = [
    'deptName' => $_POST['deptName'] ?? '',
    'establishedYear' => $_POST['establishedYear'] ?? '',
    'departmentStatus' => $_POST['departmentStatus'] ?? ''
];

// IMPROVED: Better validation with specific error messages
if (!validateRequiredFields($required_fields)) {
    header("Location: Edit_Department?id=$dept_id&status=error&message=required_fields");
    exit();
}

// CLEANED: Sanitize all inputs (no duplicates)
$department_name = validateInput($_POST['deptName']);
$established_year = (int)validateInput($_POST['establishedYear']);
$hod_name = validateInput($_POST['hodName'] ?? ''); // Optional field
$department_status = validateInput($_POST['departmentStatus']);
$department_description = validateInput($_POST['deptDescription'] ?? ''); // Optional field

// IMPROVED: Enhanced validation with better error handling
try {
    // Validate department name pattern
    if (!preg_match('/^[A-Za-z\s&]{3,100}$/', $department_name)) {
        throw new Exception("Invalid department name format");
    }

    // Validate established year
    $current_year = date('Y');
    if ($established_year < 1900 || $established_year > $current_year) {
        throw new Exception("Invalid established year");
    }

    // Validate status
    $valid_statuses = ['Active', 'Inactive', 'Under Development', 'Merged', 'Discontinued'];
    if (!in_array($department_status, $valid_statuses)) {
        throw new Exception("Invalid department status");
    }

    // OPTIMIZED: Check if HOD exists using prepared statements (if provided)
    if (!empty($hod_name)) {
        $hod_check_query = "SELECT ID FROM person WHERE ID = ? AND Designation != 'Student'";
        $stmt = mysqli_prepare($conn, $hod_check_query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $hod_name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (!$result || $result->num_rows === 0) {
                mysqli_stmt_close($stmt);
                throw new Exception("Invalid HOD selection");
            }
            mysqli_stmt_close($stmt);
        }
    }

    // OPTIMIZED: Check if department name already exists using prepared statements
    $name_check_query = "SELECT ID FROM department WHERE Dept_Name = ? AND ID != ?";
    $stmt = mysqli_prepare($conn, $name_check_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $department_name, $dept_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && $result->num_rows > 0) {
            mysqli_stmt_close($stmt);
            throw new Exception("Department name already exists");
        }
        mysqli_stmt_close($stmt);
    }

} catch (Exception $e) {
    error_log("Department Update Validation Error: " . $e->getMessage());
    header("Location: Edit_Department?id=$dept_id&status=error&message=validation");
    exit();
}

// FIXED: Prepare data for update with correct database field names
$data = [
    "ID" => $dept_id,
    "Dept_Name" => $department_name,
    "Dept_Description" => $department_description,
    "Established_Year" => $established_year,
    "Department_Status" => $department_status,
    "HOD" => $hod_name
];

try {
    // Start transaction
    mysqli_autocommit($conn, false);
    
    // Update department
    $result = UpdateById($conn, 'department', $data);
    
    if ($result) {
        // If status changed to inactive, update related records if needed
        if ($department_status === 'Inactive') {
            // You might want to handle related records here
            // For example, notify about students/faculty in this department
        }
        
        // Commit transaction
        mysqli_commit($conn);
        
        // Redirect with success message
        header("Location: Edit_Department?id=$dept_id&status=success");
        exit();
    } else {
        echo $result;
        // Rollback transaction
        mysqli_rollback($conn);
        
        // Log error for debugging
        error_log("Department Update Error: " . mysqli_error($conn));
        
        header("Location: Edit_Department?id=$dept_id&status=error");
        exit();
    }
    
} catch (Exception $e) {
    echo $result;
    // Rollback transaction on exception
    mysqli_rollback($conn);
    
    // Log error for debugging
    error_log("Department Update Exception: " . $e->getMessage());
    
    header("Location: Edit_Department?id=$dept_id&status=error");
    exit();
    
} finally {
    // Restore autocommit
    mysqli_autocommit($conn, true);
    
    // Close connection
    mysqli_close($conn);
}
?>
