<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/CPDController.php';
require_once __DIR__ . '/../Controllers/User.php';
require_once __DIR__ . '/../Controllers/DeliveryModeController.php';

$user = new User(getPDO());

// Check if user is logged in and is admin
if (!$user->isLoggedIn() || !$user->isAdmin()) {
    $_SESSION['error'] = 'You must be logged in as an admin to access this page';
    header('Location: login.php');
    exit();
}

$cpdController = new CPDController(getPDO());
$deliveryModeController = new DeliveryModeController(getPDO());
$deliveryModes = $deliveryModeController->getAll();
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
        $file = $_FILES['image'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_extension, $allowed_extensions)) {
            throw new Exception('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');
        }

        // Direct upload without curl
        $upload_dir = "../../public/assets/images/uploads/cpds/";
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $image_name = uniqid() . '_' . time() . '.' . $file_extension;
        $upload_path = $upload_dir . $image_name;

        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            // Delete old image if exists
            if ($cpd['image_path'] && file_exists(__DIR__ . '/../public/assets/images/' . $cpd['image_path'])) {
                unlink(__DIR__ . '/../public/assets/images/' . $cpd['image_path']);
            }
            $imagePath = "uploads/cpds/" . $image_name;
        } else {
            throw new Exception('Failed to upload image.');
        }
    }

    // Update CPD
    $result = $cpdController->update(
        $id,
        $_POST['title'],
        $_POST['duration_hours'],
        $_POST['course_rationale'],
        $_POST['course_objectives'],
        $_POST['learning_outcomes'],
        $_POST['course_procedures'],
        $_POST['delivery_mode_id'],
        $_POST['assessment_procedure'],
        $imagePath
    );

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header('Location: cpdsList.php');
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
                <label for="duration_hours">Duration (hours):</label>
                <input type="number" id="duration_hours" name="duration_hours" required class="form-control" 
                       min="1" max="24" value="<?php echo htmlspecialchars($cpd['duration_hours']); ?>">
            </div>

            <div class="form-group">
                <label for="course_rationale">Course Rationale and Content:</label>
                <textarea id="course_rationale" name="course_rationale" required class="form-control"><?php echo htmlspecialchars($cpd['course_rationale']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="course_objectives">Course Objectives:</label>
                <textarea id="course_objectives" name="course_objectives" required class="form-control"><?php echo htmlspecialchars($cpd['course_objectives']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="learning_outcomes">Learning Outcomes:</label>
                <textarea id="learning_outcomes" name="learning_outcomes" required class="form-control"><?php echo htmlspecialchars($cpd['learning_outcomes']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="course_procedures">Course Procedures:</label>
                <textarea id="course_procedures" name="course_procedures" required class="form-control"><?php echo htmlspecialchars($cpd['course_procedures']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="delivery_mode_id">Delivery Mode:</label>
                <select id="delivery_mode_id" name="delivery_mode_id" required class="form-control">
                    <option value="">Select delivery mode</option>
                    <?php foreach ($deliveryModes as $mode): ?>
                        <option value="<?php echo $mode['id']; ?>" <?php echo ($cpd['delivery_mode_id'] == $mode['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($mode['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="assessment_procedure">Assessment Procedure:</label>
                <textarea id="assessment_procedure" name="assessment_procedure" required class="form-control"><?php echo htmlspecialchars($cpd['assessment_procedure']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <div class="image-upload-container">
                    <?php if ($cpd['image_path']): ?>
                        <div class="current-image">
                            <img src="../../public/assets/images/<?php echo htmlspecialchars($cpd['image_path']); ?>" alt="Current CPD image" style="max-width: 200px;">
                            <p>Current image</p>
                        </div>
                    <?php endif; ?>
                    <div class="drop-zone" id="dropZone">
                        <div class="drop-zone-prompt">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Drag & Drop your image here or click to browse</p>
                        </div>
                        <input type="file" id="image" name="image" accept="image/*" class="form-control" style="display: none;">
                    </div>
                    <div id="image-preview" class="image-preview">
                        <img id="preview-img" src="" alt="Preview" style="display: none; max-width: 200px; max-height: 200px;">
                    </div>
                    <small class="form-text text-muted">Leave empty to keep current image</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update CPD</button>
            <a href="cpdsList.php" class="btn btn-secondary">Back to CPDs</a>
        </form>
    </div>

    <?php include_once 'includes/footer.php'; ?>

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

    .drop-zone {
        width: 100%;
        height: 200px;
        border: 2px dashed #ccc;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border-color 0.3s ease;
        background-color: #f8f9fa;
    }

    .drop-zone:hover, .drop-zone.dragover {
        border-color: #007bff;
        background-color: #e9ecef;
    }

    .drop-zone-prompt {
        text-align: center;
        color: #6c757d;
    }

    .drop-zone-prompt i {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .image-preview {
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: center;
    }

    #preview-img {
        width: auto;
        height: auto;
        max-width: 200px;
        max-height: 200px;
        object-fit: contain;
    }

    .current-image {
        margin-bottom: 15px;
        text-align: center;
    }

    .current-image img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }

    .form-text {
        display: block;
        margin-top: 5px;
        color: #6c757d;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('image');
        const previewImg = document.getElementById('preview-img');
        const imagePreview = document.getElementById('image-preview');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop zone when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);

        // Handle click to upload
        dropZone.addEventListener('click', () => fileInput.click());

        // Handle file selection
        fileInput.addEventListener('change', handleFiles);

        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            dropZone.classList.add('dragover');
        }

        function unhighlight(e) {
            dropZone.classList.remove('dragover');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles({ target: { files: files } });
        }

        function handleFiles(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Please upload an image file (JPG, PNG, or GIF)');
                    fileInput.value = '';
                }
            }
        }
    });
    </script>
</body>
</html> 