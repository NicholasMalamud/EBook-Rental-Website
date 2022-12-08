<?php 
//ini_set('session.use_cookies','0');
//ini_set('session.use_only_cookies','0');

session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>

    <script src="https://kit.fontawesome.com/aee0ea0830.js" crossorigin="anonymous"></script>
    <link href="register.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1>Create an Account</h1>
    
        <div id="register-info">
            <form method="POST">
                <i class="fa fa-user icon"></i><input id="name" name="fullname" type="text" placeholder="Enter full name" required><br>
                <i class="fa fa-envelope icon"></i><input id="email" name="email" type="email" placeholder="Enter email" required><br>
                <i class="fa-solid fa-lock icon"></i><input id="password" name="password" type="password" placeholder="Enter password" required><br>
                <input id="registerbtn" name="register" type="submit" value="Register"><br>
                <br><a href="login.php">Go Sign in</a>
            </form>
        </div>
</body>
</html>

<?php
//if register is set
if(isset($_POST['register'])){
    //connect to database
    require_once("config.php");

    //store table name
    $TableName = "users";
    
    //save all input from user
    $name = $_POST["fullname"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    
    //form select query
    $sql = "SELECT * FROM $TableName";
    //store results
    $result = $pdo->query($sql);
    
    //loop through results to find if email has been used before
    while($row = $result->fetch()){
        //if email is used then throw alert error
        if($row['email'] == $email){
            exit("<script type='text/javascript'>alert('This email is already tied to an account.')</script>");
        }
    }
    
    //insert new user
    $sql = "INSERT INTO $TableName VALUES(NULL, :n, :em, :pw)";
    $result = $pdo->prepare($sql);
    $result->execute(array(":n"=>$name, ":em"=>$email, ":pw"=>$pass));
    
    //retrieve the userID
    $sql = "SELECT * FROM $TableName WHERE email = :em";
    $result = $pdo->prepare($sql);
    $result->execute(array(":em"=>$email));
    $row = $result->fetch();
    $UserID = $row['userID'];
    $_SESSION['userID'] = $UserID;


    //close connection
    $pdo = null;
}

?>