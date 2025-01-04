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

// Get DonationID from the URL
$donationID = $_GET['donationID'] ?? 0;

// Fetch the current payment status
$statusQuery = "SELECT D.DonationID, S.FirstName, S.LastName, D.AmountPledged, P.PaymentStatus 
	FROM Donations as D join PaymentStatuses as P on D.PaymentStatusID = P.PaymentStatusID 
	join Sponsors as S on D.SponsorID = S.SponsorID
	WHERE DonationID = $donationID";
$result = $conn->query($statusQuery);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentStatus = $row['PaymentStatus'];
    $newStatus = ($currentStatus == 'PAID') ? 'PAID' : 'UNPAID';
    $donorName = htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']);
    $donationAmount = number_format($row['AmountPledged'], 2);
} else {
    die("Donation not found.");
}

// Handle the toggle action
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($newStatus == 'PAID') {
		$updateQuery = "UPDATE Donations SET PaymentStatusID = 2 WHERE DonationID = $donationID";
	} else {
		$updateQuery = "UPDATE Donations SET PaymentStatusID = 1 WHERE DonationID = $donationID";
	}

    if ($conn->query($updateQuery)) {
        echo "<p style='color: green;'>Payment status updated successfully to '$newStatus'.</p>";
        echo "<a href='ManageEventGolfers.php'>Return to Manage Event Golfers</a>";
        $conn->close();
        exit();
    } else {
        echo "<p style='color: red;'>Error updating payment status: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Payment Status</title>
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
            margin: 0 auto;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4CAF50;
        }

        p {
            font-size: 1.2em;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Change Payment Status</h2>
        <p><strong>Donor Name:</strong> <?php echo $donorName; ?></p>
        <p><strong>Donation Amount:</strong> $<?php echo $donationAmount; ?></p>
        <p><strong>Current Status:</strong> <?php echo $currentStatus; ?></p>
        <p><strong>New Status:</strong> <?php echo $newStatus; ?></p>

        <form method="POST">
            <input type="submit" value="Change Status to <?php echo $newStatus; ?>">
        </form>

        <a href="ManageEventGolfers.php">Cancel and Return</a>
		<a href="Assignment13_SN.php">Home</a>
    </div>
</body>

</html>
