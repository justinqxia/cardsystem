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
$stmt = $con->prepare('SELECT password, email, color FROM accounts WHERE id = ?');
$stmt1 = $con->prepare('SELECT type1 FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $color);
$stmt->fetch();
$stmt->close();

$stmt1->bind_param('i', $_SESSION['id']);
$stmt1->execute();
$stmt1->bind_result($type);
$stmt1->fetch();
$stmt1->close();
if ($type=='staff') {
	echo '';
}
	else {
		header('Location: studentprofile.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="icon" type="image/x-icon" href="favicon-32x32.png">
		<meta charset="utf-8">
		<title>Edit Cards</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script src="https://kit.fontawesome.com/6f277423d3.js" crossorigin="anonymous"></script>
	</head>
	<body class="loggedin">
	<nav class="navtop">
			<div>
				<h1>Card System</h1>
				<a href="homestaff.php"><i class="fas fa-home"></i>Home</a>
				<a href="staffcard.php"><i class="fas fa-id-card"></i>Your Floor</a>
				<a href="groundings.php"><i class="fa-solid fa-book"></i>Groundings</a>
                <a href="staffprofile.php"><i class="fa-solid fa-user-gear"></i>Edit Cards</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Overnight or Sick Card</h2>
			<div>
				<p>Submit a change to someone's card </p>
			</div>
			<!--<form action="insertstaff.php" method="POST">
			<input name="id" maxlength="9" minlength="9" placeholder="Student's ID Number">
			<input name="sickcard" placeholder="Add Sick Card Here">
			<input type="submit" value="Submit" name="submit">
			</form>-->
		</div>
<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center; font-size: 19px;">Developed by Nico Minnich, Justin Xia, and Henry Cooper</p>
	</body>
</html>