<?php

session_start();

//if book is set
if(isset($_GET['bookID'])){
    //connect to database
    require_once("config.php");
    
    //get searched bookID
    $bookID = $_GET["bookID"];

    //table name in database
    $TableName = "books";

    //form sql select query
    $sql = "SELECT * FROM $TableName 
            WHERE bookID = :bookID";

    //store result of prepare statement
    $result = $pdo->prepare($sql);
    //execute prepared statement
    $result->execute(array(":bookID"=>$bookID));
    
    //if there is no row with matching title
    //throw error alert
    if(!$row = $result->fetch()){
        echo "<p id=results>Sorry Book Doesn't Exist</p>";
    }
    else
    {
        //else we return results
        $title = $row['title'];
        $icon = $row['iconPath'];
        $price = $row['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-compatible" content = "IE=edge" />
    <meta name="viewport" content="width-device-width, initial-scale=1.0" />
    <meta name="author" content="Nicholas Malamud">
    <title>Checkout</title>
    <link rel="stylesheet" type = "text/css" href="buyPage.css" />
</head>
<body>
    <h1>Checkout</h1>
    <table border="1"> 
        <td>
            <p><strong>Title:</strong> <?php echo $title ?></p> 
            <p><strong>Price:</strong> $<?php echo $price ?></p> 
            <img src="icons/<?php echo $icon ?>" alt="BookIcon" height="310" width="200"/> 
        </td>
        <td>
            <form method="POST">
                <p>   
                    <h3>Personal Info:</h3>
                    <label>Name: </label> <input type="text" name="name" size="38" maxlength="43" /> <br> <br>
                    <label>Phone Number: </label> <input type="tel" name="phone" size="38" maxlength="43" /> <br> <br>
                    <label>Email: </label> <input type="email" name="email" size="38" maxlength="43" /> <br> <br>
                    <label>Address: </label> <input type="text" name="address" size="38" maxlength="43" /> <br> <br>
                    
                    <h3>Credit Info:</h3>
                    <label>Credit Card Number: </label> <input type="text" name="creditcard" size="38" maxlength="43" /> <br> <br>
                    <label>CCV Code: </label> <input type="text" name="ccv" size="38" maxlength="43" /> <br> <br>
                    <label>Name on Card: </label> <input type="text" name="nameoncard" size="38" maxlength="43" /> <br> <br>

                    <input class="buttons" type="submit" name="Purchase" value="Purchase" />
                    <input class="buttons" type="reset" value="Clear"  />
                </p>
            </form>
        </td>
   
</body>
</html>

<?php
//if submit button isset 
if(isset($_POST['Purchase'])){
    //connect to database
    require_once("config.php");

    //get all data from the form
    //not needed for now

    //table name
    $TableName = "orders";
    
    //form select query
    $sql = "SELECT * FROM $TableName";
    //store results
    $result = $pdo->query($sql);
    
    $owned = false;
    //loop through results to find if user owns book
    while($row = $result->fetch()){
        //if user is tied to book then throw alert error
        if($row['user']==$_SESSION["userID"] && $row['book']== $bookID){
            $owned = true;
            echo "You Already Own This Book";
        }
    }
    
    if ($owned == false)
    {
        $today = date("Y-m-d");
        //generate insert query
        $sql = "INSERT INTO $TableName VALUES(NULL, :user, :book, :current, :expire)";
        $result = $pdo->prepare($sql);
        $result->execute(array(":user"=>$_SESSION["userID"], ":book"=>$bookID, ":current"=>$today, ":expire"=>$today));
    }
    //close connection
    $pdo = null;
}
?>