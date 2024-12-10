<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Online</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0e0e0; /* Light gray background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.8); /* Transparent bubble style */
            padding: 30px;
            border-radius: 50%; /* Circular bubble */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 250px; /* Smaller width */
        }

        h1 {
            margin-bottom: 20px;
            font-size: 20px; /* Reduced font size */
            font-weight: bold;
            color: black; /* Black title for contrast */
        }

        p {
            font-size: 12px; /* Reduced font size */
            color: black;
        }

        a {
            display: inline-block; /* Inline buttons */
            margin: 10px 5px;
            padding: 8px 15px; /* Smaller button padding */
            background-color: black;
            color: white;
            text-decoration: none;
            border-radius: 20px; /* Rounded bubble buttons */
            font-size: 14px; /* Reduced font size */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: white;
            color: black;
            border: 1px solid black;
        }

        /* Add animation for bubbles */
        @keyframes floating {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .container {
            animation: floating 4s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Courses Online</h1>
        <p>Select an option to proceed:</p>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </div>
</body>
</html>
