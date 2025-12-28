<?php
require 'DB/connection.php';
require 'Services/Verify-User.php';

// Get parameters
$dept_id = $_GET['id'] ?? '';
$status = $_GET['status'] ?? '';
$mode = $_GET['mode'] ?? 'edit'; // 'edit' or 'view'

// Validate department ID
if (empty($dept_id)) {
    header('Location: View_Departments?status=error&message=missing_id');
    exit();
}

// Fetch department data
$dept_data = [];
$dept_query = "SELECT * FROM department WHERE Dept_ID = ?";
$stmt = mysqli_prepare($conn, $dept_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $dept_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && $result->num_rows > 0) {
        $dept_data = $result->fetch_assoc();
    } else {
        mysqli_stmt_close($stmt);
        header('Location: View_Departments?status=error&message=not_found');
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    header('Location: View_Departments?status=error&message=database_error');
    exit();
}

// Fetch faculty for HOD dropdown
$faculty_list = [];
$faculty_query = "SELECT ID, First_Name, Last_Name, Designation FROM person WHERE Designation != 'Student' ORDER BY First_Name, Last_Name";
$faculty_result = mysqli_query($conn, $faculty_query);

if ($faculty_result) {
    while ($faculty = $faculty_result->fetch_assoc()) {
        $faculty_list[] = $faculty;
    }
}

// Get department statistics
$student_count = 0;
$faculty_count = 0;

$student_query = "SELECT COUNT(*) as count FROM person WHERE Department_ID = ? AND Designation = 'Student'";
$stmt = mysqli_prepare($conn, $student_query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $dept_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student_count = $result ? $result->fetch_assoc()['count'] : 0;
    mysqli_stmt_close($stmt);
}

$faculty_query = "SELECT COUNT(*) as count FROM person WHERE Department_ID = ? AND Designation != 'Student'";
$stmt = mysqli_prepare($conn, $faculty_query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $dept_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $faculty_count = $result ? $result->fetch_assoc()['count'] : 0;
    mysqli_stmt_close($stmt);
}

