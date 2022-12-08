<?php
session_start();
$resultArray = [];
$found = false;
//if submit is set
if(isset($_GET['search'])){
    //connect to database
    require_once("config.php");
    
    //get search title
    $title = $_GET["searchbar"];

    //table name in database
    $TableName = "books";

    //form sql select query
    $sql = "SELECT * FROM $TableName 
            WHERE title like CONCAT('%',:title,'%')";

    //store result of prepare statement
    $result = $pdo->prepare($sql);
    //execute prepared statement
    $result->execute(array(":title"=>$title));

    //loop through results to find all searches
    while($row = $result->fetch()){
        $bookID = $row['bookID'];
        $title = $row['title'];
        $resultArray[] = array($bookID => $title);
        $found = true;
    }

    $pdo = null;

}
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
    <link href="search.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1 id="projectName">Search</h1>
    
    <a href="main.php"><button id="Homepage" name="Homepage" type="button">Return to Homepage</button></a><br/>
    
    <form method="GET">
            
            <nav class="main-nav">
                <div id="search">
                <ul>
                    <i class="fa fa-search-plus"></i><input name="searchbar" type="bar" placeholder="enter a book"><br>
                    <button id="searchbtn" name="search" type="submit">search</button>
                    <button id="cancelbtn" name="cancel" type="button">cancel</button>
                </ul>
            </nav>
        </div>    
    </form>
    <?php 
        //if submit is set
        if(isset($_GET['search'])){
            echo "<p id=results>"; 
            if($found == true){
                foreach ($resultArray as $value){
                    foreach ($value as $ID => $Name){
                        echo "<a href='bookpage.php?bookID=".$ID."'>".$Name."</a><br>";
                    }
                }    
            }
            else
                echo "Sorry No Results";
            echo "</p>";
        }
    ?>
</body>
</html>

