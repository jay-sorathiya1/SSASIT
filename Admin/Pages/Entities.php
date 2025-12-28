<?php
require 'Services/Verify-User.php';

$entity_type = isset($_GET['type']) ? $_GET['type'] : 'student';
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - SSASIT Admin</title>
    <?php require 'config/Icon-Config.php'; ?>
    <link rel="stylesheet" href="Css/Entities_Form.css?v=<?php echo time(); ?>">

</head>
<style>
    body {
        font-family: var(--primary-font);
        background: var(--bg-gradient);
        min-height: 100vh;
        /* padding: 1.25rem; */
    }


    .success-message,
    .field-error {
        position: fixed;
        bottom: 1rem;
        right: 1.2rem;
        background: var(--success-color);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.6rem;
        font-family: var(--primary-font);
        font-weight: 600;
        z-index: 1000;
        animation: slideIn 0.3s ease;
        transition: all .3s ease;
        overflow: hidden;
    }

    .success-message::before,
    .field-error::before {
        content: '';
        position: absolute;
        width: 100%;
        align-items: center;
        bottom: 0;
        height: 100%;
        left: 0;
        /* border-radius: 0.6rem; */
        border-bottom: .3rem solid #ffe3e6;
        animation: width 3s linear forwards
    }

    .success-message::before {
        border-bottom: .3rem solid #e3ffe6;
    }

    .field-error {
        background: var(--error-color);
    }

    @keyframes width {
        to {
            width: 0;
        }
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
        <div class="success-message">Record Added Successfully</div>
    <?php } ?>
    <?php if ($status === 'field') { ?>
        <div class="field-error">Record Not Inserted</div>
    <?php } ?>
    <?php require 'Components/Header.php'; ?>
    <?php require 'Components/Entities-Form.php'; ?>
</body>

<script>
    const successMessage = document.querySelector('.success-message,.field-error');
    if (successMessage) {
        setTimeout(() => {
            successMessage.remove();
            removeUrlParameter('status');
        }, 3000);
    }
    function removeUrlParameter(parameter) {
        // Create a URL object from the current URL
        const url = new URL(window.location.href);

        // Use the searchParams API to delete the specified parameter
        url.searchParams.delete(parameter);

        // Update the URL in the browser without reloading the page
        window.history.replaceState({}, '', url.toString());
    }


</script>

</html