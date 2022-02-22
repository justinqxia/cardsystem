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
$stmt = $con->prepare('SELECT password, email, type1, floor FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $type1, $floor);
$stmt->fetch();
$stmt->close();
if ($type1=='residential') {
	echo '';
	}
	else {
		header('Location: homenecp.php');
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
		<script type="text/javascript">
    function ShowHideDiv(chkPassport) {
        var dvPassport = document.getElementById("dvPassport");
        dvPassport.style.display = chkPassport.checked ? "block" : "none";
    }
	</script>

<script type="text/javascript">
function destinationselect(val){
 var element=document.getElementById('box');
 if(val=='Other')
   element.style.display='block';
 else  
   element.style.display='none';
}
</script>

	</head>

	<!--menu-->
	<body class="loggedin" onload="startTime()">
	<nav class="navtop">
			<div>
				<h1>Card System</h1>
				<a href="homestudent.php"><i class="fas fa-home"></i>Home</a>
				<a href="yourcard.php"><i class="fas fa-id-card"></i>Your Card</a>
                <a href="studentprofile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$email?>!</p>
		</div>
		<!--end menu-->
<table class="center"><!--start form-->
<form style="text-align:left;" action="insert.php" method="POST"><!-- autocomplete="off" -->
<tr><td><!--ID Number Here--><input type="hidden" name="id" value="<?=$_SESSION['id']?>" readonly></td></tr>
<tr><td><!--Email Address Here--><input type="hidden" name="email" value="<?=$_SESSION['name']?>" readonly></td></tr>
<tr><td><!--Name Here--><input type="hidden" name="name" value="<?=$email?>" readonly></td></tr>
<tr><td><!--Floor Here--><input type="hidden" name="floor" value="<?=$floor?>" readonly></td></tr>
<tr><td style="text-align:left;"><select name="destination" onchange='destinationselect(this.value);' required> 
	<option value="">Please select a destination</option>
    <option value="Atrium">Atrium</option>
    <option value="Ball_Gym">Ball Gym</option>
    <option value="Bracken" >Bracken Library</option>
    <option value="Burris" >Burris</option>
    <option value="Goldform">Gold Form</option>
    <option value="North_Dinning" >North Dining</option>
	<option value="Noyer" >Noyer</option>
	<option value="NECP" >NECP</option>
    <option value="Quad" >Quad</option>
    <option value="Tally" >Student Center/Tally</option>
    <option value="Village" >Village</option>
    <option value="Other">Other</option>
  </select></td></tr>
<tr><td style="text-align:left;"><input type="text" name="destination1" placeholder="Type destination here" id="box" style='display:none;'></td></tr>
<tr><td style="text-align:left;"><label for="return1">Excpected time of return:</label>
<input type="time" id="return1" name="return1" required></td></tr>
<tr><td style="text-align:left;"><label for="chkPassport">
    <input type="checkbox" name="companion" id="chkPassport" onclick="ShowHideDiv(this)">
    Check the box if you have a companion.
</label>
<div id="dvPassport" style="display: none">
	Companion Name:
    <input type="text" name="companion" id="txtPassportNumber">
</div><!--end of companion--></td></tr>
<tr><td style="text-align:left;">
<p>Do you need Special Permission (SP)?</p>
<input type="radio" id="sp" name="sp" value="Y" required>
<label for="yes">Yes</label>
<input type="radio" id="no" name="sp" value="N" checked="checked" required>
<label for="no">No</label></td></tr>
<tr><td style="text-align:left;"><p>Click submit to finish</p></td></tr>
<tr><td style="text-align:left;"><input type="submit" value="Submit" name="submit"></td></tr>
</form><!--end of the form-->
<tr><form action="reset.php">
<td style="text-align:left;"><!--ID Number Here--><input type="hidden" name="id" value="<?=$_SESSION['id']?>" readonly></td></tr>
<tr><td style="text-align:left;"><input type="submit" value="Reset Your Card" name="reset"></td></tr>
</form><tr></table>
<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center; font-size: 19px;">Developed by Nico Minnich, Justin Xia, and Henry Cooper</p>
	</body>
</html>