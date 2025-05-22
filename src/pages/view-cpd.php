<?php
require_once '../config/config.php';
require_once '../Controllers/CPDController.php';
include '../components/header.php';

// Initialize CPD Controller
$cpdController = new CPDController(GetPDO());
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$cpd = $id ? $cpdController->getById($id) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View CPD Session - TETRA</title>
    <!-- Favicon -->
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
            margin: 2rem auto;
            max-width: 1100px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,255,136,0.08);
        }
        .session-image img {
            width: 100%;
            max-height: 320px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }
        .session-content {
            padding: 2.5rem 3.5rem;
        }
        .session-header h3 {
            margin: 0 0 1rem 0;
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
        }
        .contact-section {
            margin: 2rem auto 6rem auto;
            max-width: 1100px;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 1.5rem 3rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            box-shadow: 0 4px 18px rgba(0,255,136,0.05);
        }
        .contact-title {
            color: #00ff88;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
        }
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        .contact-row {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.1rem;
            color: #ccc;
            font-family: 'Inter', Arial, sans-serif;
        }
        .contact-icon {
            width: 2.2rem;
            height: 2.2rem;
            background: rgba(0,255,136,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00ff88;
            font-size: 1.2rem;
        }
        .contact-row a {
            color: #00ff88;
            text-decoration: none;
            font-weight: 600;
            font-family: 'Inter', Arial, sans-serif;
        }
    </style>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../public/assets/css/cpds.css">
    <link rel="stylesheet" href="../../public/assets/css/hero.css">
    <link rel="stylesheet" href="../../public/assets/css/animations.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/solid.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="triangle-logo">
                <img src="../../public/assets/images/favicon.png" alt="TETRA Logo">
            </div>
            <div class="hero-content">
                <h1 class="animate-fade-in">CPD Session Details</h1>
                <p class="hero-text animate-slide-up">Explore the full details of this ELT Council-approved CPD session</p>
            </div>
        </section>

        <section class="cpd-sessions">
            <div class="container">
                <?php if ($cpd): ?>
                <div class="session-card animate-slide-up">
                    <?php if (!empty($cpd['image_path'])): ?>
                        <div class="session-image">
                            <img src="../../public/assets/images/<?php echo htmlspecialchars($cpd['image_path']); ?>" alt="<?php echo htmlspecialchars($cpd['title']); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="session-content">
                        <div class="session-header">
                            <h3><?php echo htmlspecialchars($cpd['title']); ?></h3>
                        </div>
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
                        <?php if (!empty($cpd['course_rationale'])): ?>
                            <div class="cpd-detail-section">
                                <h4><i class="fas fa-lightbulb"></i> Course Overview</h4>
                                <p><?php echo nl2br(htmlspecialchars($cpd['course_rationale'])); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($cpd['course_objectives'])): ?>
                            <div class="cpd-detail-section">
                                <h4><i class="fas fa-target"></i> Course Objectives</h4>
                                <?php 
                                $objectives = $cpd['course_objectives'];
                                if (strpos($objectives, ';') !== false || strpos($objectives, '-') !== false) {
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
                        <?php if (!empty($cpd['learning_outcomes'])): ?>
                            <div class="cpd-detail-section">
                                <h4><i class="fas fa-graduation-cap"></i> Learning Outcomes</h4>
                                <?php 
                                $outcomes = $cpd['learning_outcomes'];
                                if (strpos($outcomes, ';') !== false || strpos($outcomes, '-') !== false) {
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
                        <?php if (!empty($cpd['course_procedures'])): ?>
                            <div class="cpd-detail-section">
                                <h4><i class="fas fa-tasks"></i> Course Procedures</h4>
                                <p><?php echo nl2br(htmlspecialchars($cpd['course_procedures'])); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($cpd['assessment_procedure'])): ?>
                            <div class="cpd-detail-section">
                                <h4><i class="fas fa-clipboard-check"></i> Assessment Procedure</h4>
                                <p><?php echo nl2br(htmlspecialchars($cpd['assessment_procedure'])); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php else: ?>
                    <div class="no-sessions animate-slide-up">
                        <i class="fas fa-info-circle"></i>
                        <p>No CPD session found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <section class="contact-section animate-slide-up" data-delay="0">
        <div class="contact-title">Want to enroll? Contact us:</div>
        <div class="contact-info">
            <div class="contact-row">
                <span class="contact-icon"><i class="fas fa-phone"></i></span>
                <span>99660124</span>
            </div>
            <div class="contact-row">
                <span class="contact-icon"><i class="fas fa-envelope"></i></span>
                <a href="mailto:info@treta.com.mt">info@treta.com.mt</a>
            </div>
        </div>
    </section>
    <?php include '../components/footer.php'; ?>

    <script src="../../public/assets/js/cpd-animations.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('loaded');
            if (typeof initCPDAnimations === 'function') {
                initCPDAnimations();
            }
        });
    </script>
</body>
</html>