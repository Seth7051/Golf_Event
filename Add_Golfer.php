<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Golfer</title>
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
Name: Seth Niefield <br>
Class: IT-117-400 <br>
Abstract: Homework #12

<h1>Homework 12</h1>

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

?>


<div class="container">
<form name="frmGolfers" method="post" action="Process_Golfers.php">
    <h2>Registration Form</h2>
        <div>
            <label for="txtFirstName">First Name:</label><br>
            <input type="text" id="txtFirstName" name="txtFirstName" required>
        </div>

        <div>
            <label for="txtLastName">Last Name:</label><br>
            <input type="text" id="txtLastName" name="txtLastName" required>
        </div>

        <div>
            <label for="txtAddress">Address:</label><br>
            <input type="text" id="txtAddress" name="txtAddress" required>
        </div>

        <div>
            <label for="txtCity">City:</label><br>
            <input type="text" id="txtCity" name="txtCity" required>
        </div>

        <div>
            <label for="txtState">State:</label><br>
            <select id="txtState" name="txtState" required>
                <option value="">Select State</option>
                <?php 
                $States = "SELECT StateID, State FROM States";
                $result = $conn->query($States);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["StateID"] . "'>" . $row["State"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No states found</option>";
                } ?>
            </select>
        </div>

        <div>
            <label for="txtZip">Zip Code:</label><br>
            <input type="text" id="txtZip" name="txtZip" required>
        </div>

        <div>
            <label for="txtPhone">Phone Number:</label><br>
            <input type="text" id="txtPhone" name="txtPhone" required>
        </div>

        <div>
            <label for="txtEmail">Email Address:</label><br>
            <input type="text" id="txtEmail" name="txtEmail" required>
        </div>

        <div>
            <label for="txtShirtSize">Shirt Size:</label><br>
            <select id="txtShirtSize" name="txtShirtSize" required>
                <option value="">Select Size</option>
                <?php 
                $sql = "SELECT ShirtSizeID, ShirtSize FROM ShirtSizes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["ShirtSizeID"] . "'>" . $row["ShirtSize"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No sizes found</option>";
                } ?>
            </select>
        </div>

        <div>
            <label for="txtGender">Gender:</label><br>
            <select id="txtGender" name="txtGender" required>
                <option value="">Select Gender</option>
                <?php 
                $sql = "SELECT GenderID, Gender FROM Genders";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["GenderID"] . "'>" . $row["Gender"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No genders found</option>";
                } ?>
            </select>
        </div>

        <div class="button-container">
                <input type="submit" name="action" value="Submit">
                <input type="reset" name="btnReset" value="Reset">
                <a href="Assignment13_SN.php">Home</a>
            </div>
    </form>
</div>

</form>
</body>
<?php
// Close connection
mysqli_close($conn);
?>
</html>
