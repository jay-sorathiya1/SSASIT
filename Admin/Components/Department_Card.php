<?php
// Get department data
$dept_id = $department['Dept_ID'] ?? $department['ID'] ?? '';
$dept_name = $department['Dept_Name'] ?? 'Unknown Department';
$dept_description = $department['Dept_Description'] ?? '';
$established_year = $department['Established_Year'] ?? '';
$dept_status = $department['Department_Status'] ?? 'Unknown';
$hod = $department['HOD'] ?? '';

// Get student and faculty counts for this department
$student_count = 0;
$faculty_count = 0;

if (!empty($dept_id)) {
    // Get student count
    $student_query = "SELECT COUNT(*) as count FROM person WHERE Department_ID = ? AND Designation = 'Student'";
    $stmt = mysqli_prepare($conn, $student_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $dept_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $student_count = $result ? $result->fetch_assoc()['count'] : 0;
        mysqli_stmt_close($stmt);
    }
    
    // Get faculty count
    $faculty_query = "SELECT COUNT(*) as count FROM person WHERE Department_ID = ? AND Designation != 'Student'";
    $stmt = mysqli_prepare($conn, $faculty_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $dept_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $faculty_count = $result ? $result->fetch_assoc()['count'] : 0;
        mysqli_stmt_close($stmt);
    }
}

// Get HOD name if available
$hod_name = '';
if (!empty($hod)) {
    $hod_query = "SELECT First_Name, Last_Name FROM person WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $hod_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $hod);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && $result->num_rows > 0) {
            $hod_data = $result->fetch_assoc();
            $hod_name = $hod_data['First_Name'] . ' ' . $hod_data['Last_Name'];
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="department-card">
    <!-- Status Indicator -->
    <div class="status-indicator status-<?php echo strtolower(str_replace(' ', '-', $dept_status)); ?>"></div>
    
    <!-- Department Icon -->
    <div class="dept-placeholder">
        <i class="fas fa-building"></i>
    </div>
    
    <!-- Department Info -->
    <div class="dept-info">
        <h3 class="dept-name"><?php echo htmlspecialchars($dept_name); ?></h3>
        <div class="dept-meta">
            <p class="dept-id">
                <i class="fas fa-id-card"></i>
                ID: <?php echo htmlspecialchars($dept_id); ?>
            </p>
            <?php if (!empty($established_year)): ?>
            <p class="dept-year">
                <i class="fas fa-calendar-alt"></i>
                Est. <?php echo htmlspecialchars($established_year); ?>
            </p>
            <?php endif; ?>
            <?php if (!empty($hod_name)): ?>
            <p class="dept-hod">
                <i class="fas fa-user-tie"></i>
                HOD: <?php echo htmlspecialchars($hod_name); ?>
            </p>
            <?php endif; ?>
        </div>
        
        <!-- Department Stats -->
        <div class="dept-stats">
            <div class="stat-item">
                <i class="fas fa-graduation-cap"></i>
                <span><?php echo $student_count; ?> Students</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-chalkboard-teacher"></i>
                <span><?php echo $faculty_count; ?> Faculty</span>
            </div>
        </div>
    </div>
    
    <!-- Department Description -->
    <?php if (!empty($dept_description)): ?>
    <div class="dept-description">
        <p><?php echo htmlspecialchars(substr($dept_description, 0, 100)) . (strlen($dept_description) > 100 ? '...' : ''); ?></p>
    </div>
    <?php endif; ?>
    
    <!-- Action Buttons -->
    <div class="dept-actions">
        <button class="action-btn view-btn" onclick="viewDepartment('<?php echo $dept_id; ?>')" title="View Details">
            <i class="fas fa-eye"></i>
            <span>View</span>
        </button>
        <button class="action-btn edit-btn" onclick="editDepartment('<?php echo $dept_id; ?>')" title="Edit Department">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </button>
        <button class="action-btn delete-btn" onclick="showDepartmentDeleteModal('<?php echo $dept_id; ?>', '<?php echo htmlspecialchars($dept_name); ?>')" title="Delete Department">
            <i class="fas fa-trash-alt"></i>
            <span>Delete</span>
        </button>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="delete-modal" id="departmentDeleteModal">
    <div class="modal-content">
        <div class="modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 class="modal-title">Confirm Deletion</h3>
        <p class="modal-text">
            Are you sure you want to delete <span class="modal-dept-name" id="modalDeptName"></span>?
            This action cannot be undone and will permanently remove the department from the system.
        </p>
        <div class="modal-actions">
            <button class="modal-btn cancel" onclick="hideDepartmentDeleteModal()">Cancel</button>
            <button class="modal-btn confirm" id="confirmDeptDeleteBtn" onclick="confirmDepartmentDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
    let deleteDeptId = null;

    // Department action functions
    function viewDepartment(deptId) {
        // For now, redirect to edit page as view page
        window.location.href = `Edit_Department?id=${deptId}&mode=view`;
    }

    function editDepartment(deptId) {
        window.location.href = `Edit_Department?id=${deptId}`;
    }

    // Show delete confirmation modal
    function showDepartmentDeleteModal(deptId, deptName) {
        deleteDeptId = deptId;

        document.getElementById('modalDeptName').textContent = deptName;
        document.getElementById('departmentDeleteModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    // Hide delete confirmation modal
    function hideDepartmentDeleteModal() {
        document.getElementById('departmentDeleteModal').classList.remove('show');
        document.body.style.overflow = 'auto';
        deleteDeptId = null;

        // Reset button state
        const confirmBtn = document.getElementById('confirmDeptDeleteBtn');
        confirmBtn.textContent = 'Delete';
        confirmBtn.disabled = false;
    }

    // Confirm delete action
    function confirmDepartmentDelete() {
        if (!deleteDeptId) return;

        const confirmBtn = document.getElementById('confirmDeptDeleteBtn');
        confirmBtn.textContent = 'Deleting...';
        confirmBtn.disabled = true;

        // Create a form and submit it as POST request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `Delete_Department?id=${deleteDeptId}`;
        document.body.appendChild(form);
        form.submit();
    }

    // Event listeners for modal (only add once)
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('departmentDeleteModal');

        if (modal && !modal.hasAttribute('data-listeners-added')) {
            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    hideDepartmentDeleteModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('show')) {
                    hideDepartmentDeleteModal();
                }
            });

            // Mark that listeners have been added
            modal.setAttribute('data-listeners-added', 'true');
        }
    });
</script>
