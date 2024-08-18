<?php
session_start();

$host = 'localhost';
$db = 'gymnsb';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the data from the form
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Hash the password using MD5
    $hashed_password = md5($password);

    // Prepare the SQL statement to insert the data
    $stmt = $pdo->prepare('INSERT INTO admin (username, password, name) VALUES (?, ?, ?)');

    try {
        // Execute the statement
        $stmt->execute([$username, $hashed_password, $name]);

        // Redirect to the login page after successful registration
        header('Location: ../login.php');
        exit();
    } catch (PDOException $e) {
        // Handle any errors
        echo 'Error: ' . $e->getMessage();
    }
}
?>
 