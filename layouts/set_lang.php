<?php
session_start();

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];

    // Validate the language to prevent invalid values
    if (in_array($lang, ['en', 'fr'])) {
        $_SESSION['lang'] = $lang; // Update the session with the selected language
    }
}

// Redirect back to the referring page
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>
