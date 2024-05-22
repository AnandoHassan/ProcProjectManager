<?php
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
    <?php
   $sql = "SELECT * FROM project";
   $result = mysqli_query($conn, $sql);
   
   // Check if there are any projects found
   if (!(mysqli_num_rows($result) > 0)) {
       echo "NO project found. <br> Click below to create a new project<br>";
       echo "<a href='admin.php'>New Project</a>";
   } else {
       // Initialize arrays to store task counts
       $p_t = array(); // Number of tasks for each project
       $p_t_c = array(); // Number of completed tasks for each project
   
       // Fetch task counts for each project
       $sql_nt = "SELECT project_id, count(id) FROM `task` GROUP BY project_id";
       $r_nt = mysqli_query($conn, $sql_nt);
       while ($row = mysqli_fetch_assoc($r_nt)) {
           $p_t[$row['project_id']] = $row['count(id)'];
           $p_t_c[$row['project_id']] = 0; // Initialize completed tasks count to zero
       }
   
       // Update completed tasks count
       $sql_ntc = "SELECT project_id, status FROM `task` ORDER BY project_id ASC";
       $r_ntc = mysqli_query($conn, $sql_ntc);
       while ($row = mysqli_fetch_assoc($r_ntc)) {
           if ($row['status'] === 'completed') {
               $p_t_c[$row['project_id']]++; // Increment completed tasks count
           }
       }
   
       // Update total percentage for each project
       foreach ($p_t as $project_id => $total_tasks) {
           if ($total_tasks != 0) {
               $u_tp = ($p_t_c[$project_id] / $total_tasks) * 100;
           } else {
               $u_tp = 0; // Handle division by zero error
           }
           $sqln = "UPDATE project SET total_percentage='{$u_tp}' WHERE id={$project_id}";
           mysqli_query($conn, $sqln);
       }
   }
   

    ?>
    
    <table>
        <tr>
            <th>Project_ID</th>
            <th>Project_NAME</th>
            <th>DECRIPTION</th>
            <th>TOTAL_PERCENTAGE (%)</th>
        </tr>
        <?php mysqli_data_seek($result, 0); 
        while($row=mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["decription"]; ?></td>
                <td><?php echo $row["total_percentage"]; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    
</body>
</html>