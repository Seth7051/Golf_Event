<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Golfer Statistics</title>
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
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        h1 {
            color: #4CAF50;
            text-align: center;
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

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .stats {
            margin-bottom: 2em;
            font-size: 1.2em;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <h1>Golfer Statistics</h1>

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

        // Total number of donations
        $totalDonationsQuery = "SELECT COUNT(*) AS TotalDonations FROM Donations";
        $result = $conn->query($totalDonationsQuery);
        $totalDonations = ($result && $row = $result->fetch_assoc()) ? $row['TotalDonations'] : 0;

        // Average donation amount
        $averageDonation = ($totalDonations > 0) ? $totalPledged / $totalDonations : 0;

        echo "<div class='stats'>";
        echo "<p><strong>Total Pledged:</strong> $" . number_format($totalPledged, 2) . "</p>";
        echo "<p><strong>Total Number of Donations:</strong> " . $totalDonations . "</p>";
        echo "<p><strong>Average Donation Amount:</strong> $" . number_format($averageDonation, 2) . "</p>";
        echo "</div>";

        // Golfer statistics with total pledges
        $golferStatsQuery = "
            SELECT 
                G.GolferID, 
                G.FirstName, 
                G.LastName, 
                IFNULL(SUM(D.AmountPledged), 0) AS TotalPledged
            FROM Golfers as G
            LEFT JOIN Donations as D ON G.GolferID = D.GolferID
            GROUP BY G.GolferID
            ORDER BY TotalPledged DESC
        ";

        $result = $conn->query($golferStatsQuery);

        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Golfer Name</th>";
            echo "<th>Total Pledged</th>";
            echo "<th>Donors</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['LastName']) . "</td>";
                echo "<td>$" . number_format($row['TotalPledged'], 2) . "</td>";
                echo "<td><a href='ViewDonors.php?GolferID=" . $row['GolferID'] . "'>View Donors</a></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No golfers found.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>

</html>
