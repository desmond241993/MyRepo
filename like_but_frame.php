<link rel="stylesheet" type="text/css" href="./css/style.css">

<?php
    include("./inc/connect.inc.php");
    session_start();
    if(!isset($_SESSION["user_login"])){
        $user = "";
    }
    else{
        $user = $_SESSION['user_login'];
    }

    $id = "";
    if(isset($_GET['uid'])){
    $uid = mysql_real_escape_string($_GET['uid']);
    if(ctype_alnum($uid)){
        $get_likes = mysql_query("SELECT * FROM likes WHERE uid='$uid'");
        if(mysql_num_rows($get_likes)==1){
            $get = mysql_fetch_assoc($get_likes);
            $uid = $get['uid'];
            $total_likes = $get['total_likes'];
            
        }
        else
        {
            die("Error!...");
        }
        if(isset($_POST['likebutton_'])) {
            $total_likes = $total_likes + 1;
            $like = mysql_query("UPDATE likes SET total_likes='$total_likes' WHERE uid='$uid'");
            $user_likes = mysql_query("INSERT INTO user_likes VALUES ('','$user','$uid')");
            header("location: like_but_frame.php?uid=$uid");
        }
        if(isset($_POST['unlikebutton_'])) {
            $total_likes = $total_likes - 1;
            $like = mysql_query("UPDATE likes SET total_likes='$total_likes' WHERE uid='$uid'");
            $remove_likes = mysql_query("DELETE FROM user_likes WHERE uid='$uid' and username='$user'");
            header("location: like_but_frame.php?uid=$uid");
        }
    }
    }
    //Check for previous likes
    $check_for_likes = mysql_query("SELECT * FROM user_likes WHERE username='$user' && uid='$uid'");
    $numrows_likes = mysql_num_rows($check_for_likes);
    if($numrows_likes >= 1) {
        echo '
            <form action="like_but_frame.php?uid='.$uid.'" method="POST">
            <input type="submit" name="unlikebutton_'.$id.'" value="Unlike" />
            <div style="display: inline;">
            '.$total_likes.' likes
            </div>
            </form>
            ';
    }
    else if($numrows_likes == 0) {
        echo '
            <form action="like_but_frame.php?uid='.$uid.'" method="POST">
            <input type="submit" name="likebutton_'.$id.'" value="Like" />
            <div style="display: inline;">
            '.$total_likes.' likes
            </div>
            </form>
            ';
}
?>