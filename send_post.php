<?php
include ("./inc/connect.inc.php");
session_start();
if(!isset($_SESSION["user_login"])){
    $username = "";
}
else{
    $username = $_SESSION['user_login'];
}

$post = $_POST['post'];
if($post !="") {
    $date_added = date("Y-m-d");
    $added_by = $username;
    $user_posted_to = "test123";
    
    $sqlCommand = "INSERT INTO posts VALUES('','$post','$date_added','$added_by','$user_posted_to')";
    $query = mysql_query($sqlCommand) or die (mysql_error());
    echo "Successfully posted...</br>";
}
else
{
    echo "You must enter something into the post field before you can send it...<br /><br />";
}

    //echo "GO back to profile...<a href='profile.php'>back</a>";
?>