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
    
    <!-- Preload critical resources -->
    <link rel="preload" href="../../public/assets/css/cpds.css" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style">
    
    <!-- Critical CSS -->
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --background-dark: #0f172a;
            --background-light: #1e293b;
            --text-light: #e2e8f0;
            --text-muted: #94a3b8;
            --accent-color: #3b82f6;
        }
        
        body { 
            margin: 0;
            opacity: 0;
            transition: opacity .3s ease;
            background: var(--background-dark);
            color: var(--text-light);
        }
        .loaded { opacity: 1; }
    </style>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../public/assets/css/cpds.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/solid.min.css" integrity="sha512-pZlKGs7nEqF4zoG0egeK167l6yovsuL8ap30d07kA5AJUq+WysFlQ02DLXAmN3n0+H3JVz5ni8SJZnrOaYXWBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1>Continuous Professional Development</h1>
                <p class="hero-text">Enhance your teaching skills with our ELT Council-approved CPD sessions</p>
            </div>
        </section>

        <!-- Upcoming Sessions -->
        <section class="upcoming-sessions">
            <div class="container">
                <h2>August 2023 CPD Sessions</h2>
                <div class="session-info">
                    <p><i class="fas fa-info-circle"></i> This August TETRA will be delivering a series of online CPD sessions every Saturday morning between the 12th August and the 26th August. All sessions are approved by the ELT council and are accepted as part of your ELT permit requirements.</p>
                </div>
                <div class="session-grid">
                    <?php if (!empty($cpds)): ?>
                        <?php foreach ($cpds as $cpd): ?>
                            <div class="session-card">
                                <?php if (isset($cpd['created_at'])): ?>
                                    <div class="session-date">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('F j, Y', strtotime($cpd['created_at'])); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h3><?php echo htmlspecialchars($cpd['title']); ?></h3>
                                <p><?php echo htmlspecialchars($cpd['description']); ?></p>
                                
                                <?php if (isset($cpd['abstract'])): ?>
                                    <div class="session-abstract">
                                        <?php echo htmlspecialchars($cpd['abstract']); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($cpd['registration_link'])): ?>
                                    <a href="<?php echo htmlspecialchars($cpd['registration_link']); ?>" class="btn">
                                        <i class="fas fa-sign-in-alt"></i> Register Now
                                    </a>
                                <?php else: ?>
                                    <a href="#" class="btn">
                                        <i class="fas fa-sign-in-alt"></i> Register Now
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-sessions">
                            <p><i class="fas fa-info-circle"></i> No upcoming CPD sessions at the moment. Please check back later or contact us for more information.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="benefits">
            <div class="container">
                <h2>Why Choose Our CPD Sessions?</h2>
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <i class="fas fa-check-circle fa-2x"></i>
                        <h3>ELT Council Approved</h3>
                        <p>All our sessions are approved by the ELT council and count towards your permit requirements</p>
                    </div>
                    <div class="benefit-card">
                        <i class="fas fa-user-tie fa-2x"></i>
                        <h3>Expert Facilitators</h3>
                        <p>Learn from experienced professionals with extensive teaching and training backgrounds</p>
                    </div>
                    <div class="benefit-card">
                        <i class="fas fa-hands-helping fa-2x"></i>
                        <h3>Practical Focus</h3>
                        <p>Gain hands-on experience and ready-to-use resources for your classroom</p>
                    </div>
                    <div class="benefit-card">
                        <i class="fas fa-users fa-2x"></i>
                        <h3>Interactive Sessions</h3>
                        <p>Engage in discussions, group work, and practical exercises with fellow teachers</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Registration Info -->
        <section class="registration-info">
            <div class="container">
                <h2>How to Register</h2>
                <div class="registration-steps">
                    <div class="step">
                        <i class="fas fa-list-ul fa-2x"></i>
                        <h3>1. Choose Your Session</h3>
                        <p>Browse our upcoming sessions and select the one that matches your professional development needs.</p>
                    </div>
                    <div class="step">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                        <h3>2. Complete Registration</h3>
                        <p>Click the 'Register Now' button and fill in your details in our secure registration form.</p>
                    </div>
                    <div class="step">
                        <i class="fas fa-credit-card fa-2x"></i>
                        <h3>3. Confirm Payment</h3>
                        <p>Process your payment using our secure payment gateway.</p>
                    </div>
                    <div class="step">
                        <i class="fas fa-envelope fa-2x"></i>
                        <h3>4. Receive Confirmation</h3>
                        <p>Get your confirmation email with session details and access instructions.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section">
            <div class="container">
                <h2>Need More Information?</h2>
                <p>Contact us for any questions about our CPD sessions or custom training solutions.</p>
                <a href="mailto:info@tetra.edu.mt" class="btn">Contact Us</a>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; Copyright <?php echo date('Y'); ?> - TETRA</p>
        </div>
    </footer>

    <!-- Performance optimization script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('loaded');
        });
    </script>
</body>
</html> 