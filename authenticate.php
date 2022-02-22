<?php
session_start();

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>Login - IASMH</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <script src="https://kit.fontawesome.com/6f277423d3.js" crossorigin="anonymous"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="login">
            <h1>Login</h1>
            <center><img src="download.png" alt="Academy Logo"></center>
            <form action="authenticate.php" method="post">
                <label for="username">
                    <i class="fas fa-user"></i>
                </label>
                <input type="text" name="username" placeholder="Username" id="username" required>
                <label for="password">
                    <i class="fas fa-lock"></i>
                </label>
                <input type="password" name="password" placeholder="Password" id="password" required>
                <p style="text-align:center; color:#FF0000">ERROR: Please fill both the username and password! If this continues to happen please contact one of the developers to resolve the issue.</p>
                <input type="submit" value="Login">
            </form>
            <br><p style="text-align:center; font-size: 19px;">Developed by Nico Minnich, Justin Xia, and Henry Cooper</p><br>
    </div>
</body>
</html>');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password, type1 FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $type1);
        $stmt->fetch();
        // Account exists, now we verify the password.
        if ($_POST['password'] === $password) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            // header('Location: homestudent.php');
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['type1'] = $type1;
            if ($type1=='staff') {
                header('Location: homestaff.php');
            }
                elseif ($type1=='residential') {
                    header('Location: homestudent.php');
                }
                    elseif ($type1=='necp') {
                        header('Location: homenecp.php');
                    }
                        elseif ($type1=='staff1') {
                            header('Location: homestaff.php');
                        }
                        else {
                            echo 'You do not have access to this website.';
                        }
        }
        else {
        // Incorrect password
        echo 
        '<html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta charset="utf-8">
            <title>Login - IASMH</title>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            <script src="https://kit.fontawesome.com/6f277423d3.js" crossorigin="anonymous"></script>
            <link href="style.css" rel="stylesheet" type="text/css">
        </head>
        <body>
            <div class="login">
                <h1>Login</h1>
                <center><img src="download.png" alt="Academy Logo"></center>
                <form action="authenticate.php" method="post">
                    <label for="username">
                        <i class="fas fa-user"></i>
                    </label>
                    <input type="text" name="username" placeholder="Username" id="username" required>
                    <label for="password">
                        <i class="fas fa-lock"></i>
                    </label>
                    <input type="password" name="password" placeholder="Password" id="password" required>
                    <p style="text-align:center; color:#FF0000">ERROR: Incorrect username and/or password! If this continues to happen please contact one of the developers to resolve the issue.</p>
                    <input type="submit" value="Login">
                </form>
                <br><p style="text-align:center; font-size: 19px;">Developed by Nico Minnich, Justin Xia, and Henry Cooper</p><br>
		    </div>
	    </body>
        </html>';
        }
    }
	$stmt->close();
}
?>