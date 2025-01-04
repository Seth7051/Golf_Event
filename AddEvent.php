<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['adminID'])) {
    header("Location: AdminLogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "mc-itddb-12-e-1";
    $username = "srniefield";
    $password = "0726607";
    $dbname = "01WAPP1400NiefieldS";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $year = $_POST['year'];

    // Get the next EventID
    $maxPKQuery = "SELECT MAX(EventID) + 1 AS NextEventID FROM Events";
    $result = $conn->query($maxPKQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $nextEventID = $row['NextEventID'] ?? 1; // Default to 1 if NULL
    } else {
        die("Error fetching next EventID: " . $conn->error);
    }

    // Insert the new event
    $insert = "INSERT INTO Events (EventID, EventYear) VALUES ($nextEventID, $year)";

    if ($conn->query($insert)) {
        echo "<p style='color: green;'>Event for year $year added successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            font-size: 1.2em;
        }
    </style>
</head>

<body>
    <h2>Add a New Event</h2>
    <form method="POST">
        <label for="year">Year:</label>
        <input type="number" id="year" name="year" required>
        <br><br>
        <input type="submit" value="Add Event">
    </form>
</body>

</html>
