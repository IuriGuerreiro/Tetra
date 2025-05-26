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
    <title>TETRA - Education Solution</title>
    
    <meta name="description" content="Professional teacher training and education solutions. TETRA provides CPD sessions, provider accreditation, course development and quality assurance services in Malta.">
    
    <!-- Favicon  that doesnt work for some reason-->
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

        <!-- Services Section -->
        <section class="services">
            <div class="container">
                <h2 class="section-title">Our Services</h2>

                <!-- Professional Development Card -->
                <div class="service-card featured">
                    <div class="service-header">
                        <i class="fas fa-graduation-cap fa-2x"></i>
                        <div class="title-group">
                            <h3>Professional Development for English Language Educators</h3>
                        </div>
                    </div>
                    <div class="service-content">
                        <div class="feature-item highlight">
                            <i class="fas fa-star"></i>
                            <span>TETRA specializes in delivering ELT Council-approved CPD sessions designed to transform your teaching practice and advance your career in English language education.</span>
                        </div>
                        
                        <div class="cta-container">
                            <a href="cpds.php" class="cta-button">
                                <i class="fas fa-graduation-cap"></i>
                                Explore CPD Sessions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-header">
                        <i class="fas fa-certificate fa-2x"></i>
                        <div class="title-group">
                            <h3>PROVIDER ACCREDITATION PART A</h3>
                            <span class="subtitle">Higher Education only</span>
                        </div>
                    </div>
                    <div class="service-content">
                        <div class="feature-item highlight">
                            <i class="fas fa-file-alt"></i>
                            <span>Compilation of application form for Provider Accreditation</span>
                        </div>
                        <div class="feature-item highlight">
                            <i class="fas fa-chart-line"></i>
                            <span>Design and development of Business Plan with CSP</span>
                        </div>
                        <div class="feature-item highlight">
                            <i class="fas fa-calculator"></i>
                            <span>Financial Projections and Cash Flow planning</span>
                        </div>
                        <div class="feature-item highlight">
                            <i class="fas fa-tasks"></i>
                            <span>Reviews as requested by the MFHEA</span>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-header">
                        <i class="fas fa-award fa-2x"></i>
                        <div class="title-group">
                            <h3>PROVIDER ACCREDITATION PART B</h3>
                        </div>
                    </div>
                    <div class="service-content">
                        <div class="feature-item highlight">
                            <i class="fas fa-file-alt"></i>
                            <span>Compilation of application form for Provider Accreditation</span>
                        </div>
                        <div class="feature-item highlight">
                            <i class="fas fa-shield-alt"></i>
                            <span>Design and development of IQA Policy</span>
                        </div>
                        <div class="feature-item highlight">
                            <i class="fas fa-search"></i>
                            <span>Reviews as requested by the MFHEA</span>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-header">
                        <i class="fas fa-book-open fa-2x"></i>
                        <div class="title-group">
                            <h3>COURSE DEVELOPMENT</h3>
                        </div>
                    </div>
                    <div class="service-content">
                        <div class="feature-grid">
                            <div class="feature-item highlight">
                                <i class="fas fa-pencil-ruler"></i>
                                <span>Work with the Academy in building and developing a range of courses in the desired areas</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-tasks"></i>
                                <span>We will be responsible for ensuring course design is fit for purpose and meets both industry and vocational training requirements</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-list-ul"></i>
                                <span>Each course will include learning hours, rationale, aims, entry requirements, unit descriptors, unit content, learning outcomes & assessment strategies</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-file-contract"></i>
                                <span>Prepare and submit all the necessary documentation required by MFHEA for formal accreditation of programmes</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Assist in preparation of course content, teaching and student material</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-header">
                        <i class="fas fa-users fa-2x"></i>
                        <div class="title-group">
                            <h3>STAFF RECRUITMENT & DEVELOPMENT</h3>
                        </div>
                    </div>
                    <div class="service-content">
                        <div class="feature-item highlight">
                            <i class="fas fa-user-tie"></i>
                            <span>Work with the Academy in training existing staff as well as staff recruitment & development, train the trainers and overall ensure the academic caliber of teaching staff</span>
                        </div>
                        <div class="feature-item highlight">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Liaising with staff on maintaining their CPD portfolio</span>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-header">
                        <i class="fas fa-check-circle fa-2x"></i>
                        <div class="title-group">
                            <h3>QUALITY ASSURANCE</h3>
                        </div>
                    </div>
                    <div class="service-content">
                        <div class="qa-grid">
                            <div class="feature-item highlight">
                                <i class="fas fa-shield-alt"></i>
                                <span>Developing and strengthening QA Policy</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-cogs"></i>
                                <span>Managing all Internal and External Quality Assurance procedures</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-drafting-compass"></i>
                                <span>Taking responsibility for design and approval of all programmes</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Implementing student centered learning across teaching and assessment</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-user-graduate"></i>
                                <span>Registering students on programme of study ensuring entry requirements are met, recognition of prior learning and maintain student records through to certification</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-handshake"></i>
                                <span>Coordinating with Internal Verifiers in making assessment decisions and liaising with External Verifiers in reaching final assessment decisions</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-chart-line"></i>
                                <span>Ensuring Continuing Professional Development activities are carried out for teaching staff</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="fas fa-clipboard-list"></i>
                                <span>Carrying out necessary monitoring activities and programme reviews in liaison with key stakeholders</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cta-container">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSf-22kC4X6Ks0p4f0e4IsunRcjDXXWi8vbHCz7GFTSThwuV1Q/viewform?usp=header" target="_blank" class="cta-button">
                        <i class="fas fa-paper-plane"></i>
                        Apply for Service
                    </a>
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


