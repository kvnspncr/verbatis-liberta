<?php
$servername = "null";
$username = "null";
$password = "null";
$dbname = "null";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM pastes ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='paste'>";
        echo "<h3><a href='paste.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></h3>";
        echo "<p>Created at: " . htmlspecialchars($row['created_at']) . "</p>";
        echo "</div>";
    }
} else {
    echo "No pastes available.";
}

$stmt->close();
$conn->close();
?>
