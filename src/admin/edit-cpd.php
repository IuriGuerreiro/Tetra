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

// Get CPD ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: index.php');
    exit();
}

// Get existing CPD data
$cpd = $cpdController->getById($id);
if (!$cpd) {
    $_SESSION['error'] = 'CPD not found';
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload
    $imagePath = $cpd['image_path']; // Keep existing image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/cpds/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $fileName = uniqid() . '.' . $fileExtension;
            $uploadPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                // Delete old image if exists
                if ($cpd['image_path'] && file_exists(__DIR__ . '/../' . $cpd['image_path'])) {
                    unlink(__DIR__ . '/../' . $cpd['image_path']);
                }
                $imagePath = 'uploads/cpds/' . $fileName;
            }
        }
    }

    // Update CPD
    $result = $cpdController->update(
        $id,
        $_POST['title'],
        $_POST['description'],
        $_POST['abstract'],
        $imagePath,
        $_POST['registration_link']
    );

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
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
    <title>Edit CPD - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <div class="container">
        <h1>Edit CPD</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required class="form-control" 
                       value="<?php echo htmlspecialchars($cpd['title']); ?>">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required class="form-control"><?php echo htmlspecialchars($cpd['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="abstract">Abstract:</label>
                <textarea id="abstract" name="abstract" required class="form-control"><?php echo htmlspecialchars($cpd['abstract']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <?php if ($cpd['image_path']): ?>
                    <div class="current-image">
                        <img src="<?php echo htmlspecialchars('../' . $cpd['image_path']); ?>" alt="Current CPD image" style="max-width: 200px;">
                        <p>Current image</p>
                    </div>
                <?php endif; ?>
                <input type="file" id="image" name="image" accept="image/*" class="form-control">
                <small class="form-text text-muted">Leave empty to keep current image</small>
            </div>

            <div class="form-group">
                <label for="registration_link">Registration Link:</label>
                <input type="url" id="registration_link" name="registration_link" required class="form-control"
                       value="<?php echo htmlspecialchars($cpd['registration_link']); ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update CPD</button>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>

    <?php include_once 'includes/footer.php'; ?>
</body>
</html> 