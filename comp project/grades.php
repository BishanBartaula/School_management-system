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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])){ 
    $roll_no = $_POST["roll_no"];
    $name = $_POST["name"];
    $marks = $_POST["marks"];
    $sql = "INSERT INTO grades (roll_no, name, marks_obtained) VALUES ('$roll_no', '$name', '$marks')";
    $conn->query($sql);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM grades WHERE id=$id");
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $roll_no = $_POST["roll_no"];
    $name = $_POST["name"];
    $marks = $_POST["marks"];
    $conn->query("UPDATE grades SET roll_no='$roll_no', name='$name', marks_obtained='$marks' WHERE id=$id");
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}

$result = $conn->query("SELECT * FROM grades");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Grades</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; }
        form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; }
        input, button { margin: 10px; padding: 8px; font-size: 16px; }
        table { width: 60%; margin: 20px auto; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #333; color: white; }
    </style>
</head>
<body>
<h2>Manage Grades</h2>

<form method="post">
    <input type="hidden" name="id" id="id">
    Roll No: <input type="text" name="roll_no" id="roll_no" required>
    Name: <input type="text" name="name" id="name" required>
    Marks: <input type="number" name="marks" id="marks" required>
    <button type="submit" name="add" id="addBtn">Add Grade</button>
    <button type="submit" name="update" id="updateBtn" style="display:none;">Update Grade</button>
</form>

<table>
    <tr><th>Roll No</th><th>Name</th><th>Marks</th><th>Actions</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['roll_no'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['marks_obtained'] ?></td>
            <td>
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                <button onclick="editGrade(<?= $row['id'] ?>, '<?= $row['roll_no'] ?>', '<?= $row['name'] ?>', <?= $row['marks_obtained'] ?>)">Edit</button>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<script>
    function editGrade(id, roll_no, name, marks) {
        document.getElementById('id').value = id;
        document.getElementById('roll_no').value = roll_no;
        document.getElementById('name').value = name;
        document.getElementById('marks').value = marks;
        document.getElementById('addBtn').style.display = 'none';
        document.getElementById('updateBtn').style.display = 'inline';
    }
</script>
</body>
</html>
