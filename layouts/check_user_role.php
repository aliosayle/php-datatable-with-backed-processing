<?php
// Include the database configuration
require_once "config.php";

// Function to check if the user is an admin
function isAdmin($user_id) {
    global $link;
    $is_admin = false;

    // Check if the database connection is established
    if (!$link) {
        // Log the error if the database connection fails
        error_log("Database connection failed: " . mysqli_connect_error());
        return $is_admin;
    }

    // Query to check if the user is an admin
    $sql = "SELECT isadmin FROM users WHERE id = ?";

    // Prepare the SQL statement
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind the user ID to the query
        mysqli_stmt_bind_param($stmt, "i", $user_id);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Store the result
            mysqli_stmt_store_result($stmt);
            // Bind the result to the $isadmin variable
            mysqli_stmt_bind_result($stmt, $isadmin);

            // Fetch the result
            if (mysqli_stmt_fetch($stmt)) {
                // If the user is an admin (isadmin = 1), set $is_admin to true
                if ($isadmin == 1) {
                    $is_admin = true;
                }
            } else {
                // If no result is returned, log the error
                error_log("No result returned for user_id " . $user_id);
            }
        } else {
            // Log an error if the query execution fails
            error_log("Error executing query: " . mysqli_error($link));
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Log an error if the SQL statement preparation fails
        error_log("Error preparing SQL statement: " . mysqli_error($link));
    }


    return $is_admin;
}
?>
