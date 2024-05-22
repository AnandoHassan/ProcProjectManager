<?php
session_start();
include("database.php");
            $id=$_SESSION["a_id"];
            $password=$_SESSION["a_password"];
            $email=$_SESSION["a_email"];
            $type=$_SESSION["a_type"];

    //$hash=password_hash($password,PASSWORD_DEFAULT);
    $sql="INSERT INTO logout (id,password,type,email) 
          VALUES ('$id', '$password','$type','$email') ";
  
    mysqli_query($conn,$sql);
   echo "you are logged out";
   session_destroy();
   header("Location: login.php");
?>

