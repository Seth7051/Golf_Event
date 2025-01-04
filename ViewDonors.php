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

$golferID = $_GET['GolferID'] ?? 0;
echo "<p>GolferID: $golferID</p>";

$maxPKQuery = "SELECT MAX(EventID) AS EventID FROM Events";
    $result = $conn->query($maxPKQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $EventID = $row['EventID'] ?? 1; // Default to 1 if NULL
    } else {
        die("Error fetching EventID: " . $conn->error);
    }

$donorQuery = "
    SELECT 
        D.DonationID,
        S.FirstName,
        S.LastName,
        D.AmountPledged,
        P.PaymentStatus
    FROM 
        Donations as D join Sponsors as S on S.SponsorID = D.SponsorID
		Join PaymentStatuses as P on D.PaymentStatusID = P.PaymentStatusID
    WHERE 
        D.GolferID = $golferID AND D.PaymentStatusID = 1
";

$result = $conn->query($donorQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Donor List</title>
</head>

<body>
    <h2>Donors for Golfer</h2>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Donation Amount</th>
                    <th>Payment Status</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['FirstName']}</td>
                    <td>{$row['LastName']}</td>
                    <td>\${$row['AmountPledged']}</td>
                    <td>
                        <a href='UpdatePaymentStatus.php?donationID={$row['DonationID']}'>
                            {$row['PaymentStatus']}
                        </a>
                    </td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No donors found for this golfer.</p>";
    }

    $conn->close();
    ?>
</body>

</html>
