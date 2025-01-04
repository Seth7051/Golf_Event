<!DOCTYPE html>
<html>
<body>
<?php
$servername = "mc-itddb-12-e-1";
$username = "srniefield";
$password = "0726607";
$dbname = "01WAPP1400NiefieldS"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
	
	$GolferID = $_POST["GolferID"];
	$txtFirstName = $_POST["txtFirstName"];
	$txtLastName = $_POST["txtLastName"];
	$txtAddress = $_POST["txtAddress"];
	$txtCity = $_POST["txtCity"];
	$intState = $_POST["txtState"];
	$txtZip = $_POST["txtZip"];
	$txtPhone = $_POST["txtPhone"];
	$txtEmail = $_POST["txtEmail"];
	$intShirtSize = $_POST["txtShirtSize"];
	$intGender = $_POST["txtGender"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == "Submit") {
	
	$maxPKQuery = "SELECT MAX(TG.GolferID) + 1 AS NextGolferID FROM Golfers AS TG";
    $result = $conn->query($maxPKQuery);
	
    if ($result && $row = $result->fetch_assoc()) {
        $MaxPK = $row['NextGolferID'] ?? 1;
    } else {
        die("Error fetching next GolferID: " . $conn->error);
    }
	
	mysqli_free_result($result);
	
	$sql = "INSERT INTO Golfers (GolferID, FirstName, LastName, Address, City, StateID, ZipCode, PhoneNumber, Email, ShirtSizeID, GenderID)
    VALUES (" . $MaxPK . ", '" . $txtFirstName . "', '" . $txtLastName . "', '" . $txtAddress . "', '" . $txtCity . 
	"', " . $intState . ", " . $txtZip . ", '" . $txtPhone . "', '" . $txtEmail . "', " . $intShirtSize . ", " . $intGender . ");";
	
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
		
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
} else {
	
	$sql = "Update Golfers SET FirstName = '" . $txtFirstName . "', LastName = '" . $txtLastName . 
	"', Address = '" . $txtAddress . "', City = '" . $txtCity . "', StateID = " . $intState . ", ZipCode = " . $txtZip . 
	", PhoneNumber = '" . $txtPhone . "', Email = '" . $txtEmail . "', ShirtSizeID = " . $intShirtSize . ", GenderID = " . $intGender .
	" WHERE GolferID = " . $GolferID;
	
	if ($conn->query($sql) === TRUE) {
		echo "Record Updated successfully";
		
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}


 
// Close connection
mysqli_close($conn);
?>

<p><a href="Assignment13_SN.php">Home</p>
<p><a href="showgolfers.php">View Golfers</a></p>

</body>
</html>


