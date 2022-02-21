<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password, email, type1 FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $type1);
$stmt->fetch();
$stmt->close();
if ($type1=='staff') {
	echo '';
}
	else {
		header('Location: homestudent.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Overnight/Sick Card Submission</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
    <body class="loggedin">
	<nav class="navtop">
			<div>
				<h1>Card System</h1>
				<a href="homestaff.php"><i class="fas fa-home"></i>Home</a>
				<a href="staffcard.php"><i class="fas fa-id-card"></i>Your Floor</a>
                <a href="staffprofile.php"><i class="fas fa-user-circle"></i>Edit Cards</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>

<center><?php
if (isset($_POST['submit'])) {
    if (isset($_POST['sickcard'])) {
        
        $sickcard = $_POST['sickcard'];
        $id = $_POST['id'];
        
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "phplogin";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT id FROM cards WHERE id = ?";
            $Insert = "INSERT INTO cards(sickcard) values(?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("s", $sickcard);
                if ($stmt->execute()) {
                    echo "Your card has succesufuly been uploaded to the database and you are ready to sign out!";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "You have already filled out your card. To fill it out agian please delete your previous card information by pressing the reset button.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "Please go back and fill out everything in the form.";
        die();
    }
}
else {
    echo "Submit button is not set.";
}
?></center>

<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center;">Developed by Nico Minnich, Justin Xia, and Henry Copper</p>
	</body>
</html>