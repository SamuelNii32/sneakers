<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sneakers_db'; 

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT s.Brand, s.Model, s.Size, s.Width, s.`Good/bad` AS Quality,
               sl.sale_price, sl.sale_date
        FROM Sneakers s
        LEFT JOIN Sales sl ON s.sneaker_id = sl.sneaker_id
        ORDER BY sl.sale_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sneaker Sales Dashboard</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Sneaker Sales Dashboard</h1>
      <p>Track and manage your sneaker inventory and sales</p>
    </div>

    <div class="sneaker-grid">
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <div class="sneaker-card">
            <div class="sneaker-image">
              <img src="/placeholder.svg?height=200&width=300" alt="<?= htmlspecialchars($row['Brand'] . ' ' . $row['Model']) ?>">
            </div>
            <div class="sneaker-details">
              <h3><?= htmlspecialchars($row['Brand'] . ' ' . $row['Model']) ?></h3>
              <div class="size-info">
                <span>Size: <?= htmlspecialchars($row['Size']) ?></span>
                <span>•</span>
                <span>Width: <?= htmlspecialchars($row['Width']) ?></span>
              </div>
              <div class="quality-section">
                <span class="quality-badge quality-<?= strtolower($row['Quality']) ?>">
                  <?= htmlspecialchars($row['Quality']) ?>
                </span>
              </div>
            </div>
            <div class="sale-info">
              <div class="price-section">
                <span class="price">$<?= number_format($row['sale_price'], 2) ?></span>
              </div>
              <div class="date-section">
                <span class="date">📅 Sold on <?= date("M d, Y", strtotime($row['sale_date'])) ?></span>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No sneakers found.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>

<?php $conn->close(); ?>
