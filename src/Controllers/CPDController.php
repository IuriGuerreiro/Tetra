<?php
// Make sure the file is not accessed directly
defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(__FILE__)));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/User.php';
require_once __DIR__ . '/../Controllers/DeliveryModeController.php';

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
        $query = "SELECT cpds.*, delivery_modes.name AS delivery_mode FROM cpds LEFT JOIN delivery_modes ON cpds.delivery_mode_id = delivery_modes.id ORDER BY cpds.created_at DESC";
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
        $query = "SELECT cpds.*, delivery_modes.name AS delivery_mode FROM cpds LEFT JOIN delivery_modes ON cpds.delivery_mode_id = delivery_modes.id WHERE cpds.id = :id";
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
     * @param int $duration_hours Duration in hours
     * @param string $course_rationale Course rationale and content
     * @param string $course_objectives Overall course objectives
     * @param string $learning_outcomes Learning outcomes
     * @param string $course_procedures Course procedures
     * @param int $delivery_mode_id Mode of delivery
     * @param string $assessment_procedure Assessment procedure
     * @param string|null $imagePath Path to the CPD image (optional)
     * @return array Result with success status and message
     */
    public function create($title, $duration_hours, $course_rationale, $course_objectives, $learning_outcomes, $course_procedures, $delivery_mode_id, $assessment_procedure, $imagePath = null) {
        // Ensure user is logged in and is admin
        $user = new User(GetPDO());
        if (!$user->isLoggedIn() || !$user->isAdmin()) {
            $_SESSION['error'] = 'You do not have permission to perform this action';
            header('Location: login.php');
            exit();
        }
        $deliveryModeController = new DeliveryModeController(GetPDO());
        $deliveryMode = $deliveryModeController->getById($delivery_mode_id);
        if (!$deliveryMode) {
            return [
                'success' => false,
                'message' => 'Invalid delivery mode selected.'
            ];
        }
        $query = "INSERT INTO cpds (
            title, 
            duration_hours,
            course_rationale,
            course_objectives,
            learning_outcomes,
            course_procedures,
            delivery_mode_id,
            assessment_procedure,
            image_path, 
            created_at,
            updated_at
        ) VALUES (
            :title, 
            :duration_hours,
            :course_rationale,
            :course_objectives,
            :learning_outcomes,
            :course_procedures,
            :delivery_mode_id,
            :assessment_procedure,
            :image_path, 
            CURRENT_TIMESTAMP,
            CURRENT_TIMESTAMP
        )";
        $params = [
            ':title' => $title,
            ':duration_hours' => $duration_hours,
            ':course_rationale' => $course_rationale,
            ':course_objectives' => $course_objectives,
            ':learning_outcomes' => $learning_outcomes,
            ':course_procedures' => $course_procedures,
            ':delivery_mode_id' => $delivery_mode_id,
            ':assessment_procedure' => $assessment_procedure,
            ':image_path' => $imagePath
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
     * @param int $duration_hours Duration in hours
     * @param string $course_rationale Course rationale and content
     * @param string $course_objectives Overall course objectives
     * @param string $learning_outcomes Learning outcomes
     * @param string $course_procedures Course procedures
     * @param int $delivery_mode_id Mode of delivery
     * @param string $assessment_procedure Assessment procedure
     * @param string|null $imagePath Path to the CPD image (optional)
     * @return array Result with success status and message
     */
    public function update($id, $title, $duration_hours, $course_rationale, $course_objectives, $learning_outcomes, $course_procedures, $delivery_mode_id, $assessment_procedure, $imagePath = null) {
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
        $deliveryModeController = new DeliveryModeController(GetPDO());
        $deliveryMode = $deliveryModeController->getById($delivery_mode_id);
        if (!$deliveryMode) {
            return [
                'success' => false,
                'message' => 'Invalid delivery mode selected.'
            ];
        }
        $query = "UPDATE cpds SET 
            title = :title,
            duration_hours = :duration_hours,
            course_rationale = :course_rationale,
            course_objectives = :course_objectives,
            learning_outcomes = :learning_outcomes,
            course_procedures = :course_procedures,
            delivery_mode_id = :delivery_mode_id,
            assessment_procedure = :assessment_procedure,
            image_path = :image_path,
            updated_at = CURRENT_TIMESTAMP
            WHERE id = :id";
        $params = [
            ':id' => $id,
            ':title' => $title,
            ':duration_hours' => $duration_hours,
            ':course_rationale' => $course_rationale,
            ':course_objectives' => $course_objectives,
            ':learning_outcomes' => $learning_outcomes,
            ':course_procedures' => $course_procedures,
            ':delivery_mode_id' => $delivery_mode_id,
            ':assessment_procedure' => $assessment_procedure,
            ':image_path' => $imagePath
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
