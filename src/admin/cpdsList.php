<?php
session_start();
define('BASE_PATH', dirname(dirname(__FILE__)));
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/CPDController.php';
require_once __DIR__ . '/../Controllers/User.php';

$user = new User(getPDO());

// Check if user is logged in and is admin
if (!$user->isLoggedIn() || !$user->isAdmin()) {
    $_SESSION['error'] = 'You must be logged in as an admin to access this page';
    header('Location: login.php');
    exit();
}

$cpdController = new CPDController(getPDO());

// Handle CPD deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['cpd_id'])) {
    try {
        $result = $cpdController->delete($_POST['cpd_id']);
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        header('Location: cpds.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

$cpds = $cpdController->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage CPDs - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .cpd-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .cpd-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .cpd-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .cpd-thumbnail {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .cpd-content {
            padding: 15px;
        }

        .cpd-content h4 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 1.2rem;
        }

        .cpd-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .cpd-meta {
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        .cpd-meta span {
            margin-right: 15px;
        }

        .cpd-meta i {
            margin-right: 5px;
        }

        .cpd-actions {
            display: flex;
            gap: 10px;
        }

        .cpd-actions form {
            margin: 0;
        }

        .btn-edit {
            background: #ffc107;
            color: #000;
        }

        .btn-delete {
            background: #dc3545;
            color: #fff;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .page-header h1 {
            margin: 0;
            font-size: 1.8rem;
            color: #2c3e50;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            gap: 8px;
        }

        .btn i {
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            box-shadow: 0 2px 4px rgba(76, 175, 80, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(76, 175, 80, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
            color: white;
            box-shadow: 0 2px 4px rgba(255, 68, 68, 0.2);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #cc0000 0%, #990000 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(255, 68, 68, 0.3);
        }
    </style>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Manage CPDs</h1>
            <div class="header-actions">
                <a href="create-cpd.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New CPD
                </a>
                <a href="logout.php" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo htmlspecialchars($_SESSION['success']);
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo htmlspecialchars($_SESSION['error']);
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="cpd-grid">
            <?php if (!empty($cpds)): ?>
                <?php foreach ($cpds as $cpd): ?>
                    <div class="cpd-card">
                            <?php if ($cpd['image_path']): ?>
                                <img src="../../public/assets/images/<?php echo htmlspecialchars($cpd['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($cpd['title']); ?>" 
                                 class="cpd-thumbnail">
                        <?php endif; ?>
                        
                        <div class="cpd-content">
                            <h4><?php echo htmlspecialchars($cpd['title']); ?></h4>
                            
                            <div class="cpd-description">
                                <?php echo htmlspecialchars(substr($cpd['description'], 0, 100)) . '...'; ?>
                            </div>

                            <div class="cpd-meta">
                                <span><i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($cpd['created_at'])); ?></span>
                            </div>

                            <div class="cpd-actions">
                                <a href="edit-cpd.php?id=<?php echo $cpd['id']; ?>" 
                                   class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Are you sure you want to delete this CPD? This action cannot be undone.');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="cpd_id" value="<?php echo $cpd['id']; ?>">
                                    <button type="submit" class="btn btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-cpds-message">
                    <p>No CPDs found. Click the "Create New CPD" button to add one.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>
</body>
</html> 