<?php
// Include the configuration file
include("config.php");

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$title = $conn->real_escape_string($data['title']);
$column_name = $conn->real_escape_string($data['column_name']);

// Map column names from the front-end to the database values
if ($column_name == 'todo-items') {
    $column_name = 'todo';
} elseif ($column_name == 'inprogress-items') {
    $column_name = 'inprogress';
} elseif ($column_name == 'done-items') {
    $column_name = 'done';
}

$sql = "INSERT INTO tasks (title, column_name) VALUES ('$title', '$column_name')";

if ($conn->query($sql)) {
    echo json_encode(["id" => $conn->insert_id, "title" => $title, "column_name" => $column_name]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
