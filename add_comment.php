<?php
    $servername = "null";
    $username = "null";
    $password = "null";
    $dbname = "null";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST['comment'];
    $paste_id = $_POST['paste_id'];
    
    $stmt = $conn->prepare("INSERT INTO comments (comment, paste_id) VALUES (?, ?)");
    $stmt->bind_param("si", $comment, $paste_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: paste.php?id=$paste_id");
?>