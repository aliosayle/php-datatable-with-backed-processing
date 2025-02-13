<?php
include 'layouts/config.php';
$conn = $link;

$query = "SELECT * FROM saved_searches";
$result = $conn->query($query);

$savedSearches = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $savedSearches[] = $row;
    }
}

echo json_encode(['savedSearches' => $savedSearches]);

$conn->close();
?>