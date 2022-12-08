<?php 

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Page</title>
    <link href="upload.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1>Upload a book</h1>
    <form id="book-form" action="" method="POST" enctype="multipart/form-data">
        <label>Select book icon: <input id="book-icon" type="file" name="book-icon"></label><br>
        <label>Select book file: <input id="book-file" type="file" name="book-file"></label><br>
        <label>Book title: <input id="book-title" type="text" name="title" ></label><br>
        <label>Book author: <input id="book-author" type="text" name="author" ></label><br>
        <label>Publisher: <input id="publisher" type="text" name="publisher" ></label><br>
        <label>ISBN: <input id="isbn" type="text" name="isbn" ></label><br>
        <label>Price: <input id="isbn" type="text" name="price" ></label><br>
        <label>Summary: <textarea id="summary" type="text area" name="summary" ></textarea></label><br>
        <input id="submitbtn" type="submit" name="submit" value="upload">
        <input id="cancelbtn" type="reset" name="reset" value="cancel">
    </form>
</body>
</html>

<?php
function uploadFile($dir, $type)
{
    $target_dir = $dir."/";
    $target_file = $target_dir.basename($_FILES[$type]["name"]);
    $uploadOk = 1;
 
    // Check if file was uploaded without errors
    if(isset($_FILES[$type]) && 
        $_FILES[$type]["error"] == 0) {
        $allowed_ext = array("jpg" => "image/jpg",
                            "jpeg" => "image/jpeg",
                            "gif" => "image/gif",
                            "png" => "image/png",
                            "pdf" => "application/pdf");
        $file_name = $_FILES[$type]["name"];
        $file_type = $_FILES[$type]["type"];
        $file_size = $_FILES[$type]["size"];
      
        // Verify file extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
  
        if (!array_key_exists($ext, $allowed_ext)) {
            die("Error: Please select a valid file format.");
        }    
              
        // Verify file size - 2MB max
        $maxsize = 2 * 1024 * 1024;
          
        if ($file_size > $maxsize) {
            die("Error: File size is larger than the allowed limit.");
        }                    
      
        // Verify MYME type of the file
        if (in_array($file_type, $allowed_ext))
        {
            // Check whether file exists before uploading it
            if (file_exists($dir."/" . $_FILES[$type]["name"])) {
                echo $_FILES[$type]["name"]." is already exists.";
            }        
            else {
                if (move_uploaded_file($_FILES[$type]["tmp_name"], 
                  $target_file)) {
                    echo "The file ".  $_FILES[$type]["name"]. 
                      " has been uploaded.";
                } 
                else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        else {
            echo "Error: Please try again.";
        }
    }
    else {
        echo "Error: ". $_FILES[$type]["error"];
    }
}    

//if submit button isset 
if(isset($_POST['submit'])){
    uploadFile("icons","book-icon"); 
    uploadFile("pdf","book-file"); 
   
    //connect to database
    require_once("config.php");

    //get all data from the form
    $file = $_FILES["book-file"]["name"];
    $icon = $_FILES["book-icon"]["name"];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $isbn = $_POST['isbn'];
    $price = $_POST['price'];
    $summary = $_POST['summary'];


    //table name
    $TableName = "books";

    //generate insert query
    $sql = "INSERT INTO $TableName VALUES(NULL, :fi, :ic, :title, :auth, :pub, :isbn, :price, :summ)";
    $result = $pdo->prepare($sql);
    $result->execute(array(":fi"=>$file, ":ic"=>$icon, ":title"=>$title, ":auth"=>$author, ":pub"=>$publisher, ":isbn"=>$isbn, ":price"=>$price, ":summ"=>$summary));
    
    //close connection
    $pdo = null;
}
?>