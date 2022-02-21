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
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>

	<!--menu-->
	<body class="loggedin" onload="startTime()">
	<nav class="navtop">
			<div>
				<h1>Card System</h1>
				<a href="homestaff.php"><i class="fas fa-home"></i>Home</a>
				<a href="staffcard.php"><i class="fas fa-id-card"></i>Your Floor</a>
                <a href="staffprofile.php"><i class="fas fa-user-circle"></i>Edit Cards</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$email?>!</p>
<style>		
			tr:hover {background-color: #2f3947; color: white;}
</style>
<table border=2 cellpadding=5 cellspacing=10><tr><td>Student Name</td><td>ID Number</td><td>Email</td><td>Destination</td><td>Return Time</td><td>Companion</td><td>SP</td><td>Overnight/Sick Card</td></tr><?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phplogin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT destination, destination1, companion, return1, sp, id, email, sickcard, name FROM cards";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row["name"]. "</td><td>" . $row["id"]. " </td><td> " . $row["email"]. " </td><td> " . $row["destination"] . $row["destination1"]. " </td><td> " . $row["return1"]. " </td><td> " . $row["companion"]. " </td><td> " . $row["sp"]. " </td><td> " . $row["sickcard"]. "</td></tr><br>";
  }
} else {
  echo "No one is currently signed out.";
}
$conn->close();
?></table>
		</div>
<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center;">Developed by Nico Minnich, Justin Xia, and Henry Copper 2022</p>
	</body>
</html>