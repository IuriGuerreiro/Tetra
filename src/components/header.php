<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!-- Remove CSS link since we're using Tailwind -->

<head>
    <link rel="icon" type="image/png" href="https://tetra.com.mt/public/assets/images/favicon.png">
</head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Reset default margins -->
<style>
    body {
        margin: 0;
        padding: 0;
    }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
</style>

<!-- Top Bar -->
<div class="bg-black text-white py-2">
    <div class="container mx-auto px-4">
        <div class="flex justify-end">
            <a href="https://www.facebook.com/tetramalta" target="_blank" 
               class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[rgba(255,255,255,0.1)] hover:bg-[rgba(255,255,255,0.2)] transition-colors duration-300">
                <i class="fab fa-facebook-f"></i>
            </a>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="bg-[#111] text-white shadow-lg sticky top-0 z-50 border-b border-gray-800">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="home.php" class="text-2xl font-bold text-white hover:text-white/80 transition-colors duration-300">
                    TETRA
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:block">
                <ul class="flex space-x-8">
                    <li>
                        <a href="./home.php" 
                           class="<?php echo $currentPage == 'home.php' 
                           ? 'text-tetra-green border-b-2 border-tetra-green' 
                           : 'text-gray-300 hover:text-tetra-green'; ?> px-3 py-2 text-sm font-medium transition-colors duration-300">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="./cpds.php" 
                           class="<?php echo $currentPage == 'cpds.php' 
                           ? 'text-tetra-green border-b-2 border-tetra-green' 
                           : 'text-gray-300 hover:text-tetra-green'; ?> px-3 py-2 text-sm font-medium transition-colors duration-300">
                            CPDs
                        </a>
                    </li>
                    <li>
                        <a href="./erasmusCourses.php" 
                           class="<?php echo $currentPage == 'erasmusCourses.php' 
                           ? 'text-tetra-green border-b-2 border-tetra-green' 
                           : 'text-gray-300 hover:text-tetra-green'; ?> px-3 py-2 text-sm font-medium transition-colors duration-300">
                            Erasmus KA1 courses
                        </a>
                    </li>
                    <li>
                        <a href="./contactUs.php" 
                           class="<?php echo $currentPage == 'contactUs.php' 
                           ? 'text-tetra-green border-b-2 border-tetra-green' 
                           : 'text-gray-300 hover:text-tetra-green'; ?> px-3 py-2 text-sm font-medium transition-colors duration-300">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Mobile Menu Button -->
            <button type="button" class="mobile-menu-btn md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                <span class="sr-only">Open main menu</span>
                <div class="flex flex-col space-y-1.5">
                    <span class="block w-6 h-0.5 bg-current"></span>
                    <span class="block w-6 h-0.5 bg-current"></span>
                    <span class="block w-6 h-0.5 bg-current"></span>
                </div>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Navigation -->
<div class="mobile-nav hidden md:hidden bg-[#111] fixed inset-0 z-40 transform transition-transform duration-300 translate-x-full">
    <div class="pt-5 pb-6 px-4">
        <ul class="space-y-4">
            <li>
                <a href="/src/pages/home.php" 
                   class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-tetra-green hover:bg-gray-700 rounded-md transition-colors duration-300">
                    Home
                </a>
            </li>
            <li>
                <a href="/src/pages/cpds.php" 
                   class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-tetra-green hover:bg-gray-700 rounded-md transition-colors duration-300">
                    CPDs
                </a>
            </li>
            <li>
                <a href="/src/pages/erasmusCourses.php" 
                   class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-tetra-green hover:bg-gray-700 rounded-md transition-colors duration-300">
                    Erasmus KA1 courses
                </a>
            </li>
            <li>
                <a href="/src/pages/contactUs.php" 
                   class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-tetra-green hover:bg-gray-700 rounded-md transition-colors duration-300">
                    Contact Us
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileNav = document.querySelector('.mobile-nav');
    let isOpen = false;

    mobileMenuBtn.addEventListener('click', function() {
        isOpen = !isOpen;
        if (isOpen) {
            mobileNav.classList.remove('translate-x-full');
            mobileNav.classList.remove('hidden');
        } else {
            mobileNav.classList.add('translate-x-full');
            setTimeout(() => {
                mobileNav.classList.add('hidden');
            }, 300);
        }
    });
});
</script> 