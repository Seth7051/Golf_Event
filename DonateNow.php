<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Donation</title>
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
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        h1 {
            color: #4CAF50;
            text-align: center;
        }

        label {
            display: block;
            margin: 0.5em 0 0.2em;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        select {
            width: 100%;
            padding: 0.5em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .button-container input[type="submit"],
        .button-container input[type="reset"],
        .button-container a {
            background-color: #4CAF50;
            color: white;
            padding: 0.7em 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
            text-align: center;
            flex: 1;
        }

        .button-container input[type="reset"] {
            background-color: #f44336;
        }

        .button-container input[type="submit"]:hover,
        .button-container input[type="reset"]:hover,
        .button-container a:hover {
            background-color: #45a049;
        }

        .button-container input[type="reset"]:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
    <h1>Make a Donation</h1>

    <div class="container">
        <form action="ProcessDonation.php" method="POST">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>
			
			<label for="address">Street Address:</label>
            <input type="text" id="address" name="address" required>
			
			<label for="city">City:</label>
            <input type="text" id="city" name="city" required>
			
			<label for="state">Select State:</label>
            <select id="state" name="state" required>
                <option value="">-- Select a Golfer --</option>
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

                $sql = "SELECT * FROM States";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['StateID'] . "'>" . htmlspecialchars($row['State']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No States found</option>";
                }

                $conn->close();
                ?>
            </select>

			<label for="zip">Zip Code:</label>
            <input type="text" id="zip" name="zip" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="golfer">Select Golfer:</label>
            <select id="golfer" name="golfer" required>
                <option value="">-- Select a Golfer --</option>
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

                $sql = "SELECT GolferID, CONCAT(FirstName, ' ', LastName) AS GolferName FROM Golfers";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['GolferID'] . "'>" . htmlspecialchars($row['GolferName']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No golfers found</option>";
                }

                $conn->close();
                ?>
            </select>
			
			<label for="EventID">Select Event:</label>
			<select name="EventID" id="EventID" required>
                <option value="">-- Select Event --</option>
                <?php
				error_reporting(E_ALL);
				ini_set('display_errors', 1);
				
				$servername = "mc-itddb-12-e-1";
                $username = "srniefield";
                $password = "0726607";
                $dbname = "01WAPP1400NiefieldS";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
				
                // Fetch events from the database
                $eventQuery = "SELECT * FROM Events ORDER BY EventYear DESC";
                $eventResult = $conn->query($eventQuery);

                if ($eventResult && $eventResult->num_rows > 0) {
                    while ($event = $eventResult->fetch_assoc()) {
                        $selected = (isset($_GET['EventID']) && $_GET['EventID'] == $event['EventID']) ? 'selected' : '';
                        echo "<option value='" . $event['EventID'] . "' $selected>" . $event['EventYear'] . "</option>";
                    }
                } else {
					echo "<option>none</option>";
				}
				$conn->close();
                ?>
            </select>

            <label for="donationAmount">Donation Amount ($):</label>
            <input type="number" id="donationAmount" name="donationAmount" min="1" step="0.01" required>

            <label for="paymentMethod">Payment Method:</label>
            <select id="paymentMethod" name="paymentMethod" required>
                <option value="">-- Select Payment Method --</option>
                <option value="Cash">Cash</option>
                <option value="Check">Check</option>
                <option value="Credit Card">Credit Card</option>
            </select>

            <div class="button-container">
                <input type="submit" value="Donate Now">
                <a href="Assignment13_SN.php">Home</a>
            </div>
        </form>
    </div>
</body>

</html>
