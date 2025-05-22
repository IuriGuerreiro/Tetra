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
    <link rel="icon" type="image/png" href="https://new.tetra.com.mt/public/assets/images/favicon.png">
    
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
        .cpd-detail-section {
            margin: 1.5rem 0;
            padding: 1rem;
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            border-left: 4px solid #00ff88;
        }
        .cpd-detail-section h4 {
            margin: 0 0 0.5rem 0;
            color: #00ff88;
            font-size: 1rem;
            font-weight: 600;
        }
        .cpd-detail-section p, .cpd-detail-section ul {
            margin: 0;
            line-height: 1.6;
            color: #ccc;
        }
        .cpd-detail-section ul {
            padding-left: 1.2rem;
        }
        .cpd-detail-section li {
            margin-bottom: 0.3rem;
        }
        .session-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0,255,136,0.1);
            padding: 0.5rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            color: #00ff88;
        }
        .meta-item i {
            font-size: 0.8rem;
        }
        .session-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border: 1px solid #333;
            transition: all 0.3s ease;
        }
        .session-card:hover {
            transform: translateY(-5px);
            border-color: #00ff88;
            box-shadow: 0 10px 30px rgba(0,255,136,0.2);
        }
        .expandable-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .expandable-content.expanded {
            max-height: 2000px;
        }
        .expand-btn {
            background: rgba(0,255,136,0.1);
            color: #00ff88;
            border: 1px solid #00ff88;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.85rem;
            margin: 1rem 0;
            transition: all 0.3s ease;
        }
        .expand-btn:hover {
            background: rgba(0,255,136,0.2);
        }
    </style>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../public/assets/css/cpds.css">
    <link rel="stylesheet" href="../../public/assets/css/cpds-custom.css">
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
                <h2 class="section-title animate-fade-in">ELT Council Approved CPD Sessions</h2>
                <div class="session-info animate-slide-up" data-delay="0.1">
                    <i class="fas fa-info-circle"></i>
                    <p>TETRA delivers a comprehensive series of ELT Council-approved CPD sessions designed to enhance your teaching practice. All sessions count towards your ELT permit requirements and feature expert facilitators with extensive experience in English language teaching.</p>
                </div>
                <div class="sessions-grid">
                    <?php if (!empty($cpds)): ?>
                        <?php foreach ($cpds as $cpd): ?>
                            <div class="session-card animate-slide-up">
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
                                        
                                        <!-- Session Meta Information -->
                                        <div class="session-meta">
                                            <div class="meta-item">
                                                <i class="fas fa-clock"></i>
                                                <span><?php echo htmlspecialchars($cpd['duration_hours']); ?> hours</span>
                                            </div>
                                            <?php if (!empty($cpd['delivery_mode'])): ?>
                                                <div class="meta-item">
                                                    <i class="fas fa-chalkboard-teacher"></i>
                                                    <span><?php echo htmlspecialchars($cpd['delivery_mode']); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Course Rationale (Always visible) -->
                                        <?php if (!empty($cpd['course_rationale'])): ?>
                                            <div class="cpd-detail-section">
                                                <h4><i class="fas fa-lightbulb"></i> Course Overview</h4>
                                                <p><?php echo nl2br(htmlspecialchars(substr($cpd['course_rationale'], 0, 500))); ?><?php echo strlen($cpd['course_rationale']) > 500 ? '...' : ''; ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Expand button -->
                                        <button class="expand-btn" onclick="toggleExpand(this)">
                                            <i class="fas fa-chevron-down"></i> Show Full Details
                                        </button>

                                        <!-- Expandable Content -->
                                        <div class="expandable-content">
                                            <!-- Full Course Rationale -->
                                            <?php if (!empty($cpd['course_rationale']) && strlen($cpd['course_rationale']) > 500): ?>
                                                <div class="cpd-detail-section">
                                                    <h4><i class="fas fa-lightbulb"></i> Full Course Rationale</h4>
                                                    <p><?php echo nl2br(htmlspecialchars($cpd['course_rationale'])); ?></p>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Course Objectives -->
                                            <?php if (!empty($cpd['course_objectives'])): ?>
                                                <div class="cpd-detail-section">
                                                    <h4><i class="fas fa-target"></i> Course Objectives</h4>
                                                    <?php 
                                                    $objectives = $cpd['course_objectives'];
                                                    if (strpos($objectives, ';') !== false || strpos($objectives, '-') !== false) {
                                                        // If contains semicolons or dashes, treat as list
                                                        $items = preg_split('/[;\-]\s*/', $objectives);
                                                        echo '<ul>';
                                                        foreach ($items as $item) {
                                                            $item = trim($item);
                                                            if (!empty($item)) {
                                                                echo '<li>' . htmlspecialchars($item) . '</li>';
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    } else {
                                                        echo '<p>' . nl2br(htmlspecialchars($objectives)) . '</p>';
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Learning Outcomes -->
                                            <?php if (!empty($cpd['learning_outcomes'])): ?>
                                                <div class="cpd-detail-section">
                                                    <h4><i class="fas fa-graduation-cap"></i> Learning Outcomes</h4>
                                                    <?php 
                                                    $outcomes = $cpd['learning_outcomes'];
                                                    if (strpos($outcomes, ';') !== false || strpos($outcomes, '-') !== false) {
                                                        // If contains semicolons or dashes, treat as list
                                                        $items = preg_split('/[;\-]\s*/', $outcomes);
                                                        echo '<ul>';
                                                        foreach ($items as $item) {
                                                            $item = trim($item);
                                                            if (!empty($item)) {
                                                                echo '<li>' . htmlspecialchars($item) . '</li>';
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    } else {
                                                        echo '<p>' . nl2br(htmlspecialchars($outcomes)) . '</p>';
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Course Procedures -->
                                            <?php if (!empty($cpd['course_procedures'])): ?>
                                                <div class="cpd-detail-section">
                                                    <h4><i class="fas fa-tasks"></i> Course Procedures</h4>
                                                    <p><?php echo nl2br(htmlspecialchars($cpd['course_procedures'])); ?></p>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Assessment Procedure -->
                                            <?php if (!empty($cpd['assessment_procedure'])): ?>
                                                <div class="cpd-detail-section">
                                                    <h4><i class="fas fa-clipboard-check"></i> Assessment Procedure</h4>
                                                    <p><?php echo nl2br(htmlspecialchars($cpd['assessment_procedure'])); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- More Details Button -->
                                        <a class="details-btn" href="view-cpd.php?id=<?php echo urlencode($cpd['id']); ?>">
                                            <i class="fas fa-arrow-right"></i> More Details
                                        </a>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-sessions animate-slide-up" data-delay="0.2">
                            <i class="fas fa-info-circle"></i>
                            <p>No CPD sessions currently loaded. Please contact us for information about upcoming sessions.</p>
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
                            <p>Browse our comprehensive CPD sessions and select those that match your professional development needs.</p>
                        </div>
                    </div>
                    <div class="step-card animate-slide-up" data-delay="0.2">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h3>Get in Touch</h3>
                            <p>Ready to enhance your teaching skills? Contact us to learn more about our CPD sessions or to express your interest in upcoming courses:</p>
                            <div class="contact-info">
                                <p><i class="fas fa-phone"></i> +356 99660124</p>
                                <p><i class="fas fa-envelope"></i> <a href="mailto:info@tetra.com.mt">info@tetra.com.mt</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="step-card animate-slide-up" data-delay="0.3">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h3>Get Scheduled</h3>
                            <p>We'll contact you with available dates and session details.</p>
                        </div>
                    </div>
                    <div class="step-card animate-slide-up" data-delay="0.4">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h3>Attend & Learn</h3>
                            <p>Join the session and enhance your teaching skills with expert guidance.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../components/footer.php'; ?>

    <!-- JavaScript -->
    <script src="../../public/assets/js/cpd-animations.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add loaded class to body
            document.body.classList.add('loaded');
            
            // Initialize CPD-specific animations
            if (typeof initCPDAnimations === 'function') {
                initCPDAnimations();
            }
        });

        function toggleExpand(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (content.classList.contains('expanded')) {
                content.classList.remove('expanded');
                button.innerHTML = '<i class="fas fa-chevron-down"></i> Show Full Details';
            } else {
                content.classList.add('expanded');
                button.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Details';
            }
        }
    </script>
</body>
</html> 