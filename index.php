<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sneaker_db';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM sneakers ORDER BY release_date DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Collection</title>
    <link rel="stylesheet" href="styles.css"/>

</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Sneaker Collection</h1>
            <p>Discover the latest and greatest sneakers from top brands</p>
       </header>

       <div class="sneaker-grid">
        <?php
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                $releaseDate = date("F Y", strtotime($row['release_date']));

                $tagClass = ($row['price'] > 200) ? "high-end" : "budget";
                $tagLabel = ($row['price'] > 200) ? "🔥 High-End" : "💸 Budget";


                
              echo '<div class="sneaker-card">';
                echo '  <div class="image-placeholder">';
                echo '    <img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                echo '  </div>';
                echo '  <div class="card-content">';
                echo '    <h2>' . htmlspecialchars($row['title']) . '</h2>';
                echo '    <p class="brand">' . htmlspecialchars($row['brand']) . '</p>';
                echo '    <p class="release-date">Released: ' . $releaseDate . '</p>';
                echo '    <p class="price">$' . number_format($row['price'], 2) . '</p>';
                echo '    <span class="price-tag ' . $tagClass . '">' . $tagLabel . '</span>';
                echo '  </div>';
                echo '</div>';

            }
        }else {
            echo '<p>No sneakers found in the database.</p>';
        }

        $conn->close();
      ?>

       </div>
    </div>
    
    
</body>
</html>
