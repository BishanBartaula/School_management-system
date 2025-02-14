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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Announcements</title>
    <style>
        body { font-family: 'Poppins', sans-serif; text-align: center; background: #f4f4f4; }
        .announcement-box { width: 80%; margin: 20px auto; padding: 15px; background: white; border-radius: 5px; box-shadow: 0px 0px 5px #ccc; }
        h2 { color: #333; }
    </style>
</head>
<body>
    <h2>Announcements</h2>
    <?php
    $result = $conn->query("SELECT * FROM announcements");
    while ($row = $result->fetch_assoc()) {
        echo "<div class='announcement-box'><p>{$row['message']}</p></div>";
    }
    ?>
</body>
</html>