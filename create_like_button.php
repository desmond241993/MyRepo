<?php
include("./inc/header.inc.php");
?>
<center>
<h2>Create Your Like Button</h2><hr />
<br />
<form action="create_like_button.php" method="POST">
    <input type="text" name="like_button_url" placeholder="Enter the url.." size="50" onclick="value=''">
    <input type="submit" name="create" value="create">
</form>
</center>
<?php
if(isset($_POST['like_button_url'])) {
    $like_button_url = strip_tags(@$_POST['like_button_url']);
    $username = $user;
    $date = date("Y-m-d");
    $uid = rand(96623065132, 999999999999999999999999999999999999999999999999999999999999999999999999999);
    $uid = md5($uid);
    
    $like_button_url2 = strstr($like_button_url, 'http://');
    
        //Check whether Like Button already exists in the database
        $b_check = mysql_query("SELECT page_url FROM like_buttons WHERE page_url='$like_button_url'");
        //count the number of rows returned
        $numrows_check = mysql_num_rows($b_check);
        if($numrows_check >= 1){
            echo "The page already exists in the database...";
    }
    else
    {
        if($like_button_url2) {
            $create_button = mysql_query("INSERT INTO like_buttons VALUES ('','$username','$like_button_url','$date','$user')");
            $insert_like = mysql_query("INSERT INTO likes VALUES ('','$username','0','$uid')");
        echo "
        <div style='width:400px; height:250px; border: 1px solid #CCCCCC'>
        &lt;iframe src='http://localhost/MySocialNetwork/like_but_frame.php?uid=$uid' style='border: 0px; height: 27px; width: 160;'&gt;
        &lt;/iframe&gt;
        </div>
        ";
        }
        else
        {
        $like_button_url = "http://".$like_button_url;
        $create_button = mysql_query("INSERT INTO like_buttons VALUES ('','$username','$like_button_url','$date','$uid')");
        $insert_like = mysql_query("INSERT INTO likes VALUES ('','$username','0','$uid')");
        echo "
        <div style='width:400px; height:250px; border: 1px solid #CCCCCC'>
        &lt;iframe src='http://localhost/MySocialNetwork/like_but_frame.php?uid=$uid' style='border: 0px; height: 27px; width: 160;'&gt;
        &lt;/iframe&gt;
        </div>
        ";
        }
    }
    
}
?>