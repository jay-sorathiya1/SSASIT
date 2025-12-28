<?php
require 'DB/connection.php';
require 'Doe/Count_Query.php';
require 'Services/Verify-User.php';


// Handle logout
if (isset($_GET['logout'])) {
    session_start();
    session_unset();
    session_destroy();
    header('Location: Authentication?logout=success');
    exit();
}

function getTotal($table = 'person', $designation = '', $status = '')
{
    global $conn;
    $data = allCount($conn, $designation, $status,$table);
    if (!$data) {
        return 0;
    }
    $user = [];

    while ($result = $data->fetch_assoc()) {

        $user[] = $result;
    }
    return $user[0]['total'];
}

// $data = Student_Count($conn, '');
// $user = [];

// while ($result = $data->fetch_assoc()) {
//     $user[] = $result;
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSASIT - Admin Dashboard</title>
    <!-- CSS files -->
    <?php require 'config/Icon-Config.php'; ?>
    <link rel="stylesheet" href="Css/Hero.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="Css/Card.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="Css/Dashboard.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php require 'Components/Header.php'; ?>
    <div class="dashboard-container">
        <?php require 'Components/Hero.php'; ?>
        <?php require 'Components/Card.php'; ?>
    </div>
</body>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const welcomeSection = document.querySelector('.welcome-section');
        const cards = document.querySelectorAll('.dashboard-card');

        // Animate welcome section
        welcomeSection.style.opacity = '0';
        welcomeSection.style.transform = 'translateY(20px)';

        setTimeout(() => {
            welcomeSection.style.transition = 'all 0.6s ease';
            welcomeSection.style.opacity = '1';
            welcomeSection.style.transform = 'translateY(0)';
        }, 100);

        // Animate cards with stagger effect
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';

            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 200 + (index * 100));
        });
    });

    // Add touch support for mobile devices
    if ('ontouchstart' in window) {
        dashboardCards.forEach(card => {
            card.addEventListener('touchstart', function () {
                this.style.transform = 'translateY(-3px) scale(1.01)';
            });

            card.addEventListener('touchend', function () {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }

    // Prevent back button after logout
    window.addEventListener('popstate', function (e) {
        if (window.location.search.includes('logout=success')) {
            window.location.replace('Authentication');
        }
    });

    // Security: Clear sensitive data on page unload
    window.addEventListener('beforeunload', function () {
        // Clear any sensitive data if needed
        sessionStorage.clear();
    });
    const cards = document.querySelectorAll('.user-card');
    cards.forEach((card,index) => {
        card.style.delay = `${index * 0.1}s`;
    })
    // // Add visual feedback for successful operations
    // function showSuccessMessage(message) {
    //     const successDiv = document.createElement('div');
    //     successDiv.style.cssText = `
    //             position: fixed;
    //             top: 20px;
    //             right: 20px;
    //             background: var(--success-color);
    //             color: white;
    //             padding: 1rem 1.5rem;
    //             border-radius: 0.6rem;
    //             font-family: var(--primary-font);
    //             font-weight: 600;
    //             z-index: 1000;
    //             animation: slideIn 0.3s ease;

    //             @keyframes slideIn {
    //             from {
    //                 opacity: 0;
    //                 transform: translateX(100%);
    //             }
    //             to {
    //                 opacity: 1;
    //                 transform: translateX(0);
    //             }
    //         }
    //         `;
    //     successDiv.textContent = message;
    //     document.body.appendChild(successDiv);

    //     setTimeout(() => {
    //         successDiv.remove();
    //     }, 3000);
    // }

    // // Add CSS animation for success message
    // const style = document.createElement('style');
    // style.textContent = `
    //         @keyframes slideIn {
    //             from {
    //                 opacity: 0;
    //                 transform: translateX(100%);
    //             }
    //             to {
    //                 opacity: 1;
    //                 transform: translateX(0);
    //             }
    //         }
    //     `;
    // document.head.appendChild(style);
</script>

</html>