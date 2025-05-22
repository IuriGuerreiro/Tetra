<?php
// Include the database configuration
require_once '../config/config.php';

// Including the header
include '../components/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TETRA - Teacher Training Academy</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://new.tetra.com.mt/public/assets/images/favicon.png">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="../../public/assets/css/home.css" as="style">
    <link rel="preload" href="../../public/assets/css/hero.css" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style">
    
    <!-- Critical CSS -->
    <style>
        body { 
            margin: 0;
            opacity: 0;
            transition: opacity .3s ease;
            background: #111;
        }
        .loaded { opacity: 1; }
    </style>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../public/assets/css/home.css">
    <link rel="stylesheet" href="../../public/assets/css/hero.css">
    <link rel="stylesheet" href="../../public/assets/css/animations.css">
    <link rel="stylesheet" href="../../public/assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Load only the Font Awesome icons we use -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/solid.min.css" integrity="sha512-pZlKGs7nEqF4zoG0egeK167l6yovsuL8ap30d07kA5AJUq+WysFlQ02DLXAmN3n0+H3JVz5ni8SJZnrOaYXWBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <!-- Triangle logo -->
            <div class="triangle-logo">
                <img src="../../public/assets/images/favicon.png" alt="TETRA Logo">
            </div>
            
            <!-- Cycling phrases container -->
            <div class="cycling-phrases">
                <div class="phrase active" id="phrase1">
                    <h1>TEACHER TRAINING ACADEMY</h1>
                </div>
                <div class="phrase" id="phrase2">
                    <h1>YOUR EDUCATION SOLUTION</h1>
                </div>
                <div class="phrase" id="phrase3">
                    <h1>TEACH, LEARN, CONNECT</h1>
                </div>
            </div>
            
            <!-- Indicator dots -->
            <div class="dots-container">
                <div class="dot active" data-index="0"></div>
                <div class="dot" data-index="1"></div>
                <div class="dot" data-index="2"></div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services">
            <div class="container">
                <div class="service-card">
                    <i class="fas fa-certificate fa-2x"></i>
                    <h3>Provider Accreditation</h3>
                    <p>We turn your training institute or department into a fully fledged accredited educational institution.</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-award fa-2x"></i>
                    <h3>Course Accreditation</h3>
                    <p>We transform your certificates of attendance into internationally recognised certificates of achievement according to the European Qualifications Framework (EQF)</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-book-open fa-2x"></i>
                    <h3>Materials and Content</h3>
                    <p>We design and develop engaging content and materials for both facilitator and learner.</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    <h3>Teacher Training</h3>
                    <p>We train teachers to become facilitators to motivate students to become masters.</p>
                </div>
            </div>
        </section>

        <!-- ELT Section -->
        <section class="elt-section">
            <div class="container">
                <h2 class="animate-fade-in">TEACHING ENGLISH IN MALTA</h2>
                <p class="animate-slide-up" data-delay="0.1">The importance of the ELT segment to our tourism industry can perhaps be summed up by the fact that ELT attracts some 80,000 visitors to our islands every year, amounting to nearly 5% of total tourist arrivals to our islands.</p>
                <p class="animate-slide-up" data-delay="0.2">Putting it simply – these visitors need teachers – and that is where we come in.</p>
                
                <h3 class="animate-slide-up" data-delay="0.3">What do I need to become an English teacher?</h3>
                
                <div class="requirements">
                    <div class="requirement-group">
                        <h4>If you are under 21 years-old:</h4>
                        <ul>
                            <li>A TEFL induction certificate (approved by the ELT council)</li>
                            <li>A pass in TELT or an A' Level in English (minimum grade C)</li>
                            <li>A Pass in SEPTT</li>
                            <li>A matriculation standard of education (42 points in your A-levels)</li>
                            <li>A clean police conduct</li>
                        </ul>
                    </div>
                    
                    <div class="requirement-group">
                        <h4>If you are over 21 years-old:</h4>
                        <ul>
                            <li>A TEFL induction certificate (approved by the ELT council)</li>
                            <li>A pass in TELT or an A' Level in English (minimum grade C)</li>
                            <li>A pass in SEPTT</li>
                            <li>A clean police conduct</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- TEFL Section -->
        <section class="tefl-section">
            <div class="container">
                <div class="tefl-content">
                    <div class="tefl-text">
                        <h2 class="animate-fade-in" data-delay="0.1">What is the TEFL induction certificate?</h2>
                        <p class="animate-slide-right" data-delay="0.2">This is what you get when you successfully complete our 60-hour* TEFL Cert. Course. This is the course that teaches you how to teach the language. Many think that through this course you learn the details of the English language – the grammar, rules and bits and bobs of the language – this is where the many are wrong. We have another course for that.</p>
                        <p class="animate-slide-right" data-delay="0.3">This is the fun one – this is the course that shows you how to engage and facilitate. Forget those boring lectures and lessons. Our sessions take on a workshop style where you, the candidate, are the main participant. We show you how to be the most effective, efficient, engaging and hands-on teacher that you can be.</p>
                    </div>
                    <div class="tefl-image animate-zoom-in" data-delay="0.4">
                        <img src="../../public/assets/images/home/Certificate-of-Participation.jpg" alt="TEFL Certificate Sample" class="certificate-img">
                    </div>
                </div>
            </div>
        </section>
        <!-- Stats Section -->
        <section class="stats">
            <div class="container">
                <div class="stat-card">
                    <i class="fas fa-user-graduate fa-2x"></i>
                    <h3>450</h3>
                    <p>Teachers Trained</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-book fa-2x"></i>
                    <h3>98</h3>
                    <p>Courses Designed</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-star fa-2x"></i>
                    <h3>10</h3>
                    <p>Provider Accreditations</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock fa-2x"></i>
                    <h3>5000</h3>
                    <p>CPD Hours Delivered</p>
                </div>
            </div>
        </section>

        <!-- Services & CPD Section -->
        <section class="cpd-section">
            <div class="container">
                <h2 class="animate-fade-in">Our Services</h2>
                <div class="cpd-content">
                    <div class="animate-slide-up" data-delay="0.1">
                        <h3>Professional Development for English Language Educators</h3>
                    </div>
                    <div class="animate-slide-up" data-delay="0.2">
                        <p>TETRA specializes in delivering ELT Council-approved CPD sessions designed to transform your teaching practice and advance your career in English language education.</p>
                    </div>
                    <div class="animate-slide-up" data-delay="0.3">
                        <a href="cpds.php" class="cta-button">
                            <i class="fas fa-graduation-cap"></i> Explore CPD Sessions
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../components/footer.php'; ?>
    
    <!-- Performance optimization script -->
    <script src="../../public/assets/js/hero.js"></script>
    <script src="../../public/assets/js/scroll-animations.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('loaded');
            
            // Stats animation
            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            document.querySelectorAll('.stat-card').forEach(card => {
                statsObserver.observe(card);
            });
            
            // Hero section functionality is now in hero.js
        });
    </script>
</body>
</html>

