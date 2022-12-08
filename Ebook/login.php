<?php
//ini_set('session.use_cookies','0');
//ini_set('session.use_only_cookies','0');
session_start();
//echo session_id();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="data:;base64,=">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="https://kit.fontawesome.com/aee0ea0830.js" crossorigin="anonymous"></script>
    <link href="login.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1 id="projectName">E-book Rental Service</h1>
    
    <div id="login">
        <form method="GET">
            <i class="fa fa-envelope icon"></i><input name="email" type="email" placeholder="enter email" required><br>
            <i class="fa-solid fa-lock icon"></i><input name="password" type="password" placeholder="enter password" required><br>
            <input id="loginbtn" name="Submit" type="submit" value="sign in"><br><br>
            <a id="register-link" href="register.php">create account</a>
        </form>
    </div>
        
</body>
</html>

<?php

//if submit is set
if(isset($_GET['Submit'])){
    //connect to database
    require_once("config.php");

    //take email and password from user input
    $email = $_GET["email"];
    $pass = $_GET["password"];

    //table name in database
    $TableName = "users";

    //form sql select query
    $sql = "SELECT * FROM $TableName 
            WHERE email = :em AND password = :pw";

    //store result of prepare statement
    $result = $pdo->prepare($sql);
    //execute prepared statement
    $result->execute(array(":em"=>$email, ":pw"=>$pass));
    
    //if there is no row with matching email and password
    //throw error alert
    if(!$row = $result->fetch()){
        exit("<script type='text/javascript'>alert('Enter a valid email address and password.')</script>");
    }
    //else we just store userID
    $UserID = $row['userID'];
    //set userID in session cookie
    $_SESSION["userID"] = $UserID;
    //go into main
    session_write_close();
    //header("Location: main.php?userID=".$_SESSION["userID"]);
    header("Location: main.php");
    $pdo = null;

}
?>

