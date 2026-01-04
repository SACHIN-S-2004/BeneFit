<?php

require_once __DIR__ . "/db.php";

/**
 * Ensure user is authenticated
 * Redirects to login page if not logged in
 */
function require_auth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/login.php");
        exit;
    }
}

/**
 * Get current authenticated user ID
 */
function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

function redirect_if_logged_in() {
    if (isset($_SESSION['user_id'])) {
        header("Location: ../public/dashboard.php");
        exit;
    }
}

?>
