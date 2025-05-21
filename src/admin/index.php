<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/User.php';
require_once __DIR__ . '/../Controllers/CPDController.php';

// Initialize User
$user = new User(getPDO());

if (!$user->isLoggedIn()) {
    $_SESSION['error'] = 'You do not have permission to access this page';
    header('Location: login.php');
    exit();
}

// Initialize CPD Controller and get all CPDs
$cpdController = new CPDController(getPDO());
$cpds = $cpdController->getAll();

require_once 'includes/header.php';
?>

<div class="content-header">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></h2>
    <div class="actions">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<div class="dashboard-welcome">
    <div class="welcome-card">
        <h3>Welcome to the Admin Panel</h3>
        <p>Use the navigation menu to manage your website content and users.</p>
    </div>
</div>

<!-- CPDs Section -->
<div class="dashboard-section">
    <div class="section-header">
        <h3>CPDs Management</h3>
        <a href="create-cpd.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New CPD
        </a>
    </div>
    
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
                            <a href="edit-cpd.php?id=<?php echo $cpd['id']; ?>" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="delete-cpd.php?id=<?php echo $cpd['id']; ?>" 
                               class="btn btn-delete"
                               onclick="return confirm('Are you sure you want to delete this CPD?');">
                                <i class="fas fa-trash"></i> Delete
                            </a>
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

<style>
    .dashboard-welcome {
        margin: 20px 0;
    }
    .welcome-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 30px;
        text-align: center;
    }
    .welcome-card h3 {
        margin-top: 0;
        color: #2c3e50;
        font-size: 1.8rem;
    }
    .welcome-card p {
        color: #7f8c8d;
        font-size: 1.1rem;
        line-height: 1.6;
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

    .btn-delete {
        background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(244, 67, 54, 0.2);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(244, 67, 54, 0.3);
    }

    /* CPD Section Styles */
    .dashboard-section {
        margin: 30px 0;
    }
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .section-header h3 {
        margin: 0;
        color: #2c3e50;
        font-size: 1.5rem;
    }
    .cpd-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
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
    .no-cpds-message {
        grid-column: 1 / -1;
        text-align: center;
        padding: 30px;
        background: #f8f9fa;
        border-radius: 8px;
        color: #666;
    }
    
    @media (max-width: 1200px) {
        .stat-card {
            width: 48%;
        }
    }
    
    @media (max-width: 768px) {
        .stat-card {
            width: 100%;
        }
        .article-cards,
        .podcast-cards,
        .tournament-cards {
            grid-template-columns: 1fr;
        }
    }
</style>
</body>
</html>
