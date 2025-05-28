<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/SubjectController.php';
require_once __DIR__ . '/../Controllers/IntroductionController.php';
require_once __DIR__ . '/../Controllers/PracticalController.php';
require_once __DIR__ . '/../Controllers/User.php';

$user = new User(getPDO());

// Check if user is logged in and is admin
if (!$user->isLoggedIn() || !$user->isAdmin()) {
    $_SESSION['error'] = 'You must be logged in as an admin to access this page';
    header('Location: login.php');
    exit();
}

$subjectController = new SubjectController(getPDO());
$introductionController = new IntroductionController(getPDO());
$practicalController = new PracticalController(getPDO());
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $pdo = getPDO();
        $pdo->beginTransaction();

        // Validate and sanitize subject input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

        // Check for forbidden characters (em dash)
        $forbiddenPattern = '/[—]/u';
        $fieldsToCheck = [
            $name,
            $description
        ];
        foreach ($fieldsToCheck as $field) {
            if (preg_match($forbiddenPattern, $field)) {
                throw new Exception('Your input contains forbidden characters (such as em dash —). Please use a regular dash (-) instead.');
            }
        }

        // Check if all required fields are filled
        if (!$name || !$description) {
            throw new Exception('Please fill in all required fields');
        }

        // Create subject
        $subjectResult = $subjectController->create(
            $name,
            $description
        );

        if (!$subjectResult['success']) {
            throw new Exception($subjectResult['message']);
        }

        $subjectId = $subjectResult['id'];

        // Process introductions
        if (isset($_POST['introductions']) && is_array($_POST['introductions'])) {
            foreach ($_POST['introductions'] as $introduction) {
                if (!empty($introduction['title']) && !empty($introduction['content'])) {
                    $introResult = $introductionController->create(
                        $subjectId,
                        $introduction['title'],
                        $introduction['content']
                    );
                    
                    if (!$introResult['success']) {
                        throw new Exception('Failed to create introduction: ' . $introResult['message']);
                    }
                }
            }
        }

        // Process practicals
        if (isset($_POST['practicals']) && is_array($_POST['practicals'])) {
            foreach ($_POST['practicals'] as $practical) {
                if (!empty($practical['title']) && !empty($practical['description'])) {
                    $practicalResult = $practicalController->create(
                        $subjectId,
                        $practical['title'],
                        $practical['description']
                    );
                    
                    if (!$practicalResult['success']) {
                        throw new Exception('Failed to create practical: ' . $practicalResult['message']);
                    }
                }
            }
        }

        // Commit transaction
        $pdo->commit();

        $_SESSION['success'] = 'Subject created successfully with all introductions and practicals';
        header('Location: subjectsList.php');
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        if (isset($pdo)) {
            $pdo->rollBack();
        }
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Subject - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
        }

        .btn-add {
            background: linear-gradient(135deg, #0088cc 0%, #0077b3 100%);
            color: white;
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
            margin-bottom: 20px;
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .dynamic-form-section {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
            position: relative;
        }

        .remove-section {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .section-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .section-title {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 5px;
        }

        .section-description {
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <div class="container">
        <div class="content-header">
            <h2>Create New Subject</h2>
            <div class="actions">
                <a href="subjectsList.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Subjects
                </a>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" id="createSubjectForm">
            <div class="card">
                <div class="section-header">
                    <h3 class="section-title">Subject Details</h3>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required class="form-control" 
                           placeholder="Enter subject name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required class="form-control" 
                              placeholder="Enter subject description"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>
            </div>

            <!-- Introductions Section -->
            <div class="card">
                <div class="section-header">
                    <h3 class="section-title">Introductions</h3>
                    <p class="section-description">Add introduction sessions for this subject</p>
                </div>
                <div id="introductionsContainer">
                    <!-- Dynamic introduction fields will be added here -->
                </div>
                <button type="button" class="btn btn-add" onclick="addIntroduction()">
                    <i class="fas fa-plus"></i> Add Introduction
                </button>
            </div>

            <!-- Practicals Section -->
            <div class="card">
                <div class="section-header">
                    <h3 class="section-title">Practicals</h3>
                    <p class="section-description">Add practical sessions for this subject</p>
                </div>
                <div id="practicalsContainer">
                    <!-- Dynamic practical fields will be added here -->
                </div>
                <button type="button" class="btn btn-add" onclick="addPractical()">
                    <i class="fas fa-plus"></i> Add Practical
                </button>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Subject
                </button>
                <a href="subjectsList.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        let introductionCount = 0;
        let practicalCount = 0;

        function addIntroduction() {
            const container = document.getElementById('introductionsContainer');
            const section = document.createElement('div');
            section.className = 'dynamic-form-section';
            section.innerHTML = `
                <button type="button" class="remove-section" onclick="this.parentElement.remove()">×</button>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="introductions[${introductionCount}][title]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea name="introductions[${introductionCount}][content]" class="form-control" required></textarea>
                </div>
            `;
            container.appendChild(section);
            introductionCount++;
        }

        function addPractical() {
            const container = document.getElementById('practicalsContainer');
            const section = document.createElement('div');
            section.className = 'dynamic-form-section';
            section.innerHTML = `
                <button type="button" class="remove-section" onclick="this.parentElement.remove()">×</button>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="practicals[${practicalCount}][title]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="practicals[${practicalCount}][description]" class="form-control" required></textarea>
                </div>
            `;
            container.appendChild(section);
            practicalCount++;
        }

        // Add one empty section of each type by default
        document.addEventListener('DOMContentLoaded', function() {
            addIntroduction();
            addPractical();
        });
    </script>

    <?php include_once 'includes/footer.php'; ?>
</body>
</html> 