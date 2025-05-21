<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/User.php';

// Initialize User
$user = new User(getPDO());

// Define allowed upload directories
$ALLOWED_DIRECTORIES = [
    'cpds' => 'cpds',
    'default' => ''
];

function handleImageUpload() {
    global $ALLOWED_DIRECTORIES, $user;

    // Ensure user is logged in and is admin
    if (!$user->isLoggedIn() || !$user->isAdmin()) {
        return [
            'success' => false,
            'message' => 'You do not have permission to perform this action'
        ];
    }

    try {
        // Handle image upload
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            // Get the type parameter from POST data
            $type = isset($_POST['type']) ? $_POST['type'] : 'default';
            
            // Get the corresponding directory name
            $directory = isset($ALLOWED_DIRECTORIES[$type]) ? $ALLOWED_DIRECTORIES[$type] : $ALLOWED_DIRECTORIES['default'];
            
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $upload_dir = "../../public/assets/images/uploads/$directory/";
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file_extension, $allowed_extensions)) {
                throw new Exception('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');
            }

            $image_name = uniqid() . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $image_name;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                throw new Exception('Failed to upload image.');
            }

            return [
                'success' => true,
                'message' => 'Image uploaded successfully',
                'path' => "/Treta/public/assets/images/uploads/$directory/$image_name",
                'DatabasePath' => "uploads/$directory/$image_name"
            ];
        } else {
            throw new Exception('No image uploaded');
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

// If this file is called directly (not included), handle as an API endpoint
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    header('Content-Type: application/json');
    $result = handleImageUpload();
    echo json_encode($result);
    exit;
}
?>
