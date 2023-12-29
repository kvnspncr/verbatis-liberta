<?php
session_start();

$servername = "null";
$username = "null";
$password = "null";
$dbname = "null";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['captcha']) && $_POST['captcha'] === $_SESSION['captcha_code']) {
        
        $title = $_POST['title'];
        $content = $_POST['content'];
        
        $stmt = $conn->prepare("INSERT INTO pastes (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        $stmt->close();
        
        header("Location: index.php");
        exit();
    } else {
        header("Location: index.php?error=captcha");
    }
}

$conn->close();
?>
