<?php 
include 'includes/db.php';

$sql = "SELECT image_url, caption FROM gallery";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Gen Z Bakery</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>Gen Z Bakery</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="vision.php">Vision & Mission</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h2>Gallery</h2>
        <div class="gallery">
            <?php 
            // Cek apakah ada gambar di database
            if ($result->num_rows > 0) {
                // Loop untuk menampilkan gambar-gambar dari database
                while($row = $result->fetch_assoc()) {
                    echo '<div class="gallery-item">';
                    echo '<img src="' . $row["image_url"] . '" alt="Gallery Image">';
                    echo '<figcaption>' . $row["caption"] . '</figcaption>';
                    echo '</div>';
                }
            } else {
                echo "<p>No images found.</p>";
         }
            ?>
    </div>
</main>


    <footer>
        <p>Contact: 0895342849355 | Email: genZbakery@gmail.com | IG: @GenZ_bakery</p>
    </footer>
</body>

</html>
