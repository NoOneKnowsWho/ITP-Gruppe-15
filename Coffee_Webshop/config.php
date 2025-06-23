<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'coffee_shop');
define('DB_USER', 'your_db_username');
define('DB_PASS', 'your_db_password');

// Create database connection
function getDbConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        die("Database connection failed");
    }
}

// Check if user is logged in
function isLoggedIn() {
    session_start();
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Get current user info
function getCurrentUser() {
    session_start();
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username']
        ];
    }
    return null;
}

// Logout user
function logout() {
    session_start();
    session_destroy();
}
?>
