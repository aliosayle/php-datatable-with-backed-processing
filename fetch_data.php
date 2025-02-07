<?php
error_reporting(E_ALL); // Report all errors
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/debug.log'); // Log errors to the debug.log file

$host = 'localhost';
$db = 'search_builder';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Create a mysqli connection
$mysqli = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($mysqli->connect_error) {
    echo "Connection failed: " . $mysqli->connect_error;
    exit;
}

// Set the character set to utf8mb4
$mysqli->set_charset($charset);

// Log the incoming POST data to 'debug.log'
file_put_contents(__DIR__ . '/debug.log', print_r($_POST, true));

// DataTables request parameters
$draw = $_POST['draw'] ?? 0;
$start = $_POST['start'] ?? 0;
$length = $_POST['length'] ?? 10;
$searchValue = $_POST['search']['value'] ?? '';
$searchBuilder = $_POST['searchBuilder'] ?? [];
$orderColumnIndex = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];

// Check if 'searchBuilder' is set and decode it safely

// If 'searchBuilder' is null or empty, proceed with an empty array or default behavior
if ($searchBuilder === null) {
    $searchBuilder = [];
}

// Base query for counting total records
$totalRecordsResult = $mysqli->query("SELECT COUNT(*) FROM users");
$totalRecords = $totalRecordsResult->fetch_row()[0];

// Define the fields to be selected and searched
$fields = ['id', 'name', 'email', 'country'];

// Build the base query
$query = "SELECT " . implode(", ", $fields) . " FROM users";
$whereClauses = [];
$params = [];
$types = ''; // String to hold the parameter types for mysqli

// Add parameters to query
if (!empty($searchValue)) {
    $searchConditions = [];
    foreach ($fields as $field) {
        if ($field !== 'id') { // Assuming 'id' should not be searched
            $searchConditions[] = "$field LIKE ?";
            $params[] = "%$searchValue%";
            $types .= 's'; // String type for parameters
        }
    }
    if (!empty($searchConditions)) {
        $whereClauses[] = "(" . implode(" OR ", $searchConditions) . ")";
    }
}

file_put_contents(__DIR__ . '/search_builder.log', print_r($searchBuilder, return: true));


// Process SearchBuilder criteria
if (isset($searchBuilder['criteria']) && is_array($searchBuilder['criteria'])) {
    foreach ($searchBuilder['criteria'] as $criterion) {
        $field = $criterion['data']; // Corrected field name
        $condition = $criterion['condition'];
        $value = $criterion['value'][0]; // Get the value from the array

        // Build the query condition based on the selected condition
        switch ($condition) {
            case '=':
                $whereClauses[] = "$field = ?";
                $params[] = $value;
                $types .= 's'; // String type for parameters
                break;
            case '!=':
                $whereClauses[] = "$field != ?";
                $params[] = $value;
                $types .= 's';
                break;
            case 'contains':
                $whereClauses[] = "$field LIKE ?";
                $params[] = "%$value%";
                $types .= 's';
                break;
            case 'starts':
                $whereClauses[] = "LEFT($field, LENGTH(?)) = ?";
                $params[] = $value;
                $params[] = $value;
                $types .= 'ss';
                break;
            case '!starts':
                $whereClauses[] = "NOT LEFT($field, LENGTH(?)) = ?";
                $params[] = $value;
                $params[] = $value;
                $types .= 'ss';
                break;
            case 'ends':
                $whereClauses[] = "$field LIKE CONCAT('%', ?)";
                $params[] = $value;
                $types .= 's';
                break;
            case '!ends':
                $whereClauses[] = "$field NOT LIKE CONCAT('%', ?)";
                $params[] = $value;
                $types .= 's';
                break;
            case '>':
                $whereClauses[] = "$field > ?";
                $params[] = $value;
                $types .= 's';
                break;
            case '<':
                $whereClauses[] = "$field < ?";
                $params[] = $value;
                $types .= 's';
                break;
            case '>=':
                $whereClauses[] = "$field >= ?";
                $params[] = $value;
                $types .= 's';
                break;
            case '<=':
                $whereClauses[] = "$field <= ?";
                $params[] = $value;
                $types .= 's';
                break;
            case 'between':
                $whereClauses[] = "$field BETWEEN ? AND ?";
                $params[] = $criterion['value'][0];
                $params[] = $criterion['value'][1];
                $types .= 'ii';
                break;
            case 'null':
                $whereClauses[] = "$field IS NULL";
                break;
            case '!null':
                $whereClauses[] = "$field IS NOT NULL";
                break;
        }
    }
}


// Combine WHERE clauses if any
if (!empty($whereClauses)) {
    $query .= " WHERE " . implode(" AND ", $whereClauses);
}

// Count filtered records
$filteredQuery = "SELECT COUNT(*) FROM users";
if (!empty($whereClauses)) {
    $filteredQuery .= " WHERE " . implode(" AND ", $whereClauses);
}

$filteredStmt = $mysqli->prepare($filteredQuery);

// Only bind parameters if there are parameters
if (!empty($types)) {
    $filteredStmt->bind_param($types, ...$params);
}

$filteredStmt->execute();
$filteredResult = $filteredStmt->get_result();
$filteredRecords = $filteredResult->fetch_row()[0];

if (isset($orderColumnIndex) && isset($orderDirection)) {
    $query .= " ORDER BY $fields[$orderColumnIndex] $orderDirection";
}


// Add pagination only if needed
$query .= " LIMIT ?, ?";
$params[] = (int) $start;
$params[] = (int) $length;
$types .= 'ii'; // Integer types for pagination parameters

file_put_contents(__DIR__ . '/query.log', json_encode($query, JSON_PRETTY_PRINT));


// Execute the main query
$stmt = $mysqli->prepare($query);

// Only bind parameters if there are parameters
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$recordsResult = $stmt->get_result();
$records = $recordsResult->fetch_all(MYSQLI_ASSOC);

// Prepare JSON response
$response = [
    "draw" => (int) $draw,
    "recordsTotal" => (int) $totalRecords,
    "recordsFiltered" => (int) $filteredRecords,
    "data" => $records,
];

// Log the response to 'response.log'
file_put_contents(__DIR__ . '/response.log', json_encode($response, JSON_PRETTY_PRINT));

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the statement and connection
$stmt->close();
$filteredStmt->close();
$mysqli->close();
