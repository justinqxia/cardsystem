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
$stmt1 = $con->prepare('SELECT type1, floor FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.

$stmt1->bind_param('i', $_SESSION['id']);
$stmt1->execute();
$stmt1->bind_result($type, $floor);
$stmt1->fetch();
$stmt1->close();
if ($type=='staff') {
	echo '';
}
	else {
		header('Location: yourcard.php');
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
		<title>Your Floor</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script src="https://kit.fontawesome.com/6f277423d3.js" crossorigin="anonymous"></script>
<style>
th {
  cursor: pointer;
}
</style>
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
        <?php 
        // if your form method is post, use $_POST, if it's get, use $_GET
        if(isset($_POST['color'])) $searchBoxfruit = $_POST['color'];
        ?>
        <p><?php
        if ($floor==4) {
          echo 'Currently displaying 4th floor.';
        }
        elseif ($floor==3) {
          echo 'Currently displaying 3rd floor.';
        }
        elseif ($floor==2) {
          echo 'Currently displaying 2nd floor.';
        }
        elseif ($floor==1) {
          echo 'Currently displaying 1st floor.';
        }
          else {
            echo 'Please select a floor you would like to view. Feature is not available at the moment.';
          }
        ?></p>
<style>		
	th:hover {background-color: #2f3947; color: white;}
</style>
</div>
<?php
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

$sql = "SELECT destination, companion, return1, sp, id, email, signout, floor, firstname, lastname, status FROM slots";
$result = $conn->query($sql);


//Converting 24 Time to 12 hour time
//$army_time_str = $row["return1"];
//$regular_time_str = date( 'g:i A', strtotime( $army_time_str ) );
//echo $regular_time_str;


if ($result->num_rows > 0) {
  // output data of each row
  echo "<table border=2 cellpadding=10 cellspacing=15 id='myTable'>
  		<thead><tr><th onclick='sortTable(0)'>First Name</th><th onclick='sortTable(1)'>Last Name</th><th onclick='sortTable(2)'>ID Number</th><th onclick='sortTable(3)'>Floor Number</th><th onclick='sortTable(4)'>Email</th><th onclick='sortTable(5)'>Destination</th><th onclick='sortTable(6)'>Sign Out Time</th><th onclick='sortTable(7)'>Expected Return Time</th><th onclick='sortTable(8)'>Companion</th><th onclick='sortTable(9)'>SP</th><th onclick='sortTable(10)'>Status</th></tr></thead>";
  while($row = $result->fetch_assoc()) {
    echo "
    <tbody><tr><td>" . $row["firstname"]. "</td><td>" . $row["lastname"]. "</td><td>" . $row["id"] . " </td><td>" . $row["floor"]. "</td><td> " . $row["email"]. " </td><td> " . $row["destination"] . " </td><td>" . $row["signout"] . " </td><td> " . $row["return1"]. " </td><td> " . $row["companion"]. " </td><td> " . $row["sp"]. " </td><td> " . $row["status"]. "</td></tr><tbody><br>";
  }
} else {
  echo "<p style='font-size:30px;text-align:center;' >No one is currently signed out of the building.</p>";
}
$conn->close();
?></table>
<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center; font-size: 19px;">Developed by Nico Minnich, Justin Xia, and Henry Cooper</p>
	</body>
</html>