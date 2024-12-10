<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection
include('connection.php');

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['enroll']) && isset($_POST['class_id'])) {
        $class_id = (int)$_POST['class_id'];
        $sql = "INSERT INTO enrollments (user_id, class_id) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ii", $user_id, $class_id);
            if ($stmt->execute()) {
                $message = "You have successfully enrolled in the class.";
            } else {
                $message = "Error enrolling: " . $stmt->error;
            }
            $stmt->close();
        }
    } elseif (isset($_POST['drop']) && isset($_POST['class_id'])) {
        $class_id = (int)$_POST['class_id'];
        $sql = "DELETE FROM enrollments WHERE user_id = ? AND class_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ii", $user_id, $class_id);
            if ($stmt->execute()) {
                $message = "You have successfully dropped the class.";
            } else {
                $message = "Error dropping: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Fetch all available classes
$sql = "SELECT * FROM classes";
$result = $conn->query($sql);
$classes = [];
while ($row = $result->fetch_assoc()) {
    $classes[] = $row;
}

// Fetch enrolled classes
$sql = "SELECT classes.class_name, classes.id FROM enrollments JOIN classes ON enrollments.class_id = classes.id WHERE enrollments.user_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $enrolled_classes = [];
    while ($row = $result->fetch_assoc()) {
        $enrolled_classes[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #121212;
            color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 900px;
            margin: 50px auto;
            background: #1e1e1e;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
        }
        .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background-color: #2e7d32;
            color: #fff;
        }
        .error {
            background-color: #d32f2f;
            color: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #444;
        }
        table th {
            background: #333;
        }
        table td {
            background: #2a2a2a;
        }
        form {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
        }
        select, button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #333;
            color: #f5f5f5;
        }
        button {
            background: #4caf50;
            cursor: pointer;
        }
        button:hover {
            background: #43a047;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Profile</h2>

        <?php if (isset($message)): ?>
            <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <h3>Enrolled Classes</h3>
        <table>
            <thead>
                <tr>
                    <th>Class Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrolled_classes as $class): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Available Classes</h3>
        <form method="POST">
            <select name="class_id" required>
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo htmlspecialchars($class['class_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="enroll">Enroll</button>
        </form>

        <h3>Drop a Class</h3>
        <form method="POST">
            <select name="class_id" required>
                <?php foreach ($enrolled_classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo htmlspecialchars($class['class_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="drop">Drop</button>
        </form>
    </div>
</body>
</html>
