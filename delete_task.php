<?php
// Include the configuration file
include ("./config.php");

header('Content-Type: application/json'); // Ensure the response is JSON

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get the raw POST data and decode it
$data = json_decode(file_get_contents('php://input'), true);

// Check if the task ID is provided
if (!isset($data['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Task ID is required']);
    exit;
}

$taskId = $data['id'];

// Connect to the database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=task_management_kanban_style', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete the task from the database
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Task deleted successfully']);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['success' => false, 'message' => 'Task not found']);
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
