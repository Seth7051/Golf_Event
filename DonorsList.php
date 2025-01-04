<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donors List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            margin: 2em auto;
            padding: 2em;
            background: #fff;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
        }

        th, td {
            padding: 0.7em;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Donors List</h1>

    <div class="container">
        <?php 
$servername = "mc-itddb-12-e-1";
$username = "srniefield";
$password = "0726607";
$dbname = "01WAPP1400NiefieldS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get GolferID from URL
$golferID = isset($_GET['GolferID']) ? intval($_GET['GolferID']) : 0;

// Fetch golfer name
$golferQuery = "SELECT FirstName, LastName FROM Golfers WHERE GolferID = $golferID";
$golferResult = $conn->query($golferQuery);

if ($golferResult && $golferResult->num_rows > 0) {
    $golfer = $golferResult->fetch_assoc();
    $firstName = htmlspecialchars($golfer['FirstName']);
    $lastName = htmlspecialchars($golfer['LastName']);

    echo "<h2>Donors for $firstName $lastName</h2>";
} else {
    die("<p>Golfer not found.</p>");
}

// Fetch donors for the golfer
$donorsQuery = "SELECT FirstName, LastName, AmountPledged FROM Donations WHERE GolferID = $golferID";
$donorsResult = $conn->query($donorsQuery);

if ($donorsResult && $donorsResult->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>First Name</th><th>Last Name</th><th>Donation Amount</th></tr>";

    while ($row = $donorsResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
        echo "<td>$" . number_format($row['AmountPledged'], 2) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No donors found for this golfer.</p>";
}

// Close connection
$conn->close();
?>

    </div>
</body>

</html>
