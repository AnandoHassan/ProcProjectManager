<?php
session_start();
include("eheader.html");
var_dump($_SESSION);
?>

WELCOME employee - <?php echo " ". $_SESSION["e_id"] ?>
