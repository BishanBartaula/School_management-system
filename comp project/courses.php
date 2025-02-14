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

$message = ""; 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_course'])) {
    $teacher_name = $conn->real_escape_string($_POST["teacher_name"]);
    $course_part = $conn->real_escape_string($_POST["course_part"]);

    $sql = "INSERT INTO courses (teacher_name, course_part) VALUES ('$teacher_name', '$course_part')";
    if ($conn->query($sql) === TRUE) {
        $message = "<p style='color: green;'>Course added successfully!</p>";
    } else {
        $message = "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_course'])) {
    $id = intval($_POST['delete_course']);
    $conn->query("DELETE FROM courses WHERE id=$id");
    echo "success";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_course'])) {
    $id = $_POST['course_id'];
    $teacher_name = $conn->real_escape_string($_POST["teacher_name"]);
    $course_part = $conn->real_escape_string($_POST["course_part"]);
    
    $conn->query("UPDATE courses SET teacher_name='$teacher_name', course_part='$course_part' WHERE id=$id");
    header("Location: manage_courses.php");
    exit();
}
$result = $conn->query("SELECT * FROM courses");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
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
        form {
            margin: 20px auto;
            padding: 20px;
            width: 50%;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        input, button {
            padding: 10px;
            margin: 10px 0;
            width: 90%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #333;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #555;
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
        .message {
            margin: 10px 0;
            font-size: 18px;
        }
    </style>
    <script>
        function deleteCourse(id) {
            if (confirm('Are you sure?')) {
                fetch('', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'delete_course=' + id
                }).then(response => response.text())
                  .then(data => {
                      if (data.trim() === 'success') {
                          document.getElementById('course-row-' + id).remove();
                      } else {
                          alert('Error deleting course.');
                      }
                  });
            }
        }

        function editCourse(id, teacherName, coursePart) {
            document.getElementById('course_id').value = id;
            document.getElementById('teacher_name').value = teacherName;
            document.getElementById('course_part').value = coursePart;
            
            document.querySelector("button[name='add_course']").style.display = 'none';
            document.querySelector("button[name='update_course']").style.display = 'inline-block';
        }
    </script>
</head>
<body>
    <h2>Manage Courses</h2>
    
    <!-- Show Success/Error Message -->
    <div class="message"><?= $message ?></div>

    <form method="post">
        <input type="hidden" name="course_id" id="course_id">
        Teacher Name: <input type="text" name="teacher_name" id="teacher_name" required>
        Course Part: <input type="text" name="course_part" id="course_part" required>
        <button type="submit" name="add_course">Add Course</button>
        <button type="submit" name="update_course" style="display:none;">Update Course</button>
    </form>

    <table>
        <tr><th>Teacher Name</th><th>Course Part</th><th>Actions</th></tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr id="course-row-<?= $row['id'] ?>">
                <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                <td><?= htmlspecialchars($row['course_part']) ?></td>
                <td>
                    <button onclick="deleteCourse(<?= $row['id'] ?>)">Delete</button>
                    <button onclick="editCourse(<?= $row['id'] ?>, '<?= htmlspecialchars($row['teacher_name']) ?>', '<?= htmlspecialchars($row['course_part']) ?>')">Edit</button>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
