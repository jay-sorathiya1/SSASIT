<?php
$admin_username = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';
?>
<link rel="stylesheet" href="Css/Header.css?v=<?php echo time(); ?>">

<div class="dashboard-header">
    <div class="header-content">
        <div class="header-left">
            <a href="Dashboard"><img src="Public/Icon/SSASIT.png" alt="SSASIT Logo" class="header-logo"
                    onerror="this.src='https://via.placeholder.com/50x50/036ce2/ffffff?text=SSASIT'"></a>
            <h1 class="header-title">SSASIT</h1>
        </div>
        <div class="header-right">
            <a href="Dashboard?logout=1" class="logout-btn" onclick="return confirmLogout()">
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>

<script>
    window.addEventListener('scroll', function () {
        const header = document.querySelector('.dashboard-header');
        header.style.transition = 'var(--transition)';
        if (window.scrollY > 25) {
            // header.style.boxShadow = '0 4px 10px rgba(3, 108, 226, 0.3)';
            header.style.backgroundColor = 'var(--white)';
            header.style.height = '70px';
        }
        else if (window.scrollY < 30) {
            header.style.backgroundColor = 'transparent';
            header.style.height = '80px';
        }
    });
    // Add loading animation to cards on hover
    // Logout confirmation function
    function confirmLogout() {
        return confirm('Are you sure you want to logout? You will be redirected to the login page.');
    }

    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('mousedown', function () {
            this.style.transform = 'scale(0.98)';
        });

        logoutBtn.addEventListener('mouseup', function () {
            this.style.transform = 'scale(1.02)';
        });

        logoutBtn.addEventListener('mouseleave', function () {
            this.style.transform = 'scale(1)';
        });
    }
</script>