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

// Get subject ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: index.php');
    exit();
}

// Get existing subject data
$subject = $subjectController->getById($id);
if (!$subject) {
    $_SESSION['error'] = 'Subject not found';
    header('Location: index.php');
    exit();
}

// Get existing introductions and practicals
$introductions = $introductionController->getBySubjectId($id);
$practicals = $practicalController->getBySubjectId($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $pdo = getPDO();
        $pdo->beginTransaction();

        // Check for forbidden characters (em dash)
        $forbiddenPattern = '/[—]/u';
        $fieldsToCheck = [
            $_POST['name'],
            $_POST['description']
        ];
        foreach ($fieldsToCheck as $field) {
            if (preg_match($forbiddenPattern, $field)) {
                throw new Exception('Your input contains forbidden characters (such as em dash —). Please use a regular dash (-) instead.');
            }
        }

        // Update subject
        $result = $subjectController->update(
            $id,
            $_POST['name'],
            $_POST['description']
        );

        if (!$result['success']) {
            throw new Exception($result['message']);
        }

        // Process introductions
        if (isset($_POST['introductions']) && is_array($_POST['introductions'])) {
            foreach ($_POST['introductions'] as $intro) {
                if (!empty($intro['id'])) {
                    // Update existing introduction
                    if (!empty($intro['title']) && !empty($intro['content'])) {
                        $introResult = $introductionController->update(
                            $intro['id'],
                            $id,
                            $intro['title'],
                            $intro['content']
                        );
                        
                        if (!$introResult['success']) {
                            throw new Exception('Failed to update introduction: ' . $introResult['message']);
                        }
                    }
                } else {
                    // Create new introduction
                    if (!empty($intro['title']) && !empty($intro['content'])) {
                        $introResult = $introductionController->create(
                            $id,
                            $intro['title'],
                            $intro['content']
                        );
                        
                        if (!$introResult['success']) {
                            throw new Exception('Failed to create introduction: ' . $introResult['message']);
                        }
                    }
                }
            }
        }

        // Process practicals
        if (isset($_POST['practicals']) && is_array($_POST['practicals'])) {
            foreach ($_POST['practicals'] as $practical) {
                if (!empty($practical['id'])) {
                    // Update existing practical
                    if (!empty($practical['title']) && !empty($practical['description'])) {
                        $practicalResult = $practicalController->update(
                            $practical['id'],
                            $id,
                            $practical['title'],
                            $practical['description']
                        );
                        
                        if (!$practicalResult['success']) {
                            throw new Exception('Failed to update practical: ' . $practicalResult['message']);
                        }
                    }
                } else {
                    // Create new practical
                    if (!empty($practical['title']) && !empty($practical['description'])) {
                        $practicalResult = $practicalController->create(
                            $id,
                            $practical['title'],
                            $practical['description']
                        );
                        
                        if (!$practicalResult['success']) {
                            throw new Exception('Failed to create practical: ' . $practicalResult['message']);
                        }
                    }
                }
            }
        }

        // Process deletions
        if (isset($_POST['delete_introductions']) && is_array($_POST['delete_introductions'])) {
            foreach ($_POST['delete_introductions'] as $introId) {
                $deleteResult = $introductionController->delete($introId);
                if (!$deleteResult['success']) {
                    throw new Exception('Failed to delete introduction: ' . $deleteResult['message']);
                }
            }
        }

        if (isset($_POST['delete_practicals']) && is_array($_POST['delete_practicals'])) {
            foreach ($_POST['delete_practicals'] as $practicalId) {
                $deleteResult = $practicalController->delete($practicalId);
                if (!$deleteResult['success']) {
                    throw new Exception('Failed to delete practical: ' . $deleteResult['message']);
                }
            }
        }

        // Commit transaction
        $pdo->commit();

        $_SESSION['success'] = 'Subject updated successfully with all introductions and practicals';
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
    <title>Edit Subject - Admin Panel</title>
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            color: white;
        }

        .btn-add {
            background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
            color: white;
            padding: 4px 8px;
            font-size: 0.9em;
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
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
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
            font-size: 18px;
        }

        .section-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 1.2em;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-count {
            background: #e1f5fe;
            color: #0288d1;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <div class="container">
        <div class="content-header">
            <h2>Edit Subject</h2>
            <div class="actions">
                <a href="subjectsList.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Subjects
                </a>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" id="editSubjectForm">
            <!-- Subject Details -->
            <div class="card">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-book"></i>
                        Subject Details
                    </h3>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required class="form-control" 
                           value="<?php echo htmlspecialchars($subject['name']); ?>">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required class="form-control"><?php echo htmlspecialchars($subject['description']); ?></textarea>
                </div>
            </div>

            <!-- Introductions Section -->
            <div class="card">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-book-open"></i>
                        Introductions
                        <span class="section-count" id="introductionsCount"><?php echo count($introductions); ?></span>
                    </h3>
                </div>
                <div id="introductionsContainer">
                    <?php foreach ($introductions as $index => $intro): ?>
                        <div class="dynamic-form-section">
                            <button type="button" class="remove-section" onclick="removeIntroduction(this, <?php echo $intro['id']; ?>)">×</button>
                            <input type="hidden" name="introductions[<?php echo $index; ?>][id]" value="<?php echo $intro['id']; ?>">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="introductions[<?php echo $index; ?>][title]" class="form-control" required 
                                       value="<?php echo htmlspecialchars($intro['title']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea name="introductions[<?php echo $index; ?>][content]" class="form-control" required><?php echo htmlspecialchars($intro['content']); ?></textarea>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-add" onclick="addIntroduction()">
                    <i class="fas fa-plus"></i> Add Introduction
                </button>
            </div>

            <!-- Practicals Section -->
            <div class="card">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-flask"></i>
                        Practicals
                        <span class="section-count" id="practicalsCount"><?php echo count($practicals); ?></span>
                    </h3>
                </div>
                <div id="practicalsContainer">
                    <?php foreach ($practicals as $index => $practical): ?>
                        <div class="dynamic-form-section">
                            <button type="button" class="remove-section" onclick="removePractical(this, <?php echo $practical['id']; ?>)">×</button>
                            <input type="hidden" name="practicals[<?php echo $index; ?>][id]" value="<?php echo $practical['id']; ?>">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="practicals[<?php echo $index; ?>][title]" class="form-control" required 
                                       value="<?php echo htmlspecialchars($practical['title']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="practicals[<?php echo $index; ?>][description]" class="form-control" required><?php echo htmlspecialchars($practical['description']); ?></textarea>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-add" onclick="addPractical()">
                    <i class="fas fa-plus"></i> Add Practical
                </button>
            </div>

            <!-- Hidden inputs for deletions -->
            <div id="deletionsContainer"></div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Subject
                </button>
                <a href="subjectsList.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        let introductionCount = <?php echo count($introductions); ?>;
        let practicalCount = <?php echo count($practicals); ?>;

        function addIntroduction() {
            const container = document.getElementById('introductionsContainer');
            const section = document.createElement('div');
            section.className = 'dynamic-form-section';
            section.innerHTML = `
                <button type="button" class="remove-section" onclick="removeIntroduction(this)">×</button>
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
            updateIntroductionsCount();
        }

        function addPractical() {
            const container = document.getElementById('practicalsContainer');
            const section = document.createElement('div');
            section.className = 'dynamic-form-section';
            section.innerHTML = `
                <button type="button" class="remove-section" onclick="removePractical(this)">×</button>
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
            updatePracticalsCount();
        }

        function removeIntroduction(button, id = null) {
            const section = button.parentElement;
            section.remove();
            if (id) {
                const deletionsContainer = document.getElementById('deletionsContainer');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_introductions[]';
                input.value = id;
                deletionsContainer.appendChild(input);
            }
            updateIntroductionsCount();
        }

        function removePractical(button, id = null) {
            const section = button.parentElement;
            section.remove();
            if (id) {
                const deletionsContainer = document.getElementById('deletionsContainer');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_practicals[]';
                input.value = id;
                deletionsContainer.appendChild(input);
            }
            updatePracticalsCount();
        }

        function updateIntroductionsCount() {
            const count = document.getElementById('introductionsContainer').children.length;
            document.getElementById('introductionsCount').textContent = count;
        }

        function updatePracticalsCount() {
            const count = document.getElementById('practicalsContainer').children.length;
            document.getElementById('practicalsCount').textContent = count;
        }
    </script>

    <?php include_once 'includes/footer.php'; ?>
</body>
</html> 