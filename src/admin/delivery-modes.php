<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/DeliveryModeController.php';
require_once __DIR__ . '/../Controllers/User.php';

$user = new User(getPDO());

// Check if user is logged in
if (!$user->isLoggedIn()) {
    $_SESSION['error'] = 'You must be logged in to access this page';
    header('Location: login.php');
    exit();
}

$deliveryModeController = new DeliveryModeController(getPDO());

// Handle delivery mode deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delivery_mode_id'])) {
    try {
        $result = $deliveryModeController->delete($_POST['delivery_mode_id']);
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        header('Location: delivery-modes.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

$deliveryModes = $deliveryModeController->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Delivery Modes - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Manage Delivery Modes</h1>
            <div class="header-actions">
                <?php if ($user->isAdmin()): ?>
                    <a href="create-delivery-mode.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Delivery Mode
                    </a>
                <?php endif; ?>
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

        <div class="delivery-modes-grid">
            <?php if (!empty($deliveryModes)): ?>
                <?php foreach ($deliveryModes as $mode): ?>
                    <div class="delivery-mode-card">
                        <div class="delivery-mode-content">
                            <h4><?php echo htmlspecialchars($mode['name']); ?></h4>
                            
                            <div class="delivery-mode-meta">
                                <span><i class="fas fa-calendar"></i> Created: <?php echo date('M d, Y', strtotime($mode['created_at'])); ?></span>
                            </div>

                            <?php if ($user->isAdmin()): ?>
                            <div class="delivery-mode-actions">
                                <a href="edit-delivery-mode.php?id=<?php echo $mode['id']; ?>" 
                                   class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Are you sure you want to delete this delivery mode? This action cannot be undone.');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="delivery_mode_id" value="<?php echo $mode['id']; ?>">
                                    <button type="submit" class="btn btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-delivery-modes-message">
                    <p>No delivery modes found. <?php if ($user->isAdmin()): ?>Click the "Create New Delivery Mode" button to add one.<?php endif; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>

    <style>
        .delivery-modes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .delivery-mode-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .delivery-mode-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .delivery-mode-content {
            padding: 20px;
        }

        .delivery-mode-content h4 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 1.2rem;
        }
        .btn-edit, .btn-primary, .btn-danger {
            text-decoration: none;
        }
        .btn-edit {
            background: #ffc107;
            color: #000;
        }
        .btn-delete {
            background: #dc3545;
            color: #fff;
        }
        .delivery-mode-meta {
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        .delivery-mode-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .delivery-mode-actions {
            display: flex;
            gap: 10px;
        }

        .no-delivery-modes-message {
            grid-column: 1 / -1;
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 8px;
            color: #666;
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
        .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</body>
</html> 