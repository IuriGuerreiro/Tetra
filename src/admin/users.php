<?php
require_once __DIR__ . '/../Controllers/User.php';

// Initialize User
$user = new User(getPDO());

// Check if user is logged in and is admin
if (!$user->isLoggedIn() || !$user->isAdmin()) {
    $_SESSION['error'] = 'You do not have permission to access this page';
    header('Location: login.php');
    exit();
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['user_id'])) {
    try {
        $user->deleteUser($_POST['user_id']);
        $_SESSION['success'] = 'User deleted successfully';
        header('Location: users.php');
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Get all users
$users = $user->getAllUsers();



require_once __DIR__ . '/includes/header.php';
?>

<div class="content-header">
    <h2>Users Management</h2>
    <div class="header-actions">
        <a href="create-user.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New User
        </a>
        <a href="logout.php" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

<style>
    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }

    .content-header h2 {
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

<div class="card">
    <?php if (isset($error)): ?>
        <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert" style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
            <?php 
            echo htmlspecialchars($_SESSION['success']); 
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 12px; text-align: left;">ID</th>
                <th style="padding: 12px; text-align: left;">Username</th>
                <th style="padding: 12px; text-align: left;">Email</th>
                <th style="padding: 12px; text-align: left;">Role</th>
                <th style="padding: 12px; text-align: left;">Created At</th>
                <th style="padding: 12px; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 12px;"><?php echo htmlspecialchars($user['id']); ?></td>
                    <td style="padding: 12px;"><?php echo htmlspecialchars($user['username']); ?></td>
                    <td style="padding: 12px;"><?php echo htmlspecialchars($user['email']); ?></td>
                    <td style="padding: 12px;">
                        <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; background: <?php echo $user['role'] === 'admin' ? '#e3f2fd' : '#e8f5e9'; ?>; color: <?php echo $user['role'] === 'admin' ? '#0d47a1' : '#2e7d32'; ?>; font-weight: 500;">
                            <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
                        </span>
                    </td>
                    <td style="padding: 12px;"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                    <td style="padding: 12px; text-align: right;">
                        <a href="edit-user.php?id=<?php echo $user['id']; ?>" class="btn" style="padding: 4px 8px; background: #ffc107; color: #000; margin-right: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <?php if ($_SESSION['user']['id'] != $user['id']): ?>
                            <form method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-danger" style="padding: 4px 8px;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
