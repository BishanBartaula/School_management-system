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
    <title>Student Grades</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #f4f4f4;
            text-align: center;
            margin: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background: #333;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Grades</h2>
    <table>
        <tr>
            <th>Roll No</th>
            <th>Name</th>
            <th>Marks Obtained</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM grades");
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['roll_no']}</td><td>{$row['name']}</td><td>{$row['marks_obtained']}</td></tr>";
        }
        ?>
    </table>
</body>
</html>
