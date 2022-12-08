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
    
    //if there is no row with matching ID
    //throw error alert
    if(!$row = $result->fetch()){
        echo "<p id=results>Sorry Book Doesn't Exist</p>";
    }
    else
    {
        //else we return results
        $title = $row['title'];
        $icon = $row['iconPath'];
        $desc = $row['summary'];
        $price = $row['price'];
    }  

    $pdo = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="bookpage.css">
    <title>Book Page</title>
    <meta charset="utf-8" />
</head>
<body>
    <h1><?php echo $title ?></h1>
    <table>
        <tr>
            <td>
                <p>
                    Description:<br>
                <?php echo $desc ?>


                <p>
            </td>
            <td>
                <img height="600px" width = "400px" src = "icons/<?php echo $icon ?>"> <!--this is a placeholder novel-->
                <p style="font-weight:bold;">Price: $<?php echo $price ?></p>
            </td>
        </tr>
    </table>
    <form method="POST">
        <button id="rent" type="submit" name="rent">Rent</button>
    </form>
   
</body>
</html>


<?php

//if submit is set
if(isset($_POST['rent'])){
    header("Location: buyPage.php?bookID=".$bookID);
}
?>