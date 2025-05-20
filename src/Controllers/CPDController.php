<?php
// Make sure the file is not accessed directly
defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(__FILE__)));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/User.php';

class CPDController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Get all CPDs
     * 
     * @return array Array of CPDs or error message
     */
    public function getAll() {
        $query = "SELECT * FROM cpds ORDER BY created_at DESC";
        $result = executeQuery($query, []);
        
        if ($result['success']) {
            return $result['results'];
        }
        
        return [];
    }

    /**
     * Get a single CPD by ID
     * 
     * @param int $id CPD ID
     * @return array|false CPD data or false if not found
     */
    public function getById($id) {
        $query = "SELECT * FROM cpds WHERE id = :id";
        $result = executeQuery($query, [':id' => $id]);
        
        if ($result['success'] && !empty($result['results'])) {
            return $result['results'][0];
        }
        
        return false;
    }

    /**
     * Create a new CPD
     * 
     * @param string $title CPD title
     * @param string $description CPD description
     * @param string $abstract CPD abstract
     * @param string|null $imagePath Path to the CPD image (optional)
     * @param string $registrationLink Registration link for the CPD
     * @return array Result with success status and message
     */
    public function create($title, $description, $abstract, $imagePath = null, $registrationLink) {
        // Ensure user is logged in and is admin

        $user = new User(GetPDO());
        if (!$user->isLoggedIn() || !$user->isAdmin()) {
            $_SESSION['error'] = 'You do not have permission to perform this action';
            header('Location: login.php');
            exit();
        }
        
        $query = "INSERT INTO cpds (
            title, 
            description, 
            abstract, 
            image_path, 
            registration_link,
            created_at,
            updated_at
        ) VALUES (
            :title, 
            :description, 
            :abstract, 
            :image_path, 
            :registration_link,
            CURRENT_TIMESTAMP,
            CURRENT_TIMESTAMP
        )";
        
        $params = [
            ':title' => $title,
            ':description' => $description,
            ':abstract' => $abstract,
            ':image_path' => $imagePath,
            ':registration_link' => $registrationLink
        ];
        
        $result = executeQuery($query, $params);
        
        if ($result['success']) {
            return [
                'success' => true,
                'id' => $result['last_insert_id'],
                'message' => 'CPD created successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => $result['error'] ?? 'Failed to create CPD'
        ];
    }

    /**
     * Update an existing CPD
     * 
     * @param int $id CPD ID
     * @param string $title CPD title
     * @param string $description CPD description
     * @param string $abstract CPD abstract
     * @param string|null $imagePath Path to the CPD image (optional)
     * @param string $registrationLink Registration link for the CPD
     * @return array Result with success status and message
     */
    public function update($id, $title, $description, $abstract, $imagePath = null, $registrationLink) {
        // Ensure user is logged in and is admin
        $user = new User(GetPDO());
        if (!$user->isLoggedIn() || !$user->isAdmin()) {
            $_SESSION['error'] = 'You do not have permission to perform this action';
            header('Location: login.php');
            exit();
        }
        
        $existing = $this->getById($id);
        if (!$existing) {
            return [
                'success' => false,
                'message' => 'CPD not found'
            ];
        }
        
        $query = "UPDATE cpds SET 
            title = :title,
            description = :description,
            abstract = :abstract,
            image_path = :image_path,
            registration_link = :registration_link,
            updated_at = CURRENT_TIMESTAMP
            WHERE id = :id";
            
        $params = [
            ':id' => $id,
            ':title' => $title,
            ':description' => $description,
            ':abstract' => $abstract,
            ':image_path' => $imagePath,
            ':registration_link' => $registrationLink
        ];
        
        $result = executeQuery($query, $params);
        
        if ($result['success']) {
            return [
                'success' => true,
                'message' => 'CPD updated successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => $result['error'] ?? 'Failed to update CPD'
        ];
    }

    /**
     * Delete a CPD
     * 
     * @param int $id CPD ID
     * @return array Result with success status and message
     */
    public function delete($id) {
        // Ensure user is logged in and is admin
        $user = new User(GetPDO());
        if (!$user->isLoggedIn() || !$user->isAdmin()) {
            $_SESSION['error'] = 'You do not have permission to perform this action';
            header('Location: login.php');
            exit();
        }

        $query = "DELETE FROM cpds WHERE id = :id";
        $result = executeQuery($query, [':id' => $id]);
        
        if ($result['success'] && $result['affected_rows'] > 0) {
            return [
                'success' => true,
                'message' => 'CPD deleted successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => $result['error'] ?? 'Failed to delete CPD or CPD not found'
        ];
    }

    /**
     * Get total count of CPDs
     * 
     * @return int Total count of CPDs
     */
    public function getTotalCPDs() {
        $query = "SELECT COUNT(*) as total FROM cpds";
        $result = executeQuery($query, []);
        
        if ($result['success'] && !empty($result['results'])) {
            return (int)$result['results'][0]['total'];
        }
        
        return 0;
    }
}
