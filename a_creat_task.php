<?php
session_start();
include("database.php");
//include("aheader.html");
 

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tasks</title>
</head>
<body>
<?php
    if (!isset($_POST['submit'])) { // Display the form only if the submit button has not been clicked
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Enter the number of tasks to create: <br>
        <input type="number" name="num_tasks" min="1" required><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
    }
    ?>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_tasks = filter_input(INPUT_POST, "num_tasks", FILTER_VALIDATE_INT);

    if ($num_tasks === false || $num_tasks <= 0) {
        echo "Please enter a valid number of tasks.";
    } else {
        for ($i = 0; $i < $num_tasks; $i++) {
?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                Enter Task ID for Task <?php echo $i + 1; ?>: <br>
                <input type="text" name="ids[]"><br>
                 Enter Project ID: 
                <input type="text" name="p_ids[]" value="<?php echo $_SESSION["project_id"];?>"><br> 
                Give Description for Task <?php echo $i + 1; ?>: <br>
                <textarea id="description" name="descriptions[]" rows="4" cols="50" placeholder="Enter your description here...">
                    
                </textarea><br>
                Enter Employee ID: <br>
                <select name="e_ids[]" multiple>
                 <?php
                   $sql = "SELECT id FROM employee";
                   $result = mysqli_query($conn, $sql);
                   while ($row = mysqli_fetch_assoc($result)) {
                   echo '<option value="' . $row['id'] . '">' . $row['id'] . '</option>';
                   }
                 ?>
</select>

<?php
   echo "<br><br>";
}
?>                
                <br><br>
                <input type="submit" name="submit_task" value="Submit Task ">
                <br><br>
            </form>
<?php
        
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_task"])) {
    $ids = array();
    $p_ids = array();
    $descriptions = array();
    $e_ids = array();

    foreach ($_POST["ids"] as $id) {
        $ids[] = $id;
    }
    foreach ($_POST["p_ids"] as $p_id) {
        $p_ids[] = $p_id;
    }
    foreach ($_POST["descriptions"] as $description) {
        $descriptions[] = $description;
    }
    foreach ($_POST["e_ids"] as $e_id) {
        $e_ids[] = $e_id;
    }
    
    $allFieldsFilled = true;

    // Check if any value is empty in any of the arrays
    foreach ($ids as $id) {
        if (empty($id)) {
            $allFieldsFilled = false;
            break; // Exit loop if any value is empty
        }
    }
    
    // Repeat the same check for other arrays
    foreach ($p_ids as $p_id) {
        if (empty($p_id)) {
            $allFieldsFilled = false;
            break;
        }
    }
    
    foreach ($descriptions as $description) {
        if (empty($description)) {
            $allFieldsFilled = false;
            break;
        }
    }
    
    foreach ($e_ids as $e_id) {
        if (empty($e_id)) {
            $allFieldsFilled = false;
            break;
        }
    }
    
    // Check if all fields are filled
    if (!$allFieldsFilled) {
        echo "Please fill in all fields for the Tasks.";
    } else {
        // Insert tasks into the database
        $maxCount = max(count($ids), count($p_ids), count($descriptions), count($e_ids)); // we know that every one will have 4 values

        for ($i = 0; $i < $maxCount; $i++) { // we can write 4 inted of max count
            // Initialize variables for each iteration
            $id = $ids[$i % count($ids)] ;  // again we can write 4 insted of using count since we know all will have 4 values
            $p_id = $p_ids[$i % count($p_ids)] ;
            $description = $descriptions[$i % count($descriptions)] ;
            $e_id = $e_ids[$i % count($e_ids)] ;

            $sql = "INSERT INTO task (id, project_id, decription, employee_id)  -- sry i wrote decription in database
                    VALUES ('$id', '$p_id', '$description', '$e_id')";
            mysqli_query($conn, $sql);
        }

       
       
        mysqli_close($conn);
        header("Location: a_done.php");
        
        }
        
    }
  

?>
