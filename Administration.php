<!DOCTYPE html>
<html>

	<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
	</head>

	<body>
    <h1>Administration Login</h1>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Login">
    </form>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "mc-itddb-12-e-1";
        $username = "srniefield";
        $password = "0726607";
        $dbname = "01WAPP1400NiefieldS";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $inputUsername = $_POST['username'];
        $inputPassword = $_POST['password'];

        // Query to check for admin credentials
		$sql = "SELECT FirstName, LastName, ID, Password FROM Administration WHERE ID = '$inputUsername'";
		$result = $conn->query($sql);

		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$firstName = $row['FirstName'];
			$lastName = $row['LastName'];
			$adminID = $row['ID'];
			$storedPassword = $row['Password'];

			if ($inputPassword == $storedPassword) {
				session_start();
				$_SESSION['adminID'] = $adminID;
				$_SESSION['adminName'] = $firstName . ' ' . $lastName;
				header("Location: AdminDashboard.php");
				exit();
			} else {
				echo "<p style='color: red;'>Invalid password.</p>";
			}
		} else {
			echo "<p style='color: red;'>Invalid username.</p>";
		}
        $conn->close();
    }
    ?>
</body>

</html>