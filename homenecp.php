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
$stmt = $con->prepare('SELECT password, email, type1, floor, firstname, lastname FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $type, $floor, $firstname, $lastname);
$stmt->fetch();
$stmt->close();
if ($type=='necp') {
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
<!--Style for alert box-->
<style>
.alert {
  padding: 20px;
  background-color: #983841;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
.glow {
  color: #ffffff;
  text-align: center;
  animation: glow 1s ease-in-out infinite alternate;
}

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #e60073, 0 0 40px #e60073, 0 0 50px #e60073, 0 0 60px #e60073, 0 0 70px #e60073;
  }
  
  to {
    text-shadow: 0 0 20px #fff, 0 0 30px #ff4da6, 0 0 40px #ff4da6, 0 0 50px #ff4da6, 0 0 60px #ff4da6, 0 0 70px #ff4da6, 0 0 80px #ff4da6;
  }
}
div.sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
</style>
<!--end systle for alert box-->

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
	<!--start alert box-->
	<div class="alert sticky">
	<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
	<strong class="glow">Alert:</strong> The website is still being developed not all the features may be fully functional yet.
	</div>
	<!--end alert box-->
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$firstname?> <?=$lastname?>!</p>
		</div>
		<!--end menu-->
<table class="center"><!--start form-->
<form style="text-align:left;" action="insertnecp.php" method="POST"><!-- autocomplete="off" -->
<tr><td><!--ID Number Here--><input type="hidden" name="id" value="<?=$_SESSION['id']?>" readonly></td>
<td><!--Email Address Here--><input type="hidden" name="email" value="<?=$_SESSION['name']?>" readonly></td>
<td><!--First Name Here--><input type="hidden" name="firstname" value="<?=$firstname?>" readonly></td>
<td><!--Last Name Here--><input type="hidden" name="lastname" value="<?=$lastname?>" readonly></td>
<td><!--Floor Here--><input type="hidden" name="floor" value="<?=$floor?>" readonly></td></tr>
<td><!--Companion Here--><input type="hidden" name="companion" value="NECP" readonly></td></tr>
<td><!--Companion Here--><input type="hidden" name="sp" value="NECP" readonly></td></tr>
<tr><td style="text-align:left;"><select name="destination" onchange='destinationselect(this.value);' required> 
	<option value="">Please select your reason for being here</option>
    <option value="Homework">Homework</option>
    <option value="Hang Out">Hang out with friends</option>
	<option value="Meeting">Meeting</option>
    <option value="Other">Other</option>
  </select></td></tr>
<tr><td style="text-align:left;"><input type="text" name="destination1" placeholder="Type your reason here" id="box" style='display:none;'></td></tr>
<tr><td style="text-align:left;"><label for="return1">Expected time of departure:</label>
<input type="time" id="return1" name="return1" required></td></tr>
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