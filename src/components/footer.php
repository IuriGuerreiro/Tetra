<?php
// Footer do site
?>
<footer class="bg-black text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Company Info -->
            <div class="text-center md:text-left">
                <h3 class="text-xl font-semibold text-tetra-green mb-4">TETRA</h3>
                <p class="text-gray-400 mb-4">Empowering educators through professional development and innovative learning solutions.</p>
                <div class="flex items-center justify-center md:justify-start space-x-4">
                    <a href="https://www.facebook.com/tetramalta" target="_blank" 
                       class="w-8 h-8 rounded-full bg-[rgba(255,255,255,0.1)] hover:bg-[rgba(255,255,255,0.2)] transition-colors duration-300 flex items-center justify-center">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="text-center">
                <h3 class="text-xl font-semibold text-tetra-green mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="home.php" class="text-gray-400 hover:text-tetra-green transition-colors duration-300">Home</a>
                    </li>
                    <li>
                        <a href="cpds.php" class="text-gray-400 hover:text-tetra-green transition-colors duration-300">CPDs</a>
                    </li>
                    <li>
                        <a href="erasmusCourses.php" class="text-gray-400 hover:text-tetra-green transition-colors duration-300">Erasmus KA1 Courses</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="text-center md:text-right">
                <h3 class="text-xl font-semibold text-tetra-green mb-4">Contact Us</h3>
                <div class="space-y-2">
                    <p class="text-gray-400">
                        <i class="fas fa-phone mr-2 text-tetra-green"></i>
                        <a href="tel:+35699660124" class="hover:text-tetra-green transition-colors duration-300">+356 99660124</a>
                    </p>
                    <p class="text-gray-400">
                        <i class="fas fa-envelope mr-2 text-tetra-green"></i>
                        <a href="mailto:info@tetra.com.mt" class="hover:text-tetra-green transition-colors duration-300">info@tetra.com.mt</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
            <p>&copy; <?php echo date('Y'); ?> TETRA. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.tailwindcss.com"></script>
<script src="./public/assets/script.js"></script>
<script src="./public/assets/home.js"></script>
</body>
</html> 