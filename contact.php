<?php
include 'includes/db.php';

// Initialize status message
$status = "";

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Simple validation
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Insert data into the database
        $stmt = $conn->prepare('INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $name, $email, $message);

        // Check if insertion is successful
        if ($stmt->execute()) {
            $status = "Your message has been sent successfully!";
        } else {
            $status = "Failed to send your message. Please try again.";
        }
    } else {
        $status = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Gen Z Bakery</title>
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
        <h2>We'd Love to Hear from You!</h2>
        <p>Please fill out the form below to get in touch with us.</p>

        <form method="POST" action="">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="message">Pesan:</label>
            <textarea id="message" name="message" required></textarea><br>

            <button type="submit">Kirim</button>
        </form>

        <?php if (!empty($status)): ?>
            <p class="status"><?php echo $status; ?></p>
        <?php endif; ?>
    </main>

    <footer>
        <p>Contact: 0895342849355 | Email: genZbakery@gmail.com | IG: @GenZ_bakery</p>
    </footer>

</body>

</html>
