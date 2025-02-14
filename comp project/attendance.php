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
    $student_name = $_POST["student_name"];
    $date = $_POST["date"];
    $status = $_POST["status"];
    $sql = "INSERT INTO attendance (student_name, date, status) VALUES ('$student_name', '$date', '$status')";
    $conn->query($sql);
}


if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM attendance WHERE id=$id");
    header("Location: attendance.php"); // Refresh the page
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $student_name = $_POST["student_name"];
    $date = $_POST["date"];
    $status = $_POST["status"];
    $conn->query("UPDATE attendance SET student_name='$student_name', date='$date', status='$status' WHERE id=$id");
    header("Location: attendance.php"); // Refresh the page
    exit();
}

$result = $conn->query("SELECT * FROM attendance");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Attendance</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; text-align: center; margin: 20px; }
        form { margin: 20px auto; padding: 20px; width: 50%; background: #fff; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); border-radius: 5px; }
        input, select, button { padding: 10px; margin: 10px 0; width: 90%; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #333; color: white; cursor: pointer; transition: 0.3s; }
        button:hover { background: #555; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; background: #fff; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background: #333; color: white; }
        .action-btn { padding: 5px 10px; border: none; cursor: pointer; text-decoration: none; margin: 2px; border-radius: 3px; }
        .edit { background: #ff9800; color: white; }
        .delete { background: #e74c3c; color: white; }
    </style>
</head>
<body>
    <h2>Manage Attendance</h2>
    
    <form method="post">
        <input type="text" name="student_name" placeholder="Student Name" required>
        <input type="date" name="date" required>
        <select name="status">
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>
        <button type="submit" name="add">Add Attendance</button>
    </form>

    <?php if (isset($_GET["edit"])): 
        $id = $_GET["edit"];
        $record = $conn->query("SELECT * FROM attendance WHERE id=$id")->fetch_assoc();
    ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= $record['id'] ?>">
        <input type="text" name="student_name" value="<?= $record['student_name'] ?>" required>
        <input type="date" name="date" value="<?= $record['date'] ?>" required>
        <select name="status">
            <option value="Present" <?= $record['status'] == "Present" ? "selected" : "" ?>>Present</option>
            <option value="Absent" <?= $record['status'] == "Absent" ? "selected" : "" ?>>Absent</option>
        </select>
        <button type="submit" name="update">Update Attendance</button>
    </form>
    <?php endif; ?>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['student_name'] ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="attendance.php?edit=<?= $row['id'] ?>" class="action-btn edit">Edit</a>
                <a href="attendance.php?delete=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
