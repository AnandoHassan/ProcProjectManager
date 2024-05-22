<?php
 $db_server="localhost";
 $db_user="root";
 $db_pass="";
 $db_name="project_managment";
 $conn=""; // connection variable
 
 
 try{
    $conn= mysqli_connect($db_server,$db_user,$db_pass,$db_name); 
 }
 
catch(mysqli_sql_exception){ // name of the exception
   echo"could not connect <br>";
}
?>