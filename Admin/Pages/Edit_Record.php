<?php
require 'DB/connection.php';
require 'Services/Verify-User.php';
require 'Doe/ViewAll-Query.php';

// Get record ID and type from URL parameters
$record_id = isset($_GET['id']) ? $_GET['id'] : '';
$record_type = isset($_GET['type']) ? $_GET['type'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Validate required parameters
if (empty($record_id) || empty($record_type)) {
    header('Location: Dashboard');
    exit();
}

// Fetch record data
$record_fetched = FindByID($conn, $record_id, $record_type);
$record_data = [];
if ($record_fetched && $record_fetched->num_rows > 0) {
    while ($result = $record_fetched->fetch_assoc()) {
        $record_data = $result;
    }
} else {
    // Record not found, redirect to dashboard
    header('Location: Dashboard');
    exit();
}

// Fetch departments for dropdown
$departments_query = "SELECT * FROM department WHERE Department_Status = 'active'";
$departments_result = mysqli_query($conn, $departments_query);
$departments = [];
if ($departments_result) {
    while ($dept = $departments_result->fetch_assoc()) {
        $departments[] = $dept;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSASIT - Edit Profile</title>
    <?php require 'config/Icon-Config.php'; ?>
    <link rel="stylesheet" href="Css/Edit_Profile.css?v=<?php echo time(); ?>">
</head>

<style>
    /* Success/Error Messages */
    .success-message,
    .error-message {
        position: fixed;
        top: 2rem;
        right: 2rem;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        z-index: 1000;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .success-message {
        background: #dcfce7;
        color: #166534;
        border-left: 4px solid #22c55e;
    }

    .error-message {
        background: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .success-message::before {
        content: '✓ ';
        font-weight: bold;
    }

    .error-message::before {
        content: '✗ ';
        font-weight: bold;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<body>
    <?php if ($status === 'success') { ?>
        <div class="success-message">Profile Updated Successfully</div>
    <?php } ?>
    <?php if ($status === 'error') { ?>
        <div class="error-message">Failed to Update Profile</div>
    <?php } ?>
    <?php if ($status === 'validation') { ?>
        <div class="error-message">Please fill all required fields correctly</div>
    <?php } ?>

    <?php require 'Components/Header.php'; ?>
    
    <div class="edit-container">
        <div class="back-navigation">
            <a href="View-Record?Id=<?php echo $record_id; ?>&type=<?php echo $record_type; ?>" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Profile</span>
            </a>
        </div>

        <?php require 'Components/Edit-Profile-Form.php'; ?>
    </div>

    <script>
        // Auto-hide success/error messages
        setTimeout(function() {
            const messages = document.querySelectorAll('.success-message, .error-message');
            messages.forEach(function(message) {
                message.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(function() {
                    message.remove();
                }, 300);
            });
        }, 4000);

        // Add slideOut animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOut {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(100%);
                }
            }
        `;
        document.head.appendChild(style);

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editProfileForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(function(field) {
                        const errorSpan = field.parentNode.querySelector('.error-message');
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('error');
                            if (errorSpan) {
                                errorSpan.textContent = 'This field is required';
                                errorSpan.style.display = 'block';
                            }
                        } else {
                            field.classList.remove('error');
                            if (errorSpan) {
                                errorSpan.style.display = 'none';
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        const firstError = form.querySelector('.error');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstError.focus();
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
