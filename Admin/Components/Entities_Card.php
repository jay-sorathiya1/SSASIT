<?php
$type = isset($_GET['type']) ? $_GET['type'] : 'student';

$result = allCount($conn, '', '', ($type === 'department') ? 'department' : 'person');
$result = $result->fetch_assoc();

?>
<div class="user-card">
    <!-- Status Indicator -->
    <?php if (isset($value['Status'])): ?>
    <div class="status-indicator status-<?php echo strtolower($value['Status']); ?>"></div>
    <?php endif; ?>

    <div class="profile-placeholder">
        <img alt="avatar" src="Public/Uploads/<?php echo $value['Photo']; ?>" class="profile-img"></img>
    </div>
    <div class="user-info">
        <h3 class="user-name"><?php echo ucfirst($value['First_Name'] . " " . $value['Last_Name']); ?></h3>
        <div class="user-meta">
            <p class="user-id">
                <i class="fas fa-id-card"></i>
                <?php echo $value['ID']; ?>
            </p>
            <p class="user-designation">
                <i class="fas fa-<?php echo ($type === 'student') ? 'graduation-cap' : (($type === 'faculty') ? 'chalkboard-teacher' : 'building'); ?>"></i>
                <?php
                if (isset($value['Designation']) && !empty($value['Designation'])) {
                    echo htmlspecialchars($value['Designation']);
                } else {
                    echo ucfirst($type);
                }
                ?>
            </p>
            <p class="user-date">
                <i class="fas fa-calendar-alt"></i>
                <?php
                $dateField = ($type === 'student') ? 'Joining_Date' : 'Admission_Date';
                $dateLabel = ($type === 'student') ? 'Joined' : 'Joined';

                if (isset($value[$dateField]) && !empty($value[$dateField])) {
                    $date = new DateTime($value[$dateField]);
                    echo "$dateLabel: " . $date->format('M Y');
                } else {
                    echo "$dateLabel: N/A";
                }
                ?>
            </p>
            <?php if (isset($value['Dept_Name']) && !empty($value['Dept_Name'])): ?>
            <p class="department-badge">
                <i class="fas fa-building"></i>
                <?php echo htmlspecialchars($value['Dept_Name']); ?>
            </p>
            <?php endif; ?>
        </div>
    </div>
    <div class="action-menu">
        <button class="menu-btn">
            <i class="fas fa-ellipsis-vertical"></i>
        </button>
        <div class="dropdown-menu">
            <a href="View-Record?Id=<?php echo $value['ID'] ?>&type=<?php echo $type ?>"
                class="dropdown-item view-item">
                <i class="fas fa-eye"></i>
                View Details
            </a>
            <div class="dropdown-item edit-item" onclick="sending()">
                <i class="fas fa-edit"></i>
                Edit
            </div>
            <div class="dropdown-item delete-item" onclick="showDeleteModal('<?php echo $value['ID']; ?>', '<?php echo htmlspecialchars(ucfirst($value['First_Name'] . ' ' . $value['Last_Name'])); ?>', '<?php echo $type; ?>')">
                <i class="fas fa-trash"></i>
                Delete
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="delete-modal" id="deleteModal">
    <div class="modal-content">
        <div class="modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 class="modal-title">Confirm Deletion</h3>
        <p class="modal-text">
            Are you sure you want to delete <span class="modal-user-name" id="modalUserName"></span>?
            This action cannot be undone.
        </p>
        <div class="modal-actions">
            <button class="modal-btn cancel" onclick="hideDeleteModal()">Cancel</button>
            <button class="modal-btn confirm" id="confirmDeleteBtn" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
    let deleteUserId = null;
    let deleteUserType = null;

    // Show delete confirmation modal
    function showDeleteModal(userId, userName, userType) {
        deleteUserId = userId;
        deleteUserType = userType;

        document.getElementById('modalUserName').textContent = userName;
        document.getElementById('deleteModal').classList.add('show');
        document.body.style.overflow = 'hidden';

        // Close any open dropdown menus
        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
            menu.classList.remove('show');
        });
        document.querySelectorAll('.user-card.menu-open').forEach(card => {
            card.classList.remove('menu-open');
        });
    }

    // Hide delete confirmation modal
    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
        document.body.style.overflow = 'auto';
        deleteUserId = null;
        deleteUserType = null;

        // Reset button state
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.textContent = 'Delete';
        confirmBtn.disabled = false;
    }

    // Confirm delete action
    function confirmDelete() {
        if (!deleteUserId || !deleteUserType) return;

        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.textContent = 'Deleting...';
        confirmBtn.disabled = true;

        // Redirect to delete handler after short delay
        setTimeout(() => {
            window.location.href = `Delete?Id=${deleteUserId}&type=${deleteUserType}`;
        }, 500);
    }

    // Event listeners for modal
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('deleteModal');

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideDeleteModal();
            }
        });
    });
    function sending(){
        window.location.href = 'Edit_Record?type=<?php echo $type ?>&id=<?php echo $value['ID'] ?>';
    }
</script>