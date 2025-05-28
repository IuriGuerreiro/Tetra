<?php
// Make sure the file is not accessed directly
defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(__FILE__)));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/User.php';

class SubjectController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Get all subjects
     * 
     * @return array Array of subjects or error message
     */
    public function getAll() {
        $query = "SELECT * FROM subjects ORDER BY created_at DESC";
        $result = executeQuery($query, []);
        
        if ($result['success']) {
            return $result['results'];
        }
        
        return [];
    }

    /**
     * Get a subject by ID
     * 
     * @param int $id Subject ID
     * @return array|null Subject data or null if not found
     */
    public function getById($id) {
        $query = "SELECT * FROM subjects WHERE id = ?";
        $result = executeQuery($query, [$id]);
        
        if ($result['success'] && !empty($result['results'])) {
            return $result['results'][0];
        }
        
        return null;
    }

    /**
     * Create a new subject
     * 
     * @param string $name Subject name
     * @param string $description Subject description
     * @return array Success status and message
     */
    public function create($name, $description) {
        try {
            $user = new User(GetPDO());
            if (!$user->isLoggedIn() || !$user->isAdmin()) {
                $_SESSION['error'] = 'You do not have permission to perform this action';
                header('Location: login.php');
                exit();
            }
            // Validate input
            if (empty($name) || empty($description)) {
                return [
                    'success' => false,
                    'message' => 'All fields are required'
                ];
            }

            $query = "INSERT INTO subjects (name, description, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
            $result = executeQuery($query, [$name, $description]);

            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Subject created successfully',
                    'id' => $result['last_insert_id']
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create subject'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while creating the subject: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update a subject
     * 
     * @param int $id Subject ID
     * @param string $name Subject name
     * @param string $description Subject description
     * @return array Success status and message
     */
    public function update($id, $name, $description) {
        try {
            $user = new User(GetPDO());
            if (!$user->isLoggedIn() || !$user->isAdmin()) {
                $_SESSION['error'] = 'You do not have permission to perform this action';
                header('Location: login.php');
                exit();
            }
            // Validate input
            if (empty($id) || empty($name) || empty($description)) {
                return [
                    'success' => false,
                    'message' => 'All fields are required'
                ];
            }

            // Check if subject exists
            $subject = $this->getById($id);
            if (!$subject) {
                return [
                    'success' => false,
                    'message' => 'Subject not found'
                ];
            }

            $query = "UPDATE subjects SET name = ?, description = ?, updated_at = NOW() WHERE id = ?";
            $result = executeQuery($query, [$name, $description, $id]);

            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Subject updated successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to update subject'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while updating the subject: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete a subject
     * 
     * @param int $id Subject ID
     * @return array Success status and message
     */
    public function delete($id) {
        try {
            $user = new User(GetPDO());
            if (!$user->isLoggedIn() || !$user->isAdmin()) {
                $_SESSION['error'] = 'You do not have permission to perform this action';
                header('Location: login.php');
                exit();
            }
            // Check if subject exists
            $subject = $this->getById($id);
            if (!$subject) {
                return [
                    'success' => false,
                    'message' => 'Subject not found'
                ];
            }

            $query = "DELETE FROM subjects WHERE id = ?";
            $result = executeQuery($query, [$id]);

            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Subject deleted successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to delete subject'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while deleting the subject: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get total count of subjects
     * 
     * @return int Total count of subjects
     */
    public function getTotalSubjects() {
        $query = "SELECT COUNT(*) as total FROM subjects";
        $result = executeQuery($query, []);
        
        if ($result['success'] && !empty($result['results'])) {
            return (int)$result['results'][0]['total'];
        }
        
        return 0;
    }
} 