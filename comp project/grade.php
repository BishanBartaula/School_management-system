<?php
session_start();
$searvername = "localhost";
$username = "root";
$password = "";
$database = "school_management";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST["roll_no"];
    $name = $_POST["name"];
    $marks = $_POST["marks"];
    $sql = "INSERT INTO grades (roll_no, name, marks_obtained) VALUES ('$roll_no', '$name', '$marks')";
    $conn->query($sql);
}
$result = $conn->query("SELECT * FROM grades");
?>
<!DOCTYPE html>
<html>
<head><title>Manage Grades</title></head>
<body>
<h2>Manage Grades</h2>
<form method="post">
    Roll No: <input type="text" name="roll_no" required>
    Name: <input type="text" name="name" required>
    Marks: <input type="number" name="marks" required>
    <button type="submit">Add Grade</button>
</form>
<table border="1">
    <tr><th>Roll No</th><th>Name</th><th>Marks</th></tr>
    <?php while ($row = $result->fetch_assoc()) echo "<tr><td>{$row['roll_no']}</td><td>{$row['name']}</td><td>{$row['marks_obtained']}</td></tr>"; ?>
</table>
</body>
</html>
