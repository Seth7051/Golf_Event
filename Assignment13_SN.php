<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 13</title>

    <!--
    Name: Seth Niefield
    Class: IT-117-400
    Abstract: Homework #13
    Date: 12/02/24
    -->

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 1em;
            font-size: 1.2em;
            text-transform: uppercase;
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
            font-size: 2em;
            margin-bottom: 1em;
        }

        p {
            font-size: 1.1em;
            margin: 1em 0;
        }

        a {
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            padding: 0.7em 1.5em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            display: inline-block;
            font-weight: bold;
        }

        a:hover {
            background-color: #45a049;
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

        footer {
            margin-top: 2em;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>

    <header>
        Seth Niefield - Golf Event
    </header>

    <div class="container">
        <h1>Golf Event</h1>

        <p><a href="Add_Golfer.php">Register Golfer</a></p>
        <p><a href="showgolfers.php">View Golfers</a></p>
        <p><a href="DonateNow.php">Donate Now</a></p>
        <p><a href="GolferStatistics.php">Golfer Statistics</a></p>
        <p><a href="Administration.php">Administration Login</a></p>
    </div>

    <div class="container">
        <?php
        // Database connection
        $servername = "mc-itddb-12-e-1";
        $username = "srniefield";
        $password = "0726607";
        $dbname = "01WAPP1400NiefieldS";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Total amount pledged
        $totalPledgesQuery = "SELECT SUM(AmountPledged) AS TotalPledged FROM Donations";
        $result = $conn->query($totalPledgesQuery);
        $totalPledged = ($result && $row = $result->fetch_assoc()) ? $row['TotalPledged'] : 0;

        echo "<div class='stats'>";
        echo "<p><strong>Total Pledged:</strong> $" . number_format($totalPledged, 2) . "</p>";
        echo "</div>";

        // Golfer statistics with total pledges
        $golferStatsQuery = "
            SELECT 
                G.GolferID, 
                G.FirstName, 
                G.LastName, 
                IFNULL(SUM(D.AmountPledged), 0) AS TotalPledged
            FROM Golfers AS G
            LEFT JOIN Donations AS D ON G.GolferID = D.GolferID
            GROUP BY G.GolferID
            ORDER BY TotalPledged DESC
        ";

        $result = $conn->query($golferStatsQuery);

        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Golfer Name</th>";
            echo "<th>Total Pledged</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['LastName']) . "</td>";
                echo "<td>$" . number_format($row['TotalPledged'], 2) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No golfers found.</p>";
        }

        // Query to get the count of active golfers
        $GolfersQuery = "SELECT COUNT(GolferID) AS ActiveGolfers FROM EventGolfers WHERE EventID = 7";
        $result = $conn->query($GolfersQuery);

        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Active Golfers</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ActiveGolfers'] . "</td>";
                echo "</tr>";
            }

            echo "</table>"; // Add missing table closing tag
        } else {
            echo "<p>No active golfers found for this event.</p>";
        }

        $conn->close();
        ?>
    </div>

</body>

</html>