$page_title = ($mode === 'view') ? 'View Department' : 'Edit Department';
$is_readonly = ($mode === 'view');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSASIT - <?php echo $page_title; ?></title>
    <?php require 'config/Icon-Config.php'; ?>
    <link rel="stylesheet" href="Css/Edit_Department.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php require 'Components/Header.php'; ?>
    
    <!-- Status Messages -->
    <?php if ($status === 'success'): ?>
        <div class="status-message success">
            <i class="fas fa-check-circle"></i>
            <span>Department updated successfully!</span>
        </div>
    <?php elseif ($status === 'error'): ?>
        <div class="status-message error">
            <i class="fas fa-exclamation-circle"></i>
            <span>
                <?php 
                $message = $_GET['message'] ?? '';
                switch($message) {
                    case 'missing_id': echo 'Department ID is required.'; break;
                    case 'not_found': echo 'Department not found.'; break;
                    case 'database_error': echo 'Database connection error.'; break;
                    case 'validation': echo 'Please check your input and try again.'; break;
                    case 'update_failed': echo 'Failed to update department.'; break;
                    default: echo 'An error occurred. Please try again.'; break;
                }
                ?>
            </span>
        </div>
    <?php endif; ?>

    <!-- Main Container -->
    <div class="edit-container">
        <!-- Page Header -->
        <div class="page-header">
            <button class="back-btn" onclick="window.location.href='View_Departments'" title="Back to Departments">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="header-info">
                <h1 class="page-title"><?php echo $page_title; ?></h1>
                <p class="page-subtitle"><?php echo htmlspecialchars($dept_data['Dept_Name'] ?? 'Unknown Department'); ?></p>
            </div>
            <?php if ($mode === 'view'): ?>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="window.location.href='Edit_Department?id=<?php echo $dept_id; ?>'">
                    <i class="fas fa-edit"></i>
                    Edit Department
                </button>
            </div>
            <?php endif; ?>
        </div>

        <!-- Department Stats -->
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $student_count; ?></div>
                    <div class="stat-label">Students</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $faculty_count; ?></div>
                    <div class="stat-label">Faculty</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon status-<?php echo strtolower(str_replace(' ', '-', $dept_data['Department_Status'] ?? 'unknown')); ?>">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo htmlspecialchars($dept_data['Department_Status'] ?? 'Unknown'); ?></div>
                    <div class="stat-label">Status</div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <form action="Update_Department" method="POST" class="edit-form" id="editDeptForm">
                <input type="hidden" name="dept_id" value="<?php echo htmlspecialchars($dept_data['Dept_ID']); ?>">
                
                <!-- Basic Information -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="deptName" class="form-label required">Department Name</label>
                            <input type="text" id="deptName" name="deptName" class="form-input" 
                                   value="<?php echo htmlspecialchars($dept_data['Dept_Name'] ?? ''); ?>" 
                                   <?php echo $is_readonly ? 'readonly' : 'required'; ?> maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="establishedYear" class="form-label required">Established Year</label>
                            <input type="number" id="establishedYear" name="establishedYear" class="form-input" 
                                   value="<?php echo htmlspecialchars($dept_data['Established_Year'] ?? ''); ?>" 
                                   <?php echo $is_readonly ? 'readonly' : 'required'; ?> min="1900" max="<?php echo date('Y'); ?>">
                        </div>

                        <div class="form-group">
                            <label for="hodName" class="form-label">Head of Department</label>
                            <select id="hodName" name="hodName" class="form-input" <?php echo $is_readonly ? 'disabled' : ''; ?>>
                                <option value="">Select HOD</option>
                                <?php foreach ($faculty_list as $faculty): ?>
                                    <option value="<?php echo htmlspecialchars($faculty['ID']); ?>" 
                                            <?php echo (isset($dept_data['HOD']) && $dept_data['HOD'] == $faculty['ID']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($faculty['First_Name'] . ' ' . $faculty['Last_Name'] . ' (' . $faculty['Designation'] . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="departmentStatus" class="form-label required">Status</label>
                            <select id="departmentStatus" name="departmentStatus" class="form-input" <?php echo $is_readonly ? 'disabled' : 'required'; ?>>
                                <option value="">Select Status</option>
                                <option value="Active" <?php echo (isset($dept_data['Department_Status']) && $dept_data['Department_Status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo (isset($dept_data['Department_Status']) && $dept_data['Department_Status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="Under Development" <?php echo (isset($dept_data['Department_Status']) && $dept_data['Department_Status'] === 'Under Development') ? 'selected' : ''; ?>>Under Development</option>
                                <option value="Merged" <?php echo (isset($dept_data['Department_Status']) && $dept_data['Department_Status'] === 'Merged') ? 'selected' : ''; ?>>Merged</option>
                                <option value="Discontinued" <?php echo (isset($dept_data['Department_Status']) && $dept_data['Department_Status'] === 'Discontinued') ? 'selected' : ''; ?>>Discontinued</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-align-left"></i>
                        Description
                    </h2>
                    
                    <div class="form-group">
                        <label for="deptDescription" class="form-label">Department Description</label>
                        <textarea id="deptDescription" name="deptDescription" class="form-input" 
                                  rows="4" maxlength="500" <?php echo $is_readonly ? 'readonly' : ''; ?>
                                  placeholder="Enter department description..."><?php echo htmlspecialchars($dept_data['Dept_Description'] ?? ''); ?></textarea>
                        <?php if (!$is_readonly): ?>
                        <div class="char-counter">
                            <span id="charCount">0</span>/500 characters
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Action Buttons -->
                <?php if (!$is_readonly): ?>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='View_Departments'">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Update Department
                    </button>
                </div>
                <?php else: ?>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='View_Departments'">
                        <i class="fas fa-arrow-left"></i>
                        Back to Departments
                    </button>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editDeptForm');
            const submitBtn = document.getElementById('submitBtn');
            const charCount = document.getElementById('charCount');
            const description = document.getElementById('deptDescription');
            
            // Character counter
            if (description && charCount) {
                function updateCharCount() {
                    charCount.textContent = description.value.length;
                }
                description.addEventListener('input', updateCharCount);
                updateCharCount();
            }
            
            // Form submission
            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                    submitBtn.disabled = true;
                });
            }
            
            // Auto-hide status messages
            const statusMessages = document.querySelectorAll('.status-message');
            statusMessages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = '0';
                    message.style.transform = 'translateX(100%)';
                    setTimeout(() => message.remove(), 300);
                }, 4000);
            });
        });
    </script>
</body>
</html>
