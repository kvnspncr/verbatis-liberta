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
        <section class="content">
            <h2>New Pastes</h2>
                    <main>
        <form action="" method="post">
            <input type="text" name="search" placeholder="Search paste by title" value="">
            <input type="submit" value="Search">
        </form>
        <?php
        $servername = "localhost";
        $username = "null";
        $password = "null";
        $dbname = "null";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['search'])) {
                $search = $_POST['search'];
                $stmt = $conn->prepare("SELECT * FROM pastes WHERE title LIKE ?");
                $param = "%" . $search . "%";
                $stmt->bind_param("s", $param);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<section class='content'>";
                    echo "<p>Search Results:<p>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<li><a href='paste.php?id={$row['id']}'>{$row['title']}</a></li>";
                    }
                    echo "</section>";
                } else {
                    echo "No results found.";
                }

                $stmt->close();
                $conn->close();
            }
        }
        ?>
    
            <?php include 'get_pastes.php'; ?>
        </section>

        <section id="post" class="content">
            <h2>Create New Paste</h2>
            <form action="add_paste.php" method="post">
                <input type="text" name="title" placeholder="Enter paste title" required><br>
                <textarea name="content" placeholder="Enter your paste here..." required></textarea>
                <label for="captcha">Enter the code shown below:</label><br>
                <img src="verify_captcha.php" alt="CAPTCHA"><br>
                <input type="text" id="captcha" name="captcha" placeholder="Enter CAPTCHA" required><br>
                <input type="submit" value="Create Paste">
                 <?php if (isset($_GET['error']) && $_GET['error'] === 'captcha') {
                    echo '<p style="color: blue;">CAPTCHA verification failed or not provided. Please complete the CAPTCHA.</p>';
                } ?>
            </form>
        </section>
</body>
</main>
</html>
