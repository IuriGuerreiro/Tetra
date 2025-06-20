<?php
// Get current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Level Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-header h1 {
            font-size: 24px;
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
        }

        .sidebar-menu a.active {
            background: #3498db;
        }

        .main-content {
            flex: 1;
            margin-left: 275px;
            padding: 20px;
            background: #f8f9fa;
            position: relative;
            z-index: 1;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .content-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .content-header .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert.error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .article-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .article-card h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .article-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>Admin Panel</h1>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-menu">
                <li>
                    <a href="index.php" class="<?php echo $current_page === 'index.php' ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="cpdsList.php" class="<?php echo in_array($current_page, ['cpds.php', 'create-cpd.php', 'edit-cpd.php', 'delete-cpd.php']) ? 'active' : ''; ?>">
                        <i class="fas fa-graduation-cap"></i> CPDs
                    </a>
                </li>
                <li>
                    <a href="subjectsList.php" class="<?php echo in_array($current_page, ['subjectsList.php', 'create-subject.php', 'edit-subject.php', 'view-subject.php']) ? 'active' : ''; ?>">
                        <i class="fas fa-book"></i> Subjects
                    </a>
                </li>
                <li>
                    <a href="delivery-modes.php" class="<?php echo in_array($current_page, ['delivery-modes.php', 'create-delivery-mode.php', 'edit-delivery-mode.php']) ? 'active' : ''; ?>">
                        <i class="fas fa-cogs"></i> Delivery Modes
                    </a>
                </li>
                <?php if ($user->isLoggedIn() && $user->isAdmin()): ?>
                <li>
                    <a href="users.php" class="<?php echo in_array($current_page, ['users.php', 'create-user.php', 'edit-user.php']) ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="main-content">
