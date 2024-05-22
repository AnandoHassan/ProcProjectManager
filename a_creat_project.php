<?php
session_start();
include("database.php");
include("aheader.html");
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> PROJECT</h1>
    <form action="<?php htmlspecialchars( $_SERVER["PHP_SELF"] )?>" method="post">
        Enter project id: <br>
        <input type="text" name="id"><br>
        Enter Project name: <br>
        <input type="text" name="name"><br>
        Give Description: <br>
       <textarea id="description" name="description" rows="4" cols="50" placeholder="Enter your description here...">
        
        </textarea> <br>
        <input type="submit" name="submit" value="submit">
    </form>
   
    
</body>
</html>

<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){

    
    $id= filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);
    $name= filter_input(INPUT_POST,"name",FILTER_SANITIZE_SPECIAL_CHARS);
    $description= filter_input(INPUT_POST,"description",FILTER_SANITIZE_SPECIAL_CHARS);

    $_SESSION["project_id"]=$id;

    if(empty($id)){
        echo"please enter projcect id";
    }
    elseif(empty($name)){
        echo"please enter project name";
    }
    elseif(empty($description)){
        echo"please enter a project description";
    }
    else{
           
            $sql="INSERT INTO project (id,name,decription) 
                  VALUES ('$id', '$name','$description') ";
            mysqli_query($conn,$sql);
           echo "project created";
           //sleep(10);
          
            header("Location: a_creat_task.php");
          
    }
    

 
}   
mysqli_close($conn);
?>
