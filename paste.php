<!DOCTYPE html>
<html>
<head>
    <title>Verbatis Liberta</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <main>
           <header>
        <h1>Verbatis Liberta</h1>
        </header>

        <nav>
            <ul>
                <li><a href="/index.php">home</a></li>
                <li><a href="/about">about</a></li>
                <li><a href="/index.php#post">paste</a></li>
            </ul>
        </nav>
        <?php
        $servername = "localhost";
        $username = "null";
        $password = "null";
        $dbname = "null";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            $stmt = $conn->prepare("SELECT * FROM pastes WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<section class="content">';
                echo "<h2 class='article'>" . htmlspecialchars($row['title']) . "</h2>";
                echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
                echo "<p>Created at: " . htmlspecialchars($row['created_at']) . "</p>";
                echo "</section>";
                echo "<section class='content'>";
                echo "<h2 class='article'>Comments</h2>";

                $stmt = $conn->prepare("SELECT * FROM comments WHERE paste_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $commentsResult = $stmt->get_result();

                if ($commentsResult->num_rows > 0) {
                    while ($commentRow = $commentsResult->fetch_assoc()) {
                        echo "<section class='content'>";
                        echo "<p>" . htmlspecialchars($commentRow['comment']) . "</p>";
                        echo "<p>Commented at: " . htmlspecialchars($commentRow['created_at']) . "</p>";
                        echo "</section>";
                    }
                } else {
                    echo "No comments yet.";
                }
                echo "<section class='content'>";
                echo "<h3>Add a Comment</h3>";
                echo "<form action='add_comment.php' method='post'>";
                echo "<textarea name='comment' placeholder='Enter your comment...' required></textarea><br>";
                echo "<input type='hidden' name='paste_id' value='" . $id . "'>";
                echo "<input type='submit' value='Add Comment'>";
                echo "</form>";
                echo "</section>"; 
            echo "</form>";
            } else {
                echo "Paste not found.";
            }
            
            $stmt->close();
        } else {
            echo "Invalid request.";
        }

        $conn->close();
        ?>
    </main>
    <style> img[src*="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"] { display: none;} </style> 
</body>
</html>
