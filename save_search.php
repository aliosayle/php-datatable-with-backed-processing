<?php
include 'layouts/config.php';
$conn = $link;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchName = $_POST['searchName'];
    $searchConfig = $_POST['searchConfig'];

    // Prepare and execute the insert query to save the search configuration
    $query = "INSERT INTO saved_searches (search_name, search_config) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $searchName, $searchConfig); // "ss" indicates two strings
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save the search configuration.']);
    }

    $stmt->close();
}

$conn->close();