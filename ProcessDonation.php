<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "mc-itddb-12-e-1";
$username = "srniefield";
$password = "0726607";
$dbname = "01WAPP1400NiefieldS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $golferID = $_POST['golfer'];
    $donationAmount = $_POST['donationAmount'];
    $paymentMethod = $_POST['paymentMethod'];
    $paymentStatus = ($paymentMethod == "Credit Card") ? "PAID" : "UNPAID";
	$eventID = $_POST['EventID'];

    // Insert into the Sponsors table 	

	$maxPKQuery = "SELECT MAX(SponsorID) + 1 AS NextSponsorID FROM Sponsors";
    $result = $conn->query($maxPKQuery);
	
    if ($result && $row = $result->fetch_assoc()) {
        $MaxPK = $row['NextSponsorID'] ?? 1;
    } else {
        die("Error fetching next SponsorID: " . $conn->error);
    }
	
	mysqli_free_result($result);

    $sponsorInsert = "INSERT INTO Sponsors (SponsorID, FirstName, LastName, Address, City, StateID, ZipCode, PhoneNumber, Email)
                      VALUES ($MaxPK, '$firstName', '$lastName', '$address', '$city', $state, $zip, $phone, '$email')";

    if ($conn->query($sponsorInsert) === TRUE) {
        $sponsorID = $conn->insert_id; // Get the last inserted SponsorID
	
		$maxPKQuery = "SELECT MAX(DonationID) + 1 AS NextID FROM Donations";
		$result = $conn->query($maxPKQuery);
	
		if ($result && $row = $result->fetch_assoc()) {
			$MaxPKD = $row['NextID'] ?? 1;
		} else {
			die("Error fetching next DonationID: " . $conn->error);
		}
	
	mysqli_free_result($result);

        // Insert into the Donations table
		if ($paymentMethod == "Credit Card") {
			$paymentMethod = 3;
			$paymentStatus = 1;
		} else {
			$paymentStatus = 2;
		}
		
		if ($paymentMethod == "Check") {
			$paymentMethod = 1;
		} else {
			$paymentMethod = 2;
		}
        $donationInsert = "INSERT INTO Donations (`DonationID`, `SponsorID`, `GolferID`, `AmountPledged`, `PaymentStatusID`, `PaymentTypeID`, `EventID`)
                           VALUES ($MaxPKD, $MaxPK, $golferID, $donationAmount, $paymentStatus, $paymentMethod, $eventID)";

        if ($conn->query($donationInsert) === TRUE) {
            echo "<h2 style='color: green;'>Thank you for your donation, $firstName!</h2>";
            echo "<p>Your donation of $" . number_format($donationAmount, 2) . " has been successfully recorded.</p>";
            echo "<p><a href='Assignment13_SN.php'>Return to Home</a></p>";
        } else {
            echo "<h2 style='color: red;'>Error: Could not record donation.</h2>";
            echo "Error: " . $donationInsert . "<br>" . $conn->error;
        }
    } else {
        echo "<h2 style='color: red;'>Error: Could not record sponsor.</h2>";
        echo "Error: " . $sponsorInsert . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "<h2 style='color: red;'>Invalid request.</h2>";
}
?>