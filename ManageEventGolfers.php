<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['adminID'])) {
    header("Location: AdminLogin.php");
    exit();
}

$servername = "mc-itddb-12-e-1";
$username = "srniefield";
$password = "0726607";
$dbname = "01WAPP1400NiefieldS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Event Golfers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
            max-width: 900px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
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

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .event-selection {
            margin-bottom: 20px;
        }

        .totals {
            font-size: 1.2em;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Manage Event Golfers</h1>

        <form method="GET" class="event-selection">
            <label for="eventID">Select Event:</label>
            <select name="eventID" id="eventID" required>
                <option value="">-- Select Event --</option>
                <?php
                // Fetch events from the database
                $eventQuery = "SELECT EventID, EventYear FROM Events ORDER BY EventYear DESC";
                $eventResult = $conn->query($eventQuery);

                if ($eventResult && $eventResult->num_rows > 0) {
                    while ($event = $eventResult->fetch_assoc()) {
                        $selected = (isset($_GET['eventID']) && $_GET['eventID'] == $event['EventID']) ? 'selected' : '';
                        echo "<option value='" . $event['EventID'] . "' $selected>" . $event['EventYear'] . "</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" value="View Golfers">
        </form>

        <?php
        if (isset($_GET['eventID'])) {
            $eventID = $_GET['eventID'];

            // Fetch golfers and their donation data for the selected event
            $golferQuery = "
                SELECT g.GolferID, g.FirstName, g.LastName, IFNULL(SUM(d.AmountPledged), 0) AS TotalPledged, 
					IFNULL(SUM(CASE WHEN d.PaymentStatusID = 1 THEN d.AmountPledged ELSE 0 END), 0) AS TotalCollected 
				FROM Golfers as g 
				LEFT JOIN Donations as d ON g.GolferID = d.GolferID 
				WHERE d.EventID = $eventID
				GROUP BY g.GolferID
            ";

            $golferResult = $conn->query($golferQuery);

            if ($golferResult && $golferResult->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>Golfer Name</th>
                        <th>Total Pledged</th>
                        <th>Total Collected</th>
                        <th>Donors</th>
                    </tr>";

                $eventTotalPledged = 0;
                $eventTotalCollected = 0;

                while ($row = $golferResult->fetch_assoc()) {
                    $golferID = $row['GolferID'];
                    $golferName = htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']);
                    $totalPledged = number_format($row['TotalPledged'], 2);
                    $totalCollected = number_format($row['TotalCollected'], 2);

                    $eventTotalPledged += $row['TotalPledged'];
                    $eventTotalCollected += $row['TotalCollected'];

                    echo "<tr>
                            <td>$golferName</td>
                            <td>$$totalPledged</td>
                            <td>$$totalCollected</td>
                            <td><a href='ViewDonors.php?GolferID=$golferID&eventID=$eventID'>View Donors</a></td>
                        </tr>";
                }

                echo "</table>";

                echo "<div class='totals'>
                        <p><strong>Event Total Pledged:</strong> $" . number_format($eventTotalPledged, 2) . "</p>
                        <p><strong>Event Total Collected:</strong> $" . number_format($eventTotalCollected, 2) . "</p>
                    </div>";
            } else {
                echo "<p>No golfers found for this event.</p>";
            }
        }

        $conn->close();
        ?>
		<a href="Assignment13_SN.php">Home</a>
    </div>
</body>

</html>
