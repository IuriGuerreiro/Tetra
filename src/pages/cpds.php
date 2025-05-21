<?php
require_once '../config/config.php';
require_once '../Controllers/CPDController.php';
include '../components/header.php';

// Initialize CPD Controller
$cpdController = new CPDController(GetPDO());
$cpds = $cpdController->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPD Sessions - TETRA</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../public/assets/images/favicon.png">
    <link rel="apple-touch-icon" href="../../public/assets/images/favicon.png">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="../../public/assets/css/cpds.css" as="style">
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
    <link rel="stylesheet" href="../../public/assets/css/cpds.css">
    <link rel="stylesheet" href="../../public/assets/css/hero.css">
    <link rel="stylesheet" href="../../public/assets/css/animations.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            
            <!-- Hero content -->
            <div class="hero-content">
                <h1 class="animate-fade-in">Continuous Professional Development</h1>
                <p class="hero-text animate-slide-up" data-delay="0.1">Enhance your teaching skills with our ELT Council-approved CPD sessions</p>
            </div>
        </section>

        <!-- Upcoming Sessions -->
        <section class="cpd-sessions">
            <div class="container">
                <h2 class="section-title animate-fade-in">August 2025 CPD Sessions</h2>
                <div class="session-info animate-slide-up" data-delay="0.1">
                    <i class="fas fa-info-circle"></i>
                    <p>This August TETRA will be delivering a series of online CPD sessions every Saturday morning between the 12th August and the 26th August. All sessions are approved by the ELT council and are accepted as part of your ELT permit requirements.</p>
                </div>
                <div class="sessions-grid">
                    <?php if (!empty($cpds)): ?>
                        <?php $delay = 0.2; ?>
                        <?php foreach ($cpds as $cpd): ?>
                            <div class="session-card animate-slide-up" data-delay="<?php echo $delay; ?>">
                                <div class="session-card-inner">
                                    <?php if (!empty($cpd['image_path'])): ?>
                                        <div class="session-image">
                                            <img src="../../public/assets/images/<?php echo htmlspecialchars($cpd['image_path']); ?>" alt="<?php echo htmlspecialchars($cpd['title']); ?>">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="session-content">
                                        <div class="session-header">
                                            <h3><?php echo htmlspecialchars($cpd['title']); ?></h3>
                                        </div>
                                        
                                        <p class="session-description"><?php echo htmlspecialchars($cpd['description']); ?></p>
                                        
                                        <?php if (isset($cpd['abstract'])): ?>
                                            <div class="session-abstract">
                                                <h4>About This Session</h4>
                                                <p><?php echo htmlspecialchars($cpd['abstract']); ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (isset($cpd['registration_link'])): ?>
                                            <a href="<?php echo htmlspecialchars($cpd['registration_link']); ?>" class="btn pulse">
                                                <i class="fas fa-sign-in-alt"></i> Register Now
                                            </a>
                                        <?php else: ?>
                                            <a href="#" class="btn pulse">
                                                <i class="fas fa-sign-in-alt"></i> Register Now
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php $delay += 0.1; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-sessions animate-slide-up" data-delay="0.2">
                            <i class="fas fa-info-circle"></i>
                            <p>No upcoming CPD sessions at the moment. Please check back later or contact us for more information.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="benefits-section">
            <div class="container">
                <h2 class="section-title animate-fade-in">Why Choose Our CPD Sessions?</h2>
                <div class="benefits-grid">
                    <div class="benefit-card animate-slide-up" data-delay="0.1">
                        <div class="benefit-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>ELT Council Approved</h3>
                        <p>All our sessions are approved by the ELT council and count towards your permit requirements</p>
                    </div>
                    <div class="benefit-card animate-slide-up" data-delay="0.2">
                        <div class="benefit-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3>Expert Facilitators</h3>
                        <p>Learn from experienced professionals with extensive teaching and training backgrounds</p>
                    </div>
                    <div class="benefit-card animate-slide-up" data-delay="0.3">
                        <div class="benefit-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>Practical Focus</h3>
                        <p>Gain hands-on experience and ready-to-use resources for your classroom</p>
                    </div>
                    <div class="benefit-card animate-slide-up" data-delay="0.4">
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Interactive Sessions</h3>
                        <p>Engage in discussions, group work, and practical exercises with fellow teachers</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Registration Steps -->
        <section class="registration-steps">
            <div class="container">
                <h2 class="section-title animate-fade-in">How to Register</h2>
                <div class="steps-grid">
                    <div class="step-card animate-slide-up" data-delay="0.1">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fas fa-list-ul"></i>
                            </div>
                            <h3>Choose Your Session</h3>
                            <p>Browse our upcoming sessions and select the one that matches your professional development needs.</p>
                        </div>
                    </div>
                    <div class="step-card animate-slide-up" data-delay="0.2">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h3>Complete Registration</h3>
                            <p>Click the 'Register Now' button and fill in your details in our secure registration form.</p>
                        </div>
                    </div>
                    <div class="step-card animate-slide-up" data-delay="0.3">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h3>Confirm Payment</h3>
                            <p>Process your payment using our secure payment gateway.</p>
                        </div>
                    </div>
                    <div class="step-card animate-slide-up" data-delay="0.4">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h3>Receive Confirmation</h3>
                            <p>Get your confirmation email with session details and access instructions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../components/footer.php'; ?>

    <!-- JavaScript -->
    <script src="../../public/assets/js/scroll-animations.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add loaded class to body
            document.body.classList.add('loaded');
            
            // Initialize scroll animations
            if (typeof initScrollAnimations === 'function') {
                initScrollAnimations();
            }
        });
    </script>
</body>
</html> 