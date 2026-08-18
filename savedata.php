<?php
/**
 * savedata.php  (HouseHub)
 * -------------------------------------------------------------
 * Processes the registration form submitted from register.php.
 * Validates input, checks CSRF token, hashes the password, and
 * inserts the new user into the `users` table.
 *
 * On error or success it stores a flash message in the session
 * and redirects back to the home page so the form re-renders
 * with feedback (adjust $HOME_PAGE below to match your setup).
 */

session_start();

$HOME_PAGE = 'index.php'; // change if your home page has a different filename

// ---------- 1. DATABASE CONNECTION ----------
$DB_HOST = 'localhost';
$DB_NAME = 'househub';
$DB_USER = 'your_db_user';
$DB_PASS = 'your_db_password';

try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('Database connection failed. Please try again later.');
}

// ---------- 2. ONLY HANDLE THE REGISTRATION FORM'S POST ----------
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['register_submit'])) {
    header("Location: $HOME_PAGE");
    exit;
}

$errors = [];

// ---------- 3. CSRF CHECK ----------
if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    $errors[] = 'Invalid form submission. Please refresh and try again.';
}

// ---------- 4. GATHER + VALIDATE INPUT ----------
$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';
$city     = trim($_POST['city'] ?? '');
$gender   = $_POST['gender'] ?? '';

$allowedRoles   = ['customer', 'provider'];
$allowedCities  = ['Kathmandu', 'Lalitpur', 'Bhaktapur', 'Pokhara', 'Chitwan', 'Biratnagar', 'Butwal', 'Other'];
$allowedGenders = ['Male', 'Female', 'Other'];

if ($name === '' || strlen($name) < 2) {
    $errors[] = 'Please enter your name.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}
if (strlen($password) < 6) {
    $errors[] = 'Password must be at least 6 characters.';
}
if (!in_array($role, $allowedRoles, true)) {
    $errors[] = 'Please select whether you are registering as a Customer or Service Provider.';
}
if (!in_array($city, $allowedCities, true)) {
    $errors[] = 'Please select a valid city.';
}
if (!in_array($gender, $allowedGenders, true)) {
    $errors[] = 'Please select a gender.';
}

// ---------- 5. CHECK FOR EXISTING EMAIL ----------
if (empty($errors)) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = 'That email is already registered.';
    }
}

// ---------- 6. ON ERROR: SEND BACK TO FORM WITH FLASH DATA ----------
if (!empty($errors)) {
    $_SESSION['reg_errors'] = $errors;
    $_SESSION['reg_old'] = [
        'name'  => $name,
        'email' => $email,
        'role'  => $role,
        'city'  => $city,
        'gender' => $gender,
    ];
    header("Location: $HOME_PAGE");
    exit;
}

// ---------- 7. INSERT NEW USER ----------
$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare(
    'INSERT INTO users (name, email, password, role, city, gender, created_at)
     VALUES (?, ?, ?, ?, ?, ?, NOW())'
);
$stmt->execute([$name, $email, $hashed, $role, $city, $gender]);

// Rotate CSRF token after successful submission
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$_SESSION['reg_success'] = true;

header("Location: ");
exit;

/*
 * ---------- SQL TO CREATE THE users TABLE ----------
 *
 * CREATE TABLE users (
 *     id INT AUTO_INCREMENT PRIMARY KEY,
 *     name VARCHAR(100) NOT NULL,
 *     email VARCHAR(100) NOT NULL UNIQUE,
 *     password VARCHAR(255) NOT NULL,
 *     role ENUM('customer','provider') NOT NULL,
 *     city VARCHAR(50) NOT NULL,
 *     gender ENUM('Male','Female','Other') NOT NULL,
 *     created_at DATETIME NOT NULL
 * );
 */
