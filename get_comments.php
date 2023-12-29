<?php
    $servername = "null";
    $username = "null";
    $password = "null";
    $dbname = "null";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $paste_id = $_GET['id'];
    
    $sql = "SELECT * FROM comments WHERE paste_id = $paste_id ORDER BY id DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<p>" . htmlspecialchars($row['comment']) . "</p>";
            echo "<p>Created at: " . $row['created_at'] . "</p>"; 
            echo "</div>";
        }
    } else {
        echo "No comments yet.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>