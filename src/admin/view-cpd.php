<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/CPDController.php';
require_once __DIR__ . '/../Controllers/User.php';

$user = new User(getPDO());

// Check if user is logged in
if (!$user->isLoggedIn()) {
    $_SESSION['error'] = 'You must be logged in to access this page';
    header('Location: login.php');
    exit();
}

$cpdController = new CPDController(getPDO());

// Get CPD ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: index.php');
    exit();
}

// Get CPD data
$cpd = $cpdController->getById($id);
if (!$cpd) {
    $_SESSION['error'] = 'CPD not found';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View CPD - <?php echo htmlspecialchars($cpd['title']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <div class="container">
        <div class="content-header">
            <h1>View CPD</h1>
            <div class="header-actions">
                <?php if ($user->isAdmin()): ?>
                <a href="edit-cpd.php?id=<?php echo $id; ?>" class="btn btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <?php endif; ?>
                <a href="cpdsList.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to CPDs
                </a>
            </div>
        </div>

        <div class="cpd-view-container">
            <?php if ($cpd['image_path']): ?>
            <div class="cpd-image">
                <img src="../../public/assets/images/<?php echo htmlspecialchars($cpd['image_path']); ?>" 
                     alt="<?php echo htmlspecialchars($cpd['title']); ?>">
            </div>
            <?php endif; ?>

            <div class="cpd-details">
                <div class="detail-section">
                    <h2><?php echo htmlspecialchars($cpd['title']); ?></h2>
                    <div class="meta-info">
                        <span><i class="fas fa-clock"></i> Duration: <?php echo htmlspecialchars($cpd['duration_hours']); ?> hours</span>
                        <span><i class="fas fa-chalkboard-teacher"></i> Delivery Mode: <?php echo htmlspecialchars($cpd['delivery_mode']); ?></span>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Course Rationale and Content</h3>
                    <p><?php echo nl2br(htmlspecialchars($cpd['course_rationale'])); ?></p>
                </div>

                <div class="detail-section">
                    <h3>Course Objectives</h3>
                    <p><?php echo nl2br(htmlspecialchars($cpd['course_objectives'])); ?></p>
                </div>

                <div class="detail-section">
                    <h3>Learning Outcomes</h3>
                    <p><?php echo nl2br(htmlspecialchars($cpd['learning_outcomes'])); ?></p>
                </div>

                <div class="detail-section">
                    <h3>Course Procedures</h3>
                    <p><?php echo nl2br(htmlspecialchars($cpd['course_procedures'])); ?></p>
                </div>

                <div class="detail-section">
                    <h3>Assessment Procedure</h3>
                    <p><?php echo nl2br(htmlspecialchars($cpd['assessment_procedure'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>

    <style>
    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .cpd-view-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .cpd-image {
        width: 100%;
        max-height: 400px;
        overflow: hidden;
    }

    .cpd-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cpd-details {
        padding: 30px;
    }

    .detail-section {
        margin-bottom: 30px;
    }

    .detail-section:last-child {
        margin-bottom: 0;
    }

    .detail-section h2 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 1.8em;
    }

    .detail-section h3 {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 1.4em;
    }

    .meta-info {
        display: flex;
        gap: 20px;
        color: #666;
        margin-bottom: 20px;
    }

    .meta-info span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .meta-info i {
        color: #3498db;
    }

    .detail-section p {
        color: #34495e;
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-edit {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(33, 150, 243, 0.2);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #1976D2 0%, #1565C0 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(33, 150, 243, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(127, 140, 141, 0.2);
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #7f8c8d 0%, #6c7a7d 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(127, 140, 141, 0.3);
    }
    </style>
</body>
</html> 