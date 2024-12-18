<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "company_profile";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$users = $conn->query("SELECT * FROM users");
$contacts = $conn->query("SELECT * FROM contacts");
$gallery = $conn->query("SELECT * FROM gallery");

// Update Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $update_sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $username, $password, $id);
    if ($stmt->execute()) {
        echo "User updated successfully.";
        header("Refresh:0");
    } else {
        echo "Error: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_contact'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $update_sql = "UPDATE contacts SET name = ?, email = ?, message = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssi", $name, $email, $message, $id);
    if ($stmt->execute()) {
        echo "Contact updated successfully.";
        header("Refresh:0");
    } else {
        echo "Error: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_gallery'])) {
    $id = $_POST['id'];
    $image_url = $_POST['image_url'];
    $caption = $_POST['caption'];

    $update_sql = "UPDATE gallery SET image_url = ?, caption = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $image_url, $caption, $id);
    if ($stmt->execute()) {
        echo "Gallery updated successfully.";
        header("Refresh:0");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <a href="logout.php">Logout</a>

    <h2>Users</h2>
    <table border="1">
        <tr><th>ID</th><th>Username</th><th>Edit</th></tr>
        <?php while ($row = $users->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
                        <input type="password" name="password" placeholder="New Password" required>
                        <button type="submit" name="update_user">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h2>Contacts</h2>
    <table border="1">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Edit</th></tr>
        <?php while ($row = $contacts->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
                        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
                        <textarea name="message" required><?php echo $row['message']; ?></textarea>
                        <button type="submit" name="update_contact">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h2>Gallery</h2>
    <table border="1">
        <tr><th>ID</th><th>Image URL</th><th>caption</th><th>Edit</th></tr>
        <?php while ($row = $gallery->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['image_url']; ?></td>
                <td><?php echo $row['caption']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="image_url" value="<?php echo $row['image_url']; ?>" required>
                        <input type="text" name="caption" value="<?php echo $row['caption']; ?>" required>
                        <button type="submit" name="update_gallery">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
