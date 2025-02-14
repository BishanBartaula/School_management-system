<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "school_management";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $message = $_POST["message"];
    $sql = "INSERT INTO announcements (message) VALUES ('$message')";
    $conn->query($sql);
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM announcements WHERE id=$id");
    header("Location: announcements.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $message = $_POST["message"];
    $conn->query("UPDATE announcements SET message='$message' WHERE id=$id");
    header("Location: announcements.php");
    exit();
}

$result = $conn->query("SELECT * FROM announcements ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Announcements</title>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { text-align: center; margin: 20px; background: #f4f4f4; }
        form, .announcement-box { width: 50%; margin: 20px auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 5px #ccc; }
        textarea, button { width: 90%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #333; color: white; cursor: pointer; transition: 0.3s; }
        button:hover { background: #555; }
        .delete-btn { background: red; }
        .edit-btn { background: blue; }
    </style>
</head>
<body>
    <h2>Post Announcement</h2>
    <form method="post">
        <textarea name="message" required></textarea>
        <button type="submit" name="add">Post</button>
    </form>
    <h2>All Announcements</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class='announcement-box'>
            <p><?php echo $row['message']; ?></p>
            <a href="?delete=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
            <button onclick="editAnnouncement(<?php echo $row['id']; ?>, '<?php echo addslashes($row['message']); ?>')" class="edit-btn">Edit</button>
        </div>
    <?php endwhile; ?>

    <div id="editForm" style="display: none;">
        <h2>Edit Announcement</h2>
        <form method="post">
            <input type="hidden" name="id" id="editId">
            <textarea name="message" id="editMessage" required></textarea>
            <button type="submit" name="update">Update</button>
        </form>
    </div>

    <script>
        function editAnnouncement(id, message) {
            document.getElementById('editId').value = id;
            document.getElementById('editMessage').value = message;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
</body>
</html>
