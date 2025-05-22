<?php
// Make sure the file is not accessed directly
defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(__FILE__)));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../Controllers/User.php';

class DeliveryModeController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Get all delivery modes
     * 
     * @return array Array of delivery modes or error message
     */
    public function getAll() {
        $query = "SELECT * FROM delivery_modes ORDER BY name ASC";
        $result = executeQuery($query, []);
        
        if ($result['success']) {
            return $result['results'];
        }
        
        return [];
    }

    /**
     * Get a single delivery mode by ID
     * 
     * @param int $id Delivery mode ID
     * @return array|false Delivery mode data or false if not found
     */
    public function getById($id) {
        $query = "SELECT * FROM delivery_modes WHERE id = :id";
        $result = executeQuery($query, [':id' => $id]);
        
        if ($result['success'] && !empty($result['results'])) {
            return $result['results'][0];
        }
        
        return false;
    }

    /**
     * Create a new delivery mode
     * 
     * @param string $name Delivery mode name
     * @return array Result with success status and message
     */
    public function create($name) {
        // Ensure user is logged in and is admin
        $user = new User(GetPDO());
        if (!$user->isLoggedIn() || !$user->isAdmin()) {
            $_SESSION['error'] = 'You do not have permission to perform this action';
            header('Location: login.php');
            exit();
        }
        
        $query = "INSERT INTO delivery_modes (
            name,
            created_at,
            updated_at
        ) VALUES (
            :name,
            CURRENT_TIMESTAMP,
            CURRENT_TIMESTAMP
        )";
        
        $params = [
            ':name' => $name
        ];
        
        $result = executeQuery($query, $params);
        
        if ($result['success']) {
            return [
                'success' => true,
                'id' => $result['last_insert_id'],
                'message' => 'Delivery mode created successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => $result['error'] ?? 'Failed to create delivery mode'
        ];
    }

    /**
     * Update an existing delivery mode
     * 
     * @param int $id Delivery mode ID
     * @param string $name New delivery mode name
     * @return array Result with success status and message
     */
    public function update($id, $name) {
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
                'message' => 'Delivery mode not found'
            ];
        }
        
        $query = "UPDATE delivery_modes SET 
            name = :name,
            updated_at = CURRENT_TIMESTAMP
            WHERE id = :id";
            
        $params = [
            ':id' => $id,
            ':name' => $name
        ];
        
        $result = executeQuery($query, $params);
        
        if ($result['success']) {
            return [
                'success' => true,
                'message' => 'Delivery mode updated successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => $result['error'] ?? 'Failed to update delivery mode'
        ];
    }

    /**
     * Delete a delivery mode
     * 
     * @param int $id Delivery mode ID
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

        // Check if delivery mode is being used by any CPDs
        $query = "SELECT COUNT(*) as count FROM cpds WHERE delivery_mode_id = :id";
        $result = executeQuery($query, [':id' => $id]);
        
        if ($result['success'] && $result['results'][0]['count'] > 0) {
            return [
                'success' => false,
                'message' => 'Cannot delete delivery mode as it is being used by one or more CPDs'
            ];
        }

        $query = "DELETE FROM delivery_modes WHERE id = :id";
        $result = executeQuery($query, [':id' => $id]);
        
        if ($result['success'] && $result['affected_rows'] > 0) {
            return [
                'success' => true,
                'message' => 'Delivery mode deleted successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => $result['error'] ?? 'Failed to delete delivery mode or delivery mode not found'
        ];
    }

    /**
     * Get total count of delivery modes
     * 
     * @return int Total count of delivery modes
     */
    public function getTotalDeliveryModes() {
        $query = "SELECT COUNT(*) as total FROM delivery_modes";
        $result = executeQuery($query, []);
        
        if ($result['success'] && !empty($result['results'])) {
            return (int)$result['results'][0]['total'];
        }
        
        return 0;
    }
} 