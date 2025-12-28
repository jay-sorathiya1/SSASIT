<?php
require 'DB/connection.php';
require 'Services/Verify-User.php';
require 'Doe/ViewAll-Query.php';

// Get status messages
$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';

// Fetch all departments
$departments_query = "SELECT * FROM department ORDER BY Dept_Name ASC";
$departments_result = mysqli_query($conn, $departments_query);
$departments = [];

if ($departments_result) {
    while ($dept = $departments_result->fetch_assoc()) {
        $departments[] = $dept;
    }
}

// Get department statistics
$total_departments = count($departments);
$active_departments = 0;
$inactive_departments = 0;

foreach ($departments as $dept) {
    if ($dept['Department_Status'] === 'Active') {
        $active_departments++;
    } else {
        $inactive_departments++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSASIT - View Departments</title>
    <?php require 'config/Icon-Config.php'; ?>
    <link rel="stylesheet" href="Css/View_Departments.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php require 'Components/Header.php'; ?>
    
    <!-- Status Messages -->
    <?php if ($status === 'success'): ?>
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <span>Department updated successfully!</span>
        </div>
    <?php elseif ($status === 'deleted'): ?>
        <div class="success-message">
            <i class="fas fa-trash-alt"></i>
            <span>Department "<?php echo htmlspecialchars($_GET['name'] ?? 'Unknown'); ?>" deleted successfully!</span>
        </div>
    <?php elseif ($status === 'error'): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span>
                <?php 
                switch($message) {
                    case 'cannot_delete_has_people': echo 'Cannot delete department - it has associated students or faculty.'; break;
                    case 'not_found': echo 'Department not found.'; break;
                    case 'missing_id': echo 'Department ID is required.'; break;
                    default: echo 'An error occurred. Please try again.'; break;
                }
                ?>
            </span>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">Departments</h1>
                <p class="page-subtitle">Manage all departments</p>
            </div>
            <div class="header-actions">
                <a href="entities?type=department" class="add-btn">
                    <i class="fas fa-plus"></i>
                    Add Department
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?php echo $total_departments; ?></div>
                <div class="stat-label">Total Departments</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon active">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?php echo $active_departments; ?></div>
                <div class="stat-label">Active</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon inactive">
                <i class="fas fa-pause-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?php echo $inactive_departments; ?></div>
                <div class="stat-label">Inactive</div>
            </div>
        </div>
    </div>

    <!-- Departments Grid -->
    <div class="departments-container">
        <?php if (empty($departments)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>No Departments Found</h3>
                <p>Start by adding your first department to the system.</p>
                <a href="entities?type=department" class="empty-action-btn">
                    <i class="fas fa-plus"></i>
                    Add First Department
                </a>
            </div>
        <?php else: ?>
            <div class="departments-grid">
                <?php foreach ($departments as $department): ?>
                    <?php require 'Components/Department_Card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>



    <script>
        // Auto-hide status messages
        document.addEventListener('DOMContentLoaded', function() {
            const statusMessages = document.querySelectorAll('.success-message, .error-message');
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
