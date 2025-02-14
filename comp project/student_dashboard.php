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
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: project.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #FFDEE9, #B5FFFC);
            color: #333;
        }
        .navbar {
            background: #333;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #FF6A88;
        }
        .content {
            text-align: center;
            margin-top: 50px;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="student_dashboard.php">Home</a>
            <a href="grades_student.php">Grades</a>
            <a href="courses_student.php">Courses</a>
            <a href="attendance_student.php">Attendance</a>
            <a href="announcements_student.php">Announcements</a>
        </div>
        <div>
             <a href="student_dashboard.php?logout=true" class="logout-btn" style="color: white; text-decoration: none; background: linear-gradient(135deg, #FF6A88, #FF8C6F); padding: 8px 12px; border-radius: 5px;">Logout</a>
        </div>
    </div>
    <div class="content">
        Welcome to the Student Dashboard.
    </div>
</body>
</html>
