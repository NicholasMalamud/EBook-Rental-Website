<?php
ini_set('session.use_cookies','0');
ini_set('session.use_only_cookies','0');
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="https://kit.fontawesome.com/aee0ea0830.js" crossorigin="anonymous"></script>
    <link href="dashboard.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1 id="projectName">Dashboard Page</h1>
    <a href = "main.php"><button id="Homepage" name="Homepage" type="button">Return to Homepage</button><br/>
    <a href="logout.php"><button id="signoutbtn" name="signout" type="button">Sign out</button><br/>
    <form>

        <nav class="main-nav">
        
        <div id="menu">
            <button id="acctsetbtn" name="acctset" type="button">Account Settings</button><br/>
            <button id="purchasebtn" name="purchase" type="button">Your Purchases</button><br/>
            <button id="wishlistbtn" name="wishlist" type="button">Wishlists</button><br/>
            <button id="contacttbtn" name="contact" type="button">Contact Us</button><br/>
            <button id="helpbtn" name="help" type="button">Help</button><br/>
        </div>
        
        </nav>
    </form>
</body>
</html>