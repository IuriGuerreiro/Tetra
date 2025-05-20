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
    try {
        // Validate and sanitize input
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $abstract = filter_input(INPUT_POST, 'abstract', FILTER_SANITIZE_STRING);
        $registration_link = filter_input(INPUT_POST, 'registration_link', FILTER_SANITIZE_URL);
        $image_path = null;

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($file_extension, $allowed_extensions)) {
                throw new Exception('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');
            }

            $upload_dir = "../../public/assets/images/uploads/cpds/";
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $image_name = uniqid() . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $image_name;

            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                $image_path = "assets/images/uploads/cpds/" . $image_name;
            } else {
                throw new Exception('Failed to upload image.');
            }
        }

        // Check if all required fields are filled
        if (!$title || !$description || !$abstract || !$registration_link) {
            throw new Exception('Please fill in all required fields');
        }

        // Create CPD
        $result = $cpdController->create(
            $title,
            $description,
            $abstract,
            $image_path,
            $registration_link
        );

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
            header('Location: cpds.php');
            exit();
        } else {
            throw new Exception($result['message']);
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
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
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .image-upload-container {
            position: relative;
        }

        .image-preview {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: none;
        }

        #preview-img {
            width: auto;
            height: auto;
            max-width: 200px;
            max-height: 200px;
            object-fit: contain;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .container {
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <div class="container">
        <div class="content-header">
            <h2>Create New CPD</h2>
            <div class="actions">
                <a href="cpds.php" class="btn btn-secondary">Back to CPDs</a>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required class="form-control" 
                           placeholder="Enter CPD title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required class="form-control" 
                              placeholder="Enter CPD description"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="abstract">Abstract</label>
                    <textarea id="abstract" name="abstract" required class="form-control" 
                              placeholder="Enter CPD abstract"><?php echo isset($_POST['abstract']) ? htmlspecialchars($_POST['abstract']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <div class="image-upload-container">
                        <input type="file" id="image" name="image" class="form-control" 
                               accept="image/jpeg,image/png,image/gif">
                        <div class="image-preview">
                            <img id="preview-img" src="" alt="Preview">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="registration_link">Registration Link</label>
                    <input type="url" id="registration_link" name="registration_link" required 
                           class="form-control" placeholder="https://" 
                           value="<?php echo isset($_POST['registration_link']) ? htmlspecialchars($_POST['registration_link']) : ''; ?>">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">Create CPD</button>
                    <a href="cpds.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                const preview = document.querySelector('.image-preview');
                const previewImg = document.getElementById('preview-img');

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html> 