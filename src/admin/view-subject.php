<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/SubjectController.php';
require_once __DIR__ . '/../Controllers/IntroductionController.php';
require_once __DIR__ . '/../Controllers/PracticalController.php';
require_once __DIR__ . '/../Controllers/User.php';

$user = new User(getPDO());

// Check if user is logged in
if (!$user->isLoggedIn()) {
    $_SESSION['error'] = 'You must be logged in to access this page';
    header('Location: login.php');
    exit();
}

$subjectController = new SubjectController(getPDO());
$introductionController = new IntroductionController(getPDO());
$practicalController = new PracticalController(getPDO());

// Get subject ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: index.php');
    exit();
}

// Get subject data
$subject = $subjectController->getById($id);
if (!$subject) {
    $_SESSION['error'] = 'Subject not found';
    header('Location: index.php');
    exit();
}

// Get introductions and practicals
$introductions = $introductionController->getBySubjectId($id);
$practicals = $practicalController->getBySubjectId($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Subject - <?php echo htmlspecialchars($subject['name']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .subject-view-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .subject-details {
            padding: 30px;
        }

        .detail-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .detail-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
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
            display: flex;
            align-items: center;
            gap: 10px;
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

        .item-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .item-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .item-card h4 {
            color: #2c3e50;
            margin: 0 0 10px 0;
            font-size: 1.2em;
        }

        .item-card p {
            margin: 0;
            color: #34495e;
        }

        .empty-state {
            text-align: center;
            padding: 30px;
            color: #666;
        }

        .empty-state i {
            font-size: 3em;
            color: #95a5a6;
            margin-bottom: 15px;
        }

        .section-count {
            background: #e1f5fe;
            color: #0288d1;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.9em;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <div class="container">
        <div class="content-header">
            <h1>View Subject</h1>
            <div class="header-actions">
                <?php if ($user->isAdmin()): ?>
                <a href="edit-subject.php?id=<?php echo $id; ?>" class="btn btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <?php endif; ?>
                <a href="subjectsList.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Subjects
                </a>
            </div>
        </div>

        <div class="subject-view-container">
            <div class="subject-details">
                <div class="detail-section">
                    <h2><?php echo htmlspecialchars($subject['name']); ?></h2>
                    <div class="meta-info">
                        <span><i class="fas fa-calendar"></i> Created: <?php echo date('M d, Y', strtotime($subject['created_at'])); ?></span>
                        <span><i class="fas fa-clock"></i> Last Updated: <?php echo date('M d, Y', strtotime($subject['updated_at'])); ?></span>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Description</h3>
                    <p><?php echo nl2br(htmlspecialchars($subject['description'])); ?></p>
                </div>
            </div>
        </div>

        <!-- Introductions Section -->
        <div class="subject-view-container">
            <div class="subject-details">
                <div class="detail-section">
                    <h3>
                        <i class="fas fa-book-open"></i>
                        Introductions
                        <span class="section-count"><?php echo count($introductions); ?></span>
                    </h3>
                    <?php if (!empty($introductions)): ?>
                        <ul class="item-list">
                            <?php foreach ($introductions as $intro): ?>
                                <li class="item-card">
                                    <h4><?php echo htmlspecialchars($intro['title']); ?></h4>
                                    <p><?php echo nl2br(htmlspecialchars($intro['content'])); ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-book"></i>
                            <p>No introductions available for this subject.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Practicals Section -->
        <div class="subject-view-container">
            <div class="subject-details">
                <div class="detail-section">
                    <h3>
                        <i class="fas fa-flask"></i>
                        Practicals
                        <span class="section-count"><?php echo count($practicals); ?></span>
                    </h3>
                    <?php if (!empty($practicals)): ?>
                        <ul class="item-list">
                            <?php foreach ($practicals as $practical): ?>
                                <li class="item-card">
                                    <h4><?php echo htmlspecialchars($practical['title']); ?></h4>
                                    <p><?php echo nl2br(htmlspecialchars($practical['description'])); ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-flask"></i>
                            <p>No practicals available for this subject.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>
</body>
</html> 