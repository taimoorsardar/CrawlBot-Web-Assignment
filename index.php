<?php
// Your database credentials
$servername = "localhost";
$username = "root";
$password = "Ts1516232628";
$dbname = "web_assignment_2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Rest of your code...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Crawler</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        input {
            padding: 8px;
            width: 300px;
        }

        button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Web Crawler</h1>

    <!-- Crawling Form -->
    <form action="crawler.php" method="GET">
        <label for="url">Enter URL to Crawl:</label>
        <input type="url" id="url" name="url" required>
        <label for="depth">Enter Depth:</label>
        <input type="text" name="depth" id="depth" required>
        <button type="submit">Crawl</button>
    </form>

    <!-- Search Form -->
    <form action="crawler.php" method="GET">
        <label for="query">Search:</label>
        <input type="text" id="query" name="query" required>
        <button type="submit">Search</button>
    </form>

    <!-- Display Crawled Data -->
    <?php
    // Display crawled data if available
    $sql = "SELECT * FROM crawler_data";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Crawled Data:</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<strong>URL:</strong> " . $row['url'] . "<br>";
            echo "<strong>Title:</strong> " . $row['title'] . "<br>";
            echo "<strong>Description:</strong> " . $row['description'] . "<br>";
            echo "<strong>Keywords:</strong> " . $row['keywords'] . "<br>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "No crawled data available";
    }
    ?>
</body>
</html>
