<!DOCTYPE html>
<html>
	<head>
    <link rel="icon" type="image/x-icon" href="favicon-32x32.png">
		<meta charset="utf-8">
		<title>Comment Submission</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
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

<center><?php
if (isset($_POST['submit'])) {
    if (isset($_POST['id']) && isset($_POST['comment'])) {
        
        $id = $_POST['id'];
        $comment = $_POST['comment'];
        
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "phplogin";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Insert = "INSERT INTO comments (id, comments) values(?)";

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
                $stmt->bind_param("is", $id, $comment);
                if ($stmt->execute()) {
                    echo $firstname $lastname"'s status has been updated.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo 'They already have a status set. You need to reset their status before you can update this students status.';
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo 'Please go back and fill out everything in the form.';
        die();
    }
}
else {
    echo "Submit button is not set.";
}
?></center>
<form action="reset.php" style="text-align: center; ">
<!--ID Number Here--><input type="hidden" name="id" value="<?=$_SESSION['id']?>" readonly>
<input type="submit" value="Reset Your Card" name="reset">
</form>
<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center; font-size: 19px;">Developed by Nico Minnich, Justin Xia, and Henry Cooper</p>
	</body>
</html>