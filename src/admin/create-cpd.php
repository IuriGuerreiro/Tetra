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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate and sanitize input
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $duration_hours = filter_input(INPUT_POST, 'duration_hours', FILTER_VALIDATE_INT);
        $course_rationale = filter_input(INPUT_POST, 'course_rationale', FILTER_SANITIZE_STRING);
        $course_objectives = filter_input(INPUT_POST, 'course_objectives', FILTER_SANITIZE_STRING);
        $learning_outcomes = filter_input(INPUT_POST, 'learning_outcomes', FILTER_SANITIZE_STRING);
        $course_procedures = filter_input(INPUT_POST, 'course_procedures', FILTER_SANITIZE_STRING);
        $delivery_mode_id = filter_input(INPUT_POST, 'delivery_mode_id', FILTER_VALIDATE_INT);
        $assessment_procedure = filter_input(INPUT_POST, 'assessment_procedure', FILTER_SANITIZE_STRING);
        $image_path = null;

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
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
                $image_path = "uploads/cpds/" . $image_name;
            } else {
                throw new Exception('Failed to upload image.');
            }
        }

        // Check for forbidden characters (em dash)
        $forbiddenPattern = '/[—]/u';
        $fieldsToCheck = [
            $title,
            $course_rationale,
            $course_objectives,
            $learning_outcomes,
            $course_procedures,
            $assessment_procedure
        ];
        foreach ($fieldsToCheck as $field) {
            if (preg_match($forbiddenPattern, $field)) {
                throw new Exception('Your input contains forbidden characters (such as em dash —). Please use a regular dash (-) instead.');
            }
        }

        // Check if all required fields are filled
        if (!$title || !$duration_hours || !$course_rationale || !$course_objectives || 
            !$learning_outcomes || !$course_procedures || !$delivery_mode_id || !$assessment_procedure) {
            throw new Exception('Please fill in all required fields');
        }

        // Create CPD
        $result = $cpdController->create(
            $title,
            $duration_hours,
            $course_rationale,
            $course_objectives,
            $learning_outcomes,
            $course_procedures,
            $delivery_mode_id,
            $assessment_procedure,
            $image_path
        );

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
            header('Location: cpdsList.php');
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
                <a href="cpdsList.php" class="btn btn-secondary">Back to CPDs</a>
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
                    <label for="duration_hours">Duration (hours)</label>
                    <input type="number" id="duration_hours" name="duration_hours" required class="form-control" 
                           min="1" max="24" placeholder="Enter duration in hours" 
                           value="<?php echo isset($_POST['duration_hours']) ? htmlspecialchars($_POST['duration_hours']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="course_rationale">Course Rationale and Content</label>
                    <textarea id="course_rationale" name="course_rationale" required class="form-control" 
                              placeholder="Enter course rationale and content"><?php echo isset($_POST['course_rationale']) ? htmlspecialchars($_POST['course_rationale']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="course_objectives">Course Objectives</label>
                    <textarea id="course_objectives" name="course_objectives" required class="form-control" 
                              placeholder="Enter course objectives"><?php echo isset($_POST['course_objectives']) ? htmlspecialchars($_POST['course_objectives']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="learning_outcomes">Learning Outcomes</label>
                    <textarea id="learning_outcomes" name="learning_outcomes" required class="form-control" 
                              placeholder="Enter learning outcomes"><?php echo isset($_POST['learning_outcomes']) ? htmlspecialchars($_POST['learning_outcomes']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="course_procedures">Course Procedures</label>
                    <textarea id="course_procedures" name="course_procedures" required class="form-control" 
                              placeholder="Enter course procedures"><?php echo isset($_POST['course_procedures']) ? htmlspecialchars($_POST['course_procedures']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="delivery_mode_id">Delivery Mode</label>
                    <select id="delivery_mode_id" name="delivery_mode_id" required class="form-control">
                        <option value="">Select delivery mode</option>
                        <?php foreach ($deliveryModes as $mode): ?>
                            <option value="<?php echo $mode['id']; ?>" <?php echo (isset($_POST['delivery_mode_id']) && $_POST['delivery_mode_id'] == $mode['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($mode['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="assessment_procedure">Assessment Procedure</label>
                    <textarea id="assessment_procedure" name="assessment_procedure" required class="form-control" 
                              placeholder="Enter assessment procedure"><?php echo isset($_POST['assessment_procedure']) ? htmlspecialchars($_POST['assessment_procedure']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <div class="image-upload-container">
                        <div class="drop-zone" id="dropZone">
                            <div class="drop-zone-prompt">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Drag & Drop your image here or click to browse</p>
                            </div>
                            <input type="file" id="image" name="image" class="form-control" accept="image/jpeg,image/png,image/gif" style="display: none;">
                        </div>
                        <div id="image-preview" class="image-preview">
                            <img id="preview-img" src="" alt="Preview" style="display: none; max-width: 200px; max-height: 200px;">
                        </div>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">Create CPD</button>
                    <a href="cpdsList.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>

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