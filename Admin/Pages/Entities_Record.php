<?php
require 'DB/connection.php';
require 'Services/Verify-User.php';
require 'Doe/ViewAll-Query.php';
require 'Doe/Delete_Record_Query.php';
require 'Doe/Count_Query.php';

// echo 'this view page';

$view_type = isset($_GET['type']) ? $_GET['type'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$data = viewAll($conn, $view_type);
$user = [];

while ($result = $data->fetch_assoc()) {
    $user[] = $result;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All <?php echo $view_type; ?> - SSASIT Admin</title>
    <?php require 'config/Icon-Config.php'; ?>
    <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="Css/Entities_Card.css?v=<?php echo time(); ?>">
</head>

<style>
    body {
        font-family: var(--primary-font);
        background: var(--bg-gradient);
        min-height: 100vh;
        /* padding: 2rem; */
    }

    /* Card Container */
    .card-container {
        max-width: 1200px;
        margin: 2rem auto;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 1.5rem;
    }

    /* No Data Found Styles */
    .no-data-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
        text-align: center;
        padding: 2rem;
        animation: fadeInUp 0.8s ease-out;
    }

    .no-data-icon {
        width: 120px;
        height: 120px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        animation: bounce 2s infinite;
        position: relative;
        overflow: hidden;
    }

    .no-data-icon::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        animation: shimmer 3s infinite;
    }

    .no-data-icon i {
        font-size: 3rem;
        color: var(--secondary-color);
        z-index: 2;
    }

    .no-data-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 1rem;
        animation: slideInLeft 0.8s ease-out 0.2s both;
    }

    .no-data-message {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 2.5rem;
        max-width: 500px;
        line-height: 1.6;
        animation: slideInRight 0.8s ease-out 0.4s both;
    }

    .no-data-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
        animation: slideInUp 0.8s ease-out 0.6s both;
    }

    .action-button {
        background: var(--button-gradient);
        color: var(--white);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(3, 108, 226, 0.3);
        position: relative;
        overflow: hidden;
    }

    .action-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .action-button:hover::before {
        left: 100%;
    }

    .action-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(3, 108, 226, 0.4);
    }

    .action-button.secondary {
        background: var(--white);
        color: var(--secondary-color);
        border: 2px solid var(--secondary-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .action-button.secondary:hover {
        background: var(--secondary-color);
        color: var(--white);
        box-shadow: 0 8px 25px rgba(3, 108, 226, 0.3);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-10px);
        }

        60% {
            transform: translateY(-5px);
        }
    }

    @keyframes shimmer {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design for No Data */
    @media (max-width: 768px) {
        .no-data-container {
            padding: 1.5rem;
            min-height: 50vh;
        }

        .no-data-icon {
            width: 100px;
            height: 100px;
            margin-bottom: 1.5rem;
        }

        .no-data-icon i {
            font-size: 2.5rem;
        }

        .no-data-title {
            font-size: 1.75rem;
            margin-bottom: 0.75rem;
        }

        .no-data-message {
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .no-data-actions {
            flex-direction: column;
            width: 100%;
            max-width: 300px;
        }

        .action-button {
            width: 100%;
            justify-content: center;
            padding: 0.875rem 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .no-data-container {
            padding: 1rem;
            min-height: 45vh;
        }

        .no-data-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }

        .no-data-icon i {
            font-size: 2rem;
        }

        .no-data-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .no-data-message {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .action-button {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }
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
    <?php require 'Components/Header.php'; ?>
    <?php if ($status === 'success') { ?>
        <div class="success-message">Record Deleted Successfully</div>
    <?php } ?>
    <?php if ($status === 'field') { ?>
        <div class="field-error">Record Not Deleted</div>
    <?php } ?>

    <?php if (empty($user)) { ?>
        <div class="no-data-container">
            <div class="no-data-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h1 class="no-data-title">No <?php echo ucfirst($view_type); ?> Found</h1>
            <p class="no-data-message">
                It looks like there are no <?php echo $view_type; ?> records in the system yet.
                Get started by adding your first <?php echo $view_type; ?> or return to the dashboard to explore other
                options.
            </p>
            <div class="no-data-actions">
                <a href="entities?type=<?php echo $view_type; ?>" class="action-button">
                    <i class="fas fa-plus"></i>
                    Add New <?php echo ucfirst($view_type); ?>
                </a>
                <a href="Dashboard" class="action-button secondary">
                    <i class="fas fa-home"></i>
                    Go to Dashboard
                </a>
            </div>
        </div>
    <?php } ?>

    <div class="card-container">
        <?php foreach ($user as $key => $value) { ?>
            <?php require 'Components/Entities_Card.php'; ?>
        <?php } ?>
    </div>


    <script>
        window.addEventListener('load', function () {<?php $data = viewAll($conn, $view_type);?>});
        // Three dot menu handlers
        document.querySelectorAll('.menu-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const dropdown = this.nextElementSibling;
                const isOpen = dropdown.classList.contains('show');

                // Close all other dropdowns and remove menu-open class
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
                document.querySelectorAll('.user-card').forEach(card => {
                    card.classList.remove('menu-open');
                });

                // Toggle current dropdown
                if (!isOpen) {
                    dropdown.classList.add('show');
                    this.closest('.user-card').classList.add('menu-open');
                }

                // Button click animation
                this.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });


        // Close dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.action-menu')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
                document.querySelectorAll('.user-card').forEach(card => {
                    card.classList.remove('menu-open');
                });
            }
        });
        const successMessage = document.querySelector('.success-message,.field-error');
        if (successMessage) {
            setTimeout(() => {
                successMessage.remove();
                removeUrlParameter('status');
                // para.removeUrlParameter('status')
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

        const Records = document.querySelectorAll('.user-card');
        Records.forEach((record, index) => {
            record.style.animationDelay = `${index * 0.1}s`;
        });



    </script>
</body>

</html>