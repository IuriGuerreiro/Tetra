<?php
// Make sure the file is not accessed directly
defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(__FILE__)));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/User.php';

class PracticalController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Get all practicals
     * 
     * @return array Array of practicals or empty array
     */
    public function getAll() {
        $query = "SELECT p.*, s.name as subject_name 
                 FROM practicals p 
                 JOIN subjects s ON p.subject_id = s.id 
                 ORDER BY p.created_at DESC";
        $result = executeQuery($query, []);
        
        if ($result['success']) {
            return $result['results'];
        }
        
        return [];
    }

    /**
     * Get practicals by subject ID
     * 
     * @param int $subjectId Subject ID
     * @return array Array of practicals for the subject
     */
    public function getBySubjectId($subjectId) {
        $query = "SELECT p.*, s.name as subject_name 
                 FROM practicals p 
                 JOIN subjects s ON p.subject_id = s.id 
                 WHERE p.subject_id = ? 
                 ORDER BY p.created_at ASC";
        $result = executeQuery($query, [$subjectId]);
        
        if ($result['success']) {
            return $result['results'];
        }
        
        return [];
    }

    /**
     * Get a practical by ID
     * 
     * @param int $id Practical ID
     * @return array|null Practical data or null if not found
     */
    public function getById($id) {
        $query = "SELECT p.*, s.name as subject_name 
                 FROM practicals p 
                 JOIN subjects s ON p.subject_id = s.id 
                 WHERE p.id = ?";
        $result = executeQuery($query, [$id]);
        
        if ($result['success'] && !empty($result['results'])) {
            return $result['results'][0];
        }
        
        return null;
    }

    /**
     * Create a new practical
     * 
     * @param int $subjectId Subject ID
     * @param string $title Practical title
     * @param string $description Practical description
     * @return array Success status and message
     */
    public function create($subjectId, $title, $description) {
        try {
            $user = new User(GetPDO());
            if (!$user->isLoggedIn() || !$user->isAdmin()) {
                $_SESSION['error'] = 'You do not have permission to perform this action';
                header('Location: login.php');
                exit();
            }
            // Validate input
            if (empty($subjectId) || empty($title) || empty($description)) {
                return [
                    'success' => false,
                    'message' => 'All fields are required'
                ];
            }

            // Check if subject exists
            $query = "SELECT id FROM subjects WHERE id = ?";
            $result = executeQuery($query, [$subjectId]);
            if (!$result['success'] || empty($result['results'])) {
                return [
                    'success' => false,
                    'message' => 'Subject not found'
                ];
            }

            $query = "INSERT INTO practicals (subject_id, title, description, created_at, updated_at) 
                     VALUES (?, ?, ?, NOW(), NOW())";
            $result = executeQuery($query, [$subjectId, $title, $description]);

            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Practical created successfully',
                    'id' => $result['lastInsertId']
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create practical'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while creating the practical: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update a practical
     * 
     * @param int $id Practical ID
     * @param int $subjectId Subject ID
     * @param string $title Practical title
     * @param string $description Practical description
     * @return array Success status and message
     */
    public function update($id, $subjectId, $title, $description) {
        try {
            $user = new User(GetPDO());
            if (!$user->isLoggedIn() || !$user->isAdmin()) {
                $_SESSION['error'] = 'You do not have permission to perform this action';
                header('Location: login.php');
                exit();
            }
            // Validate input
            if (empty($id) || empty($subjectId) || empty($title) || empty($description)) {
                return [
                    'success' => false,
                    'message' => 'All fields are required'
                ];
            }

            // Check if practical exists
            $practical = $this->getById($id);
            if (!$practical) {
                return [
                    'success' => false,
                    'message' => 'Practical not found'
                ];
            }

            // Check if subject exists
            $query = "SELECT id FROM subjects WHERE id = ?";
            $result = executeQuery($query, [$subjectId]);
            if (!$result['success'] || empty($result['results'])) {
                return [
                    'success' => false,
                    'message' => 'Subject not found'
                ];
            }

            $query = "UPDATE practicals 
                     SET subject_id = ?, title = ?, description = ?, updated_at = NOW() 
                     WHERE id = ?";
            $result = executeQuery($query, [$subjectId, $title, $description, $id]);

            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Practical updated successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to update practical'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while updating the practical: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete a practical
     * 
     * @param int $id Practical ID
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
            // Check if practical exists
            $practical = $this->getById($id);
            if (!$practical) {
                return [
                    'success' => false,
                    'message' => 'Practical not found'
                ];
            }

            $query = "DELETE FROM practicals WHERE id = ?";
            $result = executeQuery($query, [$id]);

            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Practical deleted successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to delete practical'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while deleting the practical: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get total count of practicals
     * 
     * @return int Total count of practicals
     */
    public function getTotalPracticals() {
        $query = "SELECT COUNT(*) as total FROM practicals";
        $result = executeQuery($query, []);
        
        if ($result['success'] && !empty($result['results'])) {
            return (int)$result['results'][0]['total'];
        }
        
        return 0;
    }

    /**
     * Get total count of practicals for a subject
     * 
     * @param int $subjectId Subject ID
     * @return int Total count of practicals for the subject
     */
    public function getTotalPracticalsForSubject($subjectId) {
        $query = "SELECT COUNT(*) as total FROM practicals WHERE subject_id = ?";
        $result = executeQuery($query, [$subjectId]);
        
        if ($result['success'] && !empty($result['results'])) {
            return (int)$result['results'][0]['total'];
        }
        
        return 0;
    }
} 