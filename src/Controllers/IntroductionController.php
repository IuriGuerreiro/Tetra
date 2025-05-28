<?php
// Make sure the file is not accessed directly
defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(__FILE__)));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/User.php';

class IntroductionController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Get all introductions
     * 
     * @return array Array of introductions or empty array
     */
    public function getAll() {
        $query = "SELECT i.*, s.name as subject_name 
                 FROM introductions i 
                 JOIN subjects s ON i.subject_id = s.id 
                 ORDER BY i.created_at DESC";
        $result = executeQuery($query, []);
        
        if ($result['success']) {
            return $result['results'];
        }
        
        return [];
    }

    /**
     * Get introductions by subject ID
     * 
     * @param int $subjectId Subject ID
     * @return array Array of introductions for the subject
     */
    public function getBySubjectId($subjectId) {
        $query = "SELECT i.*, s.name as subject_name 
                 FROM introductions i 
                 JOIN subjects s ON i.subject_id = s.id 
                 WHERE i.subject_id = ? 
                 ORDER BY i.created_at ASC";
        $result = executeQuery($query, [$subjectId]);
        
        if ($result['success']) {
            return $result['results'];
        }
        
        return [];
    }

    /**
     * Get a introduction by ID
     * 
     * @param int $id Introduction ID
     * @return array|null Introduction data or null if not found
     */
    public function getById($id) {
        $query = "SELECT i.*, s.name as subject_name 
                 FROM introductions i 
                 JOIN subjects s ON i.subject_id = s.id 
                 WHERE i.id = ?";
        $result = executeQuery($query, [$id]);
        
        if ($result['success'] && !empty($result['results'])) {
            return $result['results'][0];
        }
        
        return null;
    }

    /**
     * Create a new introduction
     * 
     * @param int $subjectId Subject ID
     * @param string $title Introduction title
     * @param string $content Introduction content
     * @return array Success status and message
     */
    public function create($subjectId, $title, $content) {
        try {
            $user = new User(GetPDO());
            if (!$user->isLoggedIn() || !$user->isAdmin()) {
                $_SESSION['error'] = 'You do not have permission to perform this action';
                header('Location: login.php');
                exit();
            }

            // Validate input
            if (empty($subjectId)) {
                return [
                    'success' => false,
                    'message' => 'Subject ID is required'
                ];
            }

            if (empty($title) || trim($title) === '') {
                return [
                    'success' => false,
                    'message' => 'Title is required'
                ];
            }

            if (empty($content) || trim($content) === '') {
                return [
                    'success' => false,
                    'message' => 'Content is required'
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

            $query = "INSERT INTO introductions (subject_id, title, content, created_at, updated_at) 
                     VALUES (?, ?, ?, NOW(), NOW())";
            $result = executeQuery($query, [$subjectId, $title, $content]);

            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Introduction created successfully',
                    'id' => $result['last_insert_id']
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create introduction'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while creating the introduction: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update an introduction
     * 
     * @param int $id Introduction ID
     * @param int $subjectId Subject ID
     * @param string $title Introduction title
     * @param string $content Introduction content
     * @return array Success status and message
     */
    public function update($id, $subjectId, $title, $content) {
        try {
            $user = new User(GetPDO());
            if (!$user->isLoggedIn() || !$user->isAdmin()) {
                $_SESSION['error'] = 'You do not have permission to perform this action';
                header('Location: login.php');
                exit();
            }
            // Validate input
            if (empty($id) || empty($subjectId) || empty($title) || empty($content)) {
                return [
                    'success' => false,
                    'message' => 'All fields are required'
                ];
            }

            // Check if introduction exists
            $introduction = $this->getById($id);
            if (!$introduction) {
                return [
                    'success' => false,
                    'message' => 'Introduction not found'
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

            $query = "UPDATE introductions 
                     SET subject_id = ?, title = ?, content = ?, updated_at = NOW() 
                     WHERE id = ?";
            $result = executeQuery($query, [$subjectId, $title, $content, $id]);

            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Introduction updated successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to update introduction'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while updating the introduction: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete an introduction
     * 
     * @param int $id Introduction ID
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
            // Check if introduction exists
            $introduction = $this->getById($id);
            if (!$introduction) {
                return [
                    'success' => false,
                    'message' => 'Introduction not found'
                ];
            }

            $query = "DELETE FROM introductions WHERE id = ?";
            $result = executeQuery($query, [$id]);

            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Introduction deleted successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to delete introduction'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while deleting the introduction: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get total count of introductions
     * 
     * @return int Total count of introductions
     */
    public function getTotalIntroductions() {
        $query = "SELECT COUNT(*) as total FROM introductions";
        $result = executeQuery($query, []);
        
        if ($result['success'] && !empty($result['results'])) {
            return (int)$result['results'][0]['total'];
        }
        
        return 0;
    }

    /**
     * Get total count of introductions for a subject
     * 
     * @param int $subjectId Subject ID
     * @return int Total count of introductions for the subject
     */
    public function getTotalIntroductionsForSubject($subjectId) {
        $query = "SELECT COUNT(*) as total FROM introductions WHERE subject_id = ?";
        $result = executeQuery($query, [$subjectId]);
        
        if ($result['success'] && !empty($result['results'])) {
            return (int)$result['results'][0]['total'];
        }
        
        return 0;
    }
}