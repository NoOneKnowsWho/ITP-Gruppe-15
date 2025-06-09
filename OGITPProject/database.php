<?php
// config/database.php - Database configuration
class Database {
    private $host = "localhost";
    private $db_name = "coffee_webshop";
    private $username = "root"; // Change to your DB username
    private $password = "";     // Change to your DB password
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                                $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// classes/User.php - User management class
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $phone;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register new user
    public function register() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET email=:email, password_hash=:password, first_name=:first_name, 
                      last_name=:last_name, phone=:phone";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        // Hash password
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":phone", $this->phone);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Login user
    public function login() {
        $query = "SELECT id, email, password_hash, first_name, last_name, phone 
                  FROM " . $this->table_name . " 
                  WHERE email = :email AND is_active = 1 LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row && password_verify($this->password, $row['password_hash'])) {
            $this->id = $row['id'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->phone = $row['phone'];
            return true;
        }
        return false;
    }

    // Check if email exists
    public function emailExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    // Get user by ID
    public function getUserById($user_id) {
        $query = "SELECT id, email, first_name, last_name, phone, created_at 
                  FROM " . $this->table_name . " 
                  WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $user_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// auth/session.php - Session management
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'first_name' => $_SESSION['user_first_name'],
            'last_name' => $_SESSION['user_last_name']
        ];
    }
    return null;
}

function logout() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>