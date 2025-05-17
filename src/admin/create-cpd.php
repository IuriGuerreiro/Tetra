<?php
session_start();
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
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagePath = null;
    
    // Create CPD
    $result = $cpdController->create(
        $_POST['title'],
        $_POST['description'],
        $_POST['abstract'],
        $_POST['image_path'] ?? null, // Get image path from hidden input
        $_POST['registration_link']
    );

    if ($result['success']) {
        $success = $result['message'];
        // Redirect to CPDs list after successful creation
        header('Location: cpds.php');
        exit();
    } else {
        $error = $result['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create CPD - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .image-preview {
            max-width: 200px;
            margin-top: 10px;
            display: none;
        }
        .image-preview img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }
        .upload-progress {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <div class="container">
        <h1>Create New CPD</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" id="cpdForm">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="abstract">Abstract:</label>
                <textarea id="abstract" name="abstract" required class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" accept="image/*" class="form-control">
                <input type="hidden" name="image_path" id="image_path">
                <div class="upload-progress">Uploading image...</div>
                <div class="image-preview">
                    <img src="" alt="Image preview">
                </div>
            </div>

            <div class="form-group">
                <label for="registration_link">Registration Link:</label>
                <input type="url" id="registration_link" name="registration_link" required class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Create CPD</button>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>

    <?php include_once 'includes/footer.php'; ?>

    <script>
        document.getElementById('image').addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('image', file);
            formData.append('type', 'cpds');

            const progressDiv = document.querySelector('.upload-progress');
            const previewDiv = document.querySelector('.image-preview');
            const previewImg = previewDiv.querySelector('img');

            try {
                progressDiv.style.display = 'block';
                
                const response = await fetch('../Controllers/upload-image.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    document.getElementById('image_path').value = result.path;
                    previewImg.src = result.path;
                    previewDiv.style.display = 'block';
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                alert('Error uploading image: ' + error.message);
            } finally {
                progressDiv.style.display = 'none';
            }
        });
    </script>
</body>
</html> 