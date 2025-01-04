<!DOCTYPE html>
<html>

<body>

	<h1>Update Golfer</h1>
    <?php
    // Database connection settings
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

    $GolferID = isset($_GET['GolferID']) ? intval($_GET['GolferID']) : 0;

    if ($GolferID > 0) {
        // Fetch golfer details
        $Golfer = "SELECT * FROM Golfers WHERE GolferID = $GolferID";
        $result = mysqli_query($conn, $Golfer);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result); // Fetch golfer data
    ?>

    <form name="frmGolfers" method="post" action="Process_Golfers.php">
	<input type="hidden" name="GolferID" value="<?php echo htmlspecialchars($row['GolferID']); ?>">
        <table border="1">
            <tr>
                <th>First Name</th>
                <td><input type="text" id="txtFirstName" name="txtFirstName" value="<?php echo htmlspecialchars($row['FirstName']); ?>" required></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><input type="text" id="txtLastName" name="txtLastName" value="<?php echo htmlspecialchars($row['LastName']); ?>" required></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><input type="text" id="txtAddress" name="txtAddress" value="<?php echo htmlspecialchars($row['Address']); ?>" required></td>
            </tr>
            <tr>
                <th>City</th>
                <td><input type="text" id="txtCity" name="txtCity" value="<?php echo htmlspecialchars($row['City']); ?>" required></td>
            </tr>
            <tr>
                <th>State</th>
                <td>
                    <select id="txtState" name="txtState" required>
                        <option value="">Select State</option>
                        <?php 
                        $States = "SELECT StateID, State FROM States";
                        $statesResult = $conn->query($States);

                        if ($statesResult->num_rows > 0) {
                            while ($stateRow = $statesResult->fetch_assoc()) {
                                $selected = ($stateRow['StateID'] == $row['StateID']) ? "selected" : "";
                                echo "<option value='" . $stateRow['StateID'] . "' $selected>" . $stateRow['State'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No states found</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Zip Code</th>
                <td><input type="text" id="txtZip" name="txtZip" value="<?php echo htmlspecialchars($row['ZipCode']); ?>" required></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><input type="text" id="txtPhone" name="txtPhone" value="<?php echo htmlspecialchars($row['PhoneNumber']); ?>" required></td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><input type="text" id="txtEmail" name="txtEmail" value="<?php echo htmlspecialchars($row['Email']); ?>" required></td>
            </tr>
            <tr>
                <th>Shirt Size</th>
                <td>
                    <select id="txtShirtSize" name="txtShirtSize" required>
                        <option value="">Select Size</option>
                        <?php 
                        $ShirtSizes = "SELECT ShirtSizeID, ShirtSize FROM ShirtSizes";
                        $sizesResult = $conn->query($ShirtSizes);

                        if ($sizesResult->num_rows > 0) {
                            while ($sizeRow = $sizesResult->fetch_assoc()) {
                                $selected = ($sizeRow['ShirtSizeID'] == $row['ShirtSizeID']) ? "selected" : "";
                                echo "<option value='" . $sizeRow['ShirtSizeID'] . "' $selected>" . $sizeRow['ShirtSize'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No sizes found</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>
                    <select id="txtGender" name="txtGender" required>
                        <option value="">Select Gender</option>
                        <?php 
                        $Genders = "SELECT GenderID, Gender FROM Genders";
                        $gendersResult = $conn->query($Genders);

                        if ($gendersResult->num_rows > 0) {
                            while ($genderRow = $gendersResult->fetch_assoc()) {
                                $selected = ($genderRow['GenderID'] == $row['GenderID']) ? "selected" : "";
                                echo "<option value='" . $genderRow['GenderID'] . "' $selected>" . $genderRow['Gender'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No genders found</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <input type="submit" name="action" value="Update">
                    <input type="reset" name="btnReset" value="Reset">
                </td>
            </tr>
        </table>
    </form>

    <?php
        } else {
            echo "No golfer found with ID $GolferID.";
        }
    } else {
        echo "Invalid Golfer ID.";
    }
	
	

    // Close connection
    mysqli_close($conn);
    ?>

</body>
</html>
