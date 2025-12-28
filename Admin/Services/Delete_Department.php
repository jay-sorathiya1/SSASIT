<?php
require 'db/connection.php';
require 'Services/Verify-User.php';

// Get department ID from URL parameters
$dept_id = isset($_GET['id']) ? $_GET['id'] : '';

// Validate required parameters
if (empty($dept_id)) {
    header("Location: View_Departments?status=error");
    exit();
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: View_Departments");
    exit();
}

try {
    // Start transaction
    mysqli_autocommit($conn, false);
    
    // Check if department exists
    $check_query = "SELECT Dept_ID, Dept_Name FROM department WHERE Dept_ID = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    if (!$stmt) {
        throw new Exception("Failed to prepare check query");
    }

    mysqli_stmt_bind_param($stmt, 's', $dept_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || $result->num_rows === 0) {
        mysqli_stmt_close($stmt);
        throw new Exception("Department not found");
    }

    $department = $result->fetch_assoc();
    mysqli_stmt_close($stmt);
    
    // Check if department has associated students or faculty
    $person_check_query = "SELECT COUNT(*) as count FROM person WHERE Department_ID = ?";
    $stmt = mysqli_prepare($conn, $person_check_query);
    if (!$stmt) {
        throw new Exception("Failed to prepare person check query");
    }
    
    mysqli_stmt_bind_param($stmt, 's', $dept_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $person_count = $result ? $result->fetch_assoc()['count'] : 0;
    mysqli_stmt_close($stmt);
    
    if ($person_count > 0) {
        // Department has associated people, cannot delete
        mysqli_rollback($conn);
        header("Location: View_Departments?status=error&message=cannot_delete_has_people");
        exit();
    }
    
    // Delete the department
    $delete_query = "DELETE FROM department WHERE Dept_ID = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    if (!$stmt) {
        throw new Exception("Failed to prepare delete query");
    }

    mysqli_stmt_bind_param($stmt, 's', $dept_id);
    $delete_result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    if (!$delete_result) {
        throw new Exception("Failed to delete department");
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    // Redirect with success message
    header("Location: View_Departments?status=deleted&name=" . urlencode($department['Dept_Name']));
    exit();
    
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    
    // Log error for debugging
    error_log("Department Delete Error: " . $e->getMessage());
    
    // Redirect with error message
    header("Location: View_Departments?status=error");
    exit();
    
} finally {
    // Restore autocommit
    mysqli_autocommit($conn, true);
    
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>
