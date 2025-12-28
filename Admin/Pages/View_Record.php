<?php
require 'DB/connection.php';
require 'Services/Verify-User.php';
require 'Doe/ViewAll-Query.php';

// Get record ID and type from URL parameters
$record_id = isset($_GET['Id']) ? $_GET['Id'] : '';
$record_type = isset($_GET['type']) ? $_GET['type'] : '';

// Fetch record data
$record_fetched = FindByID($conn, $record_id, $record_type);
$record_data = [];
while ($result = $record_fetched->fetch_assoc()) {
    $record_data = $result;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSASIT - View Profile</title>
    <?php require 'config/Icon-Config.php'; ?>
    <link rel="stylesheet" href="Css/View_Record.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php require 'Components/Header.php'; ?>
    <div class="profile-container">
        <a href="Entities_Record?type=<?php echo $record_type?>" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Records
        </a>

        <?php if (!empty($record_data)): ?>
            <div class="profile-card">
                <div class="profile-header">
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <!-- <a href="View.php?type=<?php echo $record_type; ?>" class="action-btn back" title="Back to List">
                        <i class="fas fa-arrow-left"></i>
                    </a> -->
                        <a href="Edit_Record?type=<?php echo $record_type; ?>&id=<?php echo $record_id; ?>"
                            class="action-btn edit" title="Edit Profile">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="action-btn delete" onclick="showDeleteModal()" title="Delete Profile">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <img src="Public/uploads/<?php echo htmlspecialchars($record_data['Photo'] ?? 'SSASIT.png'); ?>"
                        alt="Profile Photo" class="profile-avatar" onerror="this.src='Public/Images/SSASIT.png'">
                    <h1 class="profile-name">
                        <?php echo htmlspecialchars(ucfirst($record_data['First_Name'] ?? '') . ' ' . ucfirst($record_data['Last_Name'] ?? '')); ?>
                    </h1>
                    <p class="profile-designation">
                        <?php echo htmlspecialchars($record_data['Designation'] ?? ucfirst($record_type)); ?>
                    </p>
                </div>

                <div class="profile-body">
                    <div class="info-grid">
                        <!-- Personal Information -->
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-user"></i>
                                Personal Information
                            </h3>
                            <div class="info-item">
                                <span class="info-label">ID</span>
                                <span class="info-value"><?php echo htmlspecialchars($record_data['ID'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Date of Birth</span>
                                <span
                                    class="info-value"><?php echo htmlspecialchars($record_data['DOB'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Gender</span>
                                <span
                                    class="info-value"><?php echo htmlspecialchars($record_data['Gender'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status</span>
                                <span class="info-value">
                                    <span class="status-badge <?php
                                    $status = strtolower($record_data['Status'] ?? '');
                                    echo $status === 'active' ? 'status-active' :
                                        ($status === 'graduated' ? 'status-graduated' : 'status-inactive');
                                    ?>">
                                        <?php echo htmlspecialchars($record_data['Status'] ?? 'N/A'); ?>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-address-book"></i>
                                Contact Information
                            </h3>
                            <div class="info-item">
                                <span class="info-label">Email</span>
                                <span
                                    class="info-value"><?php echo htmlspecialchars($record_data['Email'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Mobile</span>
                                <span
                                    class="info-value"><?php echo htmlspecialchars($record_data['Mobile'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Address</span>
                                <span
                                    class="info-value"><?php echo htmlspecialchars($record_data['Address'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">City</span>
                                <span
                                    class="info-value"><?php echo htmlspecialchars($record_data['City'] ?? 'N/A'); ?></span>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-graduation-cap"></i>
                                Academic Information
                            </h3>
                            <div class="info-item">
                                <span class="info-label">Department</span>
                                <span
                                    class="info-value"><?php echo htmlspecialchars($record_data['Dept_Name'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Qualification</span>
                                <span
                                    class="info-value"><?php echo htmlspecialchars($record_data['Qualification'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <span
                                    class="info-label"><?php echo $record_type === 'student' ? 'Admission Date' : 'Joining Date'; ?></span>
                                <span
                                    class="info-value"><?php echo htmlspecialchars($record_data['Admission_Date'] ?? $record_data['Joining_Date'] ?? 'N/A'); ?></span>
                            </div>
                            <?php if ($record_type === 'faculty' && isset($record_data['Experience'])): ?>
                                <div class="info-item">
                                    <span class="info-label">Experience</span>
                                    <span class="info-value"><?php echo htmlspecialchars($record_data['Experience']); ?>
                                        years</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="profile-card">
                <div class="profile-body" style="text-align: center; padding: 3rem;">
                    <i class="fas fa-exclamation-triangle"
                        style="font-size: 3rem; color: var(--error-color); margin-bottom: 1rem;"></i>
                    <h2 style="color: var(--text-color); margin-bottom: 1rem;">Record Not Found</h2>
                    <p style="color: #64748b;">The requested record could not be found or may have been deleted.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="modal-title">Confirm Deletion</h3>
            <p class="modal-text">
                Are you sure you want to delete
                <strong><?php echo htmlspecialchars(($record_data['First_Name'] ?? '') . ' ' . ($record_data['Last_Name'] ?? '')); ?></strong>?
                This action cannot be undone.
            </p>
            <div class="modal-actions">
                <button class="modal-btn cancel" onclick="hideDeleteModal()">Cancel</button>
                <button class="modal-btn confirm" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function showDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function hideDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function confirmDelete() {
            const deleteBtn = document.querySelector('.modal-btn.confirm');
            deleteBtn.textContent = 'Deleting...';
            deleteBtn.disabled = true;

            // Redirect to delete handler
            setTimeout(() => {
                window.location.href = `Delete?type=<?php echo $record_type; ?>&Id=<?php echo $record_id; ?>`;
            }, 500);
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function () {
            const profileCard = document.querySelector('.profile-card');

            // Add intersection observer for subtle animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            if (profileCard) {
                observer.observe(profileCard);
            }

            // Modal event listeners
            const modal = document.getElementById('deleteModal');

            // Close modal when clicking outside
            modal.addEventListener('click', function (e) {
                if (e.target === this) {
                    hideDeleteModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    hideDeleteModal();
                }
            });

            // Add ripple effect to action buttons
            document.querySelectorAll('.action-btn, .modal-btn').forEach(button => {
                button.addEventListener('click', function (e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.6);
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        pointer-events: none;
                    `;

                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>