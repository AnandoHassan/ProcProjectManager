<?php
session_start();
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log in</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <div class="imgcontainer">
     <img src="https://tse4.mm.bing.net/th?id=OIP.z4no5tqp2ryBdMMD5NU9OgHaEv&pid=Api&P=0&h=220" alt="avatar"  class="avatar" >
     </div><br>
     ID: <br>
     <input type="text" name="id"> <br>
     password: <br>
     <input type="password" name="password"><br>
     e-mail: <br>
     <input type="text" name="email"> <br>
     Acount type: <br>
     <select name="type">
        <option value="admin"> admin </option>
       
        <option value="employee"> employee </option>
     </select>
     <input type="submit" name="submit" value="login">

    </form>
</body>
</html>
<?php
 

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $id= filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);
    $password= filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
    $email= filter_input(INPUT_POST,"email",FILTER_SANITIZE_SPECIAL_CHARS);
    $type=$_POST["type"];
 
    
    if(empty($id)){
        echo"please enter a id";
    }
    elseif(empty($password)){
        echo"please enter a password";
    }
    elseif(empty($email)){
        echo"please enter a email";
    }
    else{
        $sqln="SELECT * FROM {$type} WHERE id = {$id}";  // AND password =$password AND email = $emial
        $result=mysqli_query($conn,$sqln);
        if(mysqli_num_rows($result)>0){
            //$hash=password_hash($password,PASSWORD_DEFAULT);
            $sql="INSERT INTO login (id,password,type,email) 
                  VALUES ('$id', '$password','$type','$email') ";
          
            mysqli_query($conn,$sql);
           echo "you are logged in";
          // sleep(5);
         
          if($type == "employee"){
            $_SESSION["e_id"]=$id;
            $_SESSION["e_password"]=$password;
            $_SESSION["e_email"]=$email;
            $_SESSION["e_type"]=$type;
            header("Location: employee.php");
            
          }
          else{
            $_SESSION["a_id"]=$id;
            $_SESSION["a_password"]=$password;
            $_SESSION["a_email"]=$email;
            $_SESSION["a_type"]=$type;
            header("Location: admin.php");
          }
          
        }
        else{

            echo"id does not exist<br>";

            echo "click below to register <br>";
           echo "<a href='register.php'>register</a>";

      
            //if($type="empolyee")
            //echo"send request to register....";


        }
       
          
    }

}   
mysqli_close($conn);
?>
