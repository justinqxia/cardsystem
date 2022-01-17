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
$stmt = $con->prepare('SELECT companion, destination, sp, return1 FROM cards WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($companion, $destination, $sp, $return1);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
	<head>
    <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
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
		<title>Your Card</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <!--menu-->
	<body class="loggedin" onload="startTime()">
	<nav class="navtop">
			<div>
				<h1>Card System</h1>
				<a href="home.php"><i class="fas fa-home"></i>Home</a>
				<a href="yourcard.php"><i class="fas fa-id-card"></i>Your Card</a>
                <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Your Card</h2>
            <table class="center">
                <tr>
                    <td>
                        Destination
                    </td>
                    <td>
                        Companion
                    </td>
                    <td>
                        Expected Return Time
                    </td>
                    <td>
                        Special Permission (SP)
                    </td>
                </tr>
                <tr>
                    <td>
			        <?=$destination?>
                    </td>
                    <td>
                    <?=$companion?>
                    </td>
                    <td>
                    <?=$return1?>
                    </td>
                    <td>
                    <?=$sp?>
                    </td>
            </table>
		</div>
        <br>
<form action="reset.php" style="text-align:center;">
<!--ID Number Here--><input type="hidden" name="id" value="<?=$_SESSION['id']?>" readonly>
<input type="submit" value="Reset Your Card" name="reset">
</form>
<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center;">Developed by Justin Xia, Nico Minnich, and Henry Copper</p>
	</body>
</html>