<?php
session_start();
if (!isset($_SESSION['adminID'])) {
    header("Location: AdminLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }

        h1 {
            color: #4CAF50;
        }

        nav a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        nav a:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['adminName']); ?>!</h1>
        <nav>
            <a href="AddEvent.php">Add an Event</a>
            <a href="ManageEventGolfers.php">Manage Event Golfers</a>
            <a href="Assignment13_SN.php">Logout</a>
        </nav>
    </div>
</body>

</html>