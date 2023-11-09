<?php
// Start or resume the user's session
session_start();

// Destroy the session data
session_destroy();

// Redirect the user to the sign-in or home page
header("Location: ../pages/login.php"); // Replace with the appropriate URL
exit; // Make sure to exit to prevent further execution
