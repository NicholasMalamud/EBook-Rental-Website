<?php

session_start();

//echo session_id();

function fullescape($in)
{
  $out = '';
  for ($i=0;$i<strlen($in);$i++)
  {
    $hex = dechex(ord($in[$i]));
    if ($hex=='')
       $out = $out.urlencode($in[$i]);
    else
       $out = $out .'%'.((strlen($hex)==1) ? ('0'.strtoupper($hex)):(strtoupper($hex)));
  }
  $out = str_replace('+','%20',$out);
  $out = str_replace('_','%5F',$out);
  $out = str_replace('.','%2E',$out);
  $out = str_replace('-','%2D',$out);
  return $out;
}

$resultArray = [];
$found = false;

if(isset($_SESSION["userID"]))
{
  //echo "\n".$_SESSION["userID"];
  
  //connect to database
  require_once("config.php");

  //table name in database
  $TableName = "orders";

  //form sql select query
  $sql = "SELECT * FROM $TableName 
          WHERE user = :userID";

  //store result of prepare statement
  $result = $pdo->prepare($sql);
  //execute prepared statement
  $result->execute(array(":userID"=>$_SESSION["userID"]));
  
  $found = false;

  //loop through results to find all books that the user owns
  echo "<p id=results>";
  while($row = $result->fetch()){
      //get book info
      $bookID = $row['book'];
      $TableName = "books";

      //form sql select query
      $sql = "SELECT * FROM $TableName 
              WHERE bookID = :bookID";
    
      //store result of prepare statement
      $result2 = $pdo->prepare($sql);
      //execute prepared statement
      $result2->execute(array(":bookID"=>$bookID));
      
      $row2 = $result2->fetch();
      $pdfPath = $row2['pdfPath'];
      $title = $row2['title'];
      $resultArray[] = array($pdfPath => $title);
      $found = true;
  }

  $pdo = null;

}
else
  echo "\nuserID not saved";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main.css">
    <title>Main Page of E-Book Rental</title>
</head>
<body><h1>Home</h1></body>
<body>
  <p>
      <label><a href = "dashboard.php"> <input id ="dashboard" type ="button" name = "dashboard" value = "dashboard" ></a></label>
      <label><a href = "upload.php">  <input id = "upload" type ="button" name = "upload" value = "upload" ></a></label>
     <a href = "search.php"> <input id = "search" type ="button" name = "upload" value = "search" ></a> 
  </p>
</body>
<body id="caption"> <h2> Welcome to E-Book Rental</h2></body>
<?php 
  echo "<p id=results>"; 
    if($found == true){
      foreach ($resultArray as $value){
        foreach ($value as $Path => $Name){
          echo "<a href='pdf/".fullescape($Path)."'>".$Name."</a><br>";
        }
      }    
    }
    else
      echo "You Don't Own Any Books";
  echo "</p>"
?>
<body id="caption"> We provide a e-book service for others.</body>
<!-- <img id = "logo" src="images/ebook_logo.jpg" alt = "logo" width="300" height = "445.5"> -->
</html>