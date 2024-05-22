<?php
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
     <img src="https://tse4.mm.bing.net/th?id=OIP.z4no5tqp2ryBdMMD5NU9OgHaEv&pid=Api&P=0&h=220" alt="log in"> <br>
     ID: <br>
     <input type="text" name="id"> <br>
     Name: <br>
     <input type="text" name="name"><br>
     password: <br>
     <input type="password" name="password"><br>
     e-mail: <br>
     <input type="text" name="email"> <br>
     Acount type: <br>
     <select name="type">
        <option value="admin"> admin </option>
       
        <option value="employee"> employee </option>
     </select>
     <input type="submit" name="submit" value="register">

    </form>
</body>
</html>
<?php
 

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $id= filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);
    $name= filter_input(INPUT_POST,"name",FILTER_SANITIZE_SPECIAL_CHARS);
    $password= filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
    $email= filter_input(INPUT_POST,"email",FILTER_SANITIZE_SPECIAL_CHARS);
    $type=$_POST["type"];
 
    
    if(empty($id)){
        echo"please enter a id";
    }
    elseif(empty($name)){
        echo"please enter a name";
    }
    elseif(empty($password)){
        echo"please enter a password";
    }
    elseif(empty($email)){
        echo"please enter a email";
    }
    else{
        $sqln="SELECT * FROM {$type} WHERE id = {$id}";
        $result=mysqli_query($conn,$sqln);
   
        if(mysqli_num_rows($result)>0){
            echo"your already registered <br>";
            
          
        }
        else{

            $hash=password_hash($password,PASSWORD_DEFAULT);
            $sql="INSERT INTO {$type} (id,name,password,email) 
                  VALUES ('$id', '$name','$hash','$email') ";
          
            mysqli_query($conn,$sql);
           echo "you are registered";
           sleep(10);
         
        
            header("Location: login.php");
          
        

            //if($type="empolyee")
            //echo"send request to register....";


        }
       
          
    }

}   
mysqli_close($conn);
?>
