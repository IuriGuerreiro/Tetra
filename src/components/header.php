<link rel="stylesheet" href="../../public/assets/css/header.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="social-links">
            <a href="https://www.facebook.com/tetramalta" target="_blank" class="social-link">
                <i class="fab fa-facebook-f"></i>
            </a>
        </div>
    </div>
</div>

<header class="main-header">
    <div class="header-container">
        <div class="logo">
            <a href="/src/pages/home.php">
                <h1>TETRA</h1>
            </a>
        </div>
        
        <nav class="main-nav">
            <ul class="nav-links">
                <li><a href="./home.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="./cpds.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'cpds.php' ? 'active' : ''; ?>">CPDs</a></li>
            </ul>
        </nav>
        <div class="mobile-menu-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>

<!-- Mobile Navigation -->
<div class="mobile-nav">
    <ul class="mobile-nav-links">
        <li><a href="/src/pages/home.php">Home</a></li>
        <li><a href="/src/pages/cpds.php">CPDs</a></li>
    </ul>
</div>

<script src="../../public/assets/js/header.js"></script> 