<?php
// Include the configuration file
include("./config.php");

header("Content-Type: application/json");
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $conn->real_escape_string($data['id']);
$column_name = $conn->real_escape_string($data['column_name']);

// Map column names from the front-end to the database values
if ($column_name == 'todo-items') {
    $column_name = 'todo';
} elseif ($column_name == 'inprogress-items') {
    $column_name = 'inprogress';
} elseif ($column_name == 'done-items') {
    $column_name = 'done';
}

$sql = "UPDATE tasks SET column_name = '$column_name', updated_at = NOW() WHERE id = $id";

if ($conn->query($sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
