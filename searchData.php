<?php
include("./inc/connect.inc.php");

$search = mysql_query("SELECT username FROM users ORDER By ASC");
$search_row = mysql_fetch_assoc($search);

$count = 0;
while($search_row) {
    $database_users = $search_row["username"];echo $database_users;
    
}
?>