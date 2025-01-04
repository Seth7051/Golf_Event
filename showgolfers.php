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
        $servername = "mc-itddb-12-e-1";
        $username = "srniefield";
        $password = "0726607";
        $dbname = "01WAPP1400NiefieldS";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "
            SELECT 
                G.GolferID, 
                G.FirstName, 
                G.LastName, 
                G.Address, 
                G.City, 
                G.StateID, 
                G.ZipCode, 
                G.PhoneNumber, 
                G.Email, 
                G.ShirtSizeID, 
                G.GenderID 
            FROM Golfers AS G 
            JOIN EventGolfers AS EG ON G.GolferID = EG.GolferID 
            WHERE EG.EventID = 6
        ";

        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Golfer ID</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Address</th>";
            echo "<th>City</th>";
            echo "<th>State</th>";
            echo "<th>Zip Code</th>";
            echo "<th>Phone</th>";
            echo "<th>Email</th>";
            echo "<th>Shirt Size</th>";
            echo "<th>Gender</th>";
            echo "<th>Actions</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='Update_Golfer.php?GolferID=" . $row['GolferID'] . "'>" . $row['GolferID'] . "</a></td>";
                echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Address']) . "</td>";
                echo "<td>" . htmlspecialchars($row['City']) . "</td>";
                echo "<td>" . htmlspecialchars($row['StateID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ZipCode']) . "</td>";
                echo "<td>" . htmlspecialchars($row['PhoneNumber']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ShirtSizeID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['GenderID']) . "</td>";
                echo "<td><a href='DonateNow.php?GolferID=" . $row['GolferID'] . "'>Donate Now</a></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No golfers found.</p>";
        }

        $conn->close();
        ?>

        <p><a href="Assignment13_SN.php">Home</a></p>
    </div>
</body>

</html>


