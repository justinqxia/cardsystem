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
$stmt = $con->prepare('SELECT password, email, type1, lastname, firstname FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $type, $lastname, $firstname);
$stmt->fetch();
$stmt->close();
if ($type=='staff') {
	echo '';
}
	else {
		header('Location: homestudent.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="icon" type="image/x-icon" href="favicon-32x32.png">
	<style>
      table,

      td {
        text-align: center;
        vertical-align: middle;
      }
	  table.center {
  margin-left: auto; 
  margin-right: auto;
	}
    </style>
		<meta charset="utf-8">
		<title>Groundings</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <script src="https://kit.fontawesome.com/6f277423d3.js" crossorigin="anonymous"></script>
	</head>

	<!--menu-->
	<body class="loggedin" onload="startTime()">
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
			<h2>Groundings and other information</h2>
        </div>
<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center; font-size: 19px;">Developed by Nico Minnich, Justin Xia, and Henry Cooper</p>
</body>
</html>