<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Card Submission</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
    <body class="loggedin">
	<nav class="navtop">
			<div>
				<h1>Card System</h1>
				<a href="homestudent.php"><i class="fas fa-home"></i>Home</a>
				<a href="yourcard.php"><i class="fas fa-id-card"></i>Your Card</a>
                <a href="studentprofile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>

<center><?php
if (isset($_POST['submit'])) {
    if (isset($_POST['return1']) && isset($_POST['destination']) && isset($_POST['destination1']) &&
        isset($_POST['companion']) && isset($_POST['sp']) &&
        isset($_POST['id']) && isset($_POST['email']) && isset($_POST['name'])) {
        
        $return1 = $_POST['return1'];
        $destination = $_POST['destination'];
        $destination1 = $_POST['destination1'];
        $companion = $_POST['companion'];
        $sp = $_POST['sp'];
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "phplogin";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT id FROM cards WHERE id = ? LIMIT 1";
            $Insert = "INSERT INTO cards(destination, destination1, companion, return1, sp, id, email, name) values(?, ?, ?, ?, ?, ?, ?, ?)";

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
                $stmt->bind_param("sssssiss", $destination, $destination1, $companion, $return1, $sp, $id, $email, $name);
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