<?php include ("./inc/header.inc.php"); ?>
<?php
if(isset($_GET['u'])){
    $username = mysql_real_escape_string($_GET['u']);
    if(ctype_alnum($username)){
        //check user exists
        $check = mysql_query("SELECT username,first_name FROM users WHERE username = '$username'");
        if(mysql_num_rows($check)==1){
            $get = mysql_fetch_assoc($check);
            $username = $get['username'];
            $firstname = $get['first_name'];
        }
        else{
            echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/MySocialNetwork/index.php\">";
            exit();
        }
    }
}
    $post = @$_POST['post'];
    if($post !="") {
    $date_added = date("Y-m-d");
    $added_by = $user;
    $user_posted_to = $username;
    
    $sqlCommand = "INSERT INTO posts VALUES('','$post','$date_added','$added_by','$user_posted_to')";
    $query = mysql_query($sqlCommand) or die (mysql_error());
    //echo "Successfully posted...</br>";
    }

//Check whether the user has uploaded a profile pic or not
    $check_pic = mysql_query("SELECT profile_pic FROM users WHERE username='$username'");
    $get_pic_row = mysql_fetch_assoc($check_pic);
    $profile_pic_db = $get_pic_row['profile_pic'];
    if($profile_pic_db == "")
    {
        $profile_pic = "img/default.png";
    }
    else
    {
        $profile_pic = "userdata/profile_pics/".$profile_pic_db;
    }
    
?>
<div class="postF">
    <div class="postForm">
        <form action="<?php echo $username; ?>" method="POST">
            <textarea id="post" name="post" rows="5" cols="85" title="whats on your mind <?php echo $username; ?>?" placeholder="whats on your mind <?php echo $username; ?>?"></textarea>
            <input type="submit" name="send" value="Post" style="background-color: #DCE5EE; float: right; border: 1px solid blue; color:#666; height: 35px; width: 75; margin-top: 35px;"/>
        </form>
    </div>
    <div class="profilePosts">
        <?php
        $getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10") or die(mysql_error());
        while ($row =mysql_fetch_assoc($getposts)){
            $id = $row['id'];
            $body = $row['body'];
            $date_added = $row['date_added'];
            $added_by = $row['added_by'];
            $user_posted_to = $row['user_posted_to'];
            
            $get_user_info = mysql_query("SELECT * FROM users WHERE username='$added_by'");
            $get_info = mysql_fetch_assoc($get_user_info);
            $profile_pic_info = $get_info['profile_pic'];
            if ($profile_pic_info == "") {
                $profile_pic_info = "./img/default.png";
            }
            else
            {
                $profile_pic_info = "./userdata/profile_pics/".$profile_pic_info;
            }
            
            echo "<hr />
            <div style='float: left;'>
                <img src='$profile_pic_info' height='50'>
            </div><br /><br />
            <div class='posted_by'>
            Posted by:
            <a href='$added_by'>$added_by</a> on $date_added - </div>
            &nbsp;&nbsp;$body<br /><br /><hr />
            ";
        }
        
        if(isset($_POST['sendmsg'])) {
            header("location: send_msg.php?u=$username");
        }
        
            $errorMsg = "";
            if(isset($_POST['addfriend'])) {
                $friend_request = $_POST['addfriend'];
                
                $user_to = $user;
                $user_from = $username;
                
                if($user_to == $username) {
                    $errorMsg = "You can't send a friend request to yourself <br />";
                }
                else
                {
                    $create_request = mysql_query("INSERT INTO friend_requests VALUES ('','$user_to','$user_from')");
                    $errorMsg = "Your friend request has been sent";
                }
            }
        ?>
        
    </div>
</div>
<p>Suggestions: <span id='txtHint'></span></p>
<div class="leftPane">
    <div class="profilePic"><img src="<?php echo $profile_pic; ?>" height="250" width="250" title="<?php echo $username; ?>'s Profile" /></div>
    <br />
    <?php echo $errorMsg;
    ?>
    <form action="<?php echo $username; ?>" method="POST">
        <?php
            $addAsFriend = "";
            $friendArray = "";
            $countFriends = 0;
            $friendArray12 = "";
            $selectFriendsQuery = mysql_query("SELECT friend_array FROM users WHERE username='$username'");
            $friendRow = mysql_fetch_assoc($selectFriendsQuery);
            $friendArray = $friendRow['friend_array'];
            if($friendArray != "")
            {
                $friendArray = explode(",",$friendArray);
                $countFriends = count($friendArray);
                $friendArray12 = array_slice($friendArray,0,12);
            $i=0;
            if(in_array($user,$friendArray)) {
                $addAsFriend = '<input type="submit" name="removefriend" value="Remove Friend">';
            }
            else
            {
                $addAsFriend = '<input type="submit" name="addfriend" value="Add as Friend">';
            }
            echo $addAsFriend;
            }
            else
            {
                $addAsFriend = '<input type="submit" name="addfriend" value="Add as Friend">';
                echo $addAsFriend;
            }
            if(@$_POST['removefriend']) {
                //Friend array for logged in user
                $add_friend_check = mysql_query("SELECT friend_array FROM users WHERE username='$user'");
                $get_friend_row = mysql_fetch_assoc($add_friend_check);
                $friend_array = $get_friend_row['friend_array'];
                $friend_arry_explode = explode(",",$friend_array);
                $friend_array_count = count($friend_arry_explode);
                
                //Friend array for logged in user who owns the profile
                $add_friend_check_username = mysql_query("SELECT friend_array FROM users WHERE username='$username'");
                $get_friend_row_username = mysql_fetch_assoc($add_friend_check_username);
                $friend_array_username = $get_friend_row_username['friend_array'];
                $friend_arry_explode_username = explode(",",$friend_array_username);
                $friend_array_count_username = count($friend_arry_explode_username);
                
                $usernameComma = ",".$username;
                $usernameComma2 = $username.",";
                
                $userComma = ",".$user;
                $userComma2 = $user.",";
                
                if(strstr($friend_array,$usernameComma)) {
                    $friend1 = str_replace("$usernameComma","",$friend_array); 
                }
                else if(strstr($friend_array,$usernameComma2)) {
                    $friend1 = str_replace("$usernameComma2","",$friend_array); 
                }
                else if(strstr($friend_array,$username)) {
                    $friend1 = str_replace("$username","",$friend_array); 
                }
                
                //Remove logged in user from other person's friend array
                if(strstr($friend_array,$userComma)) {
                    $friend2 = str_replace("$userComma","",$friend_array); 
                }
                else if(strstr($friend_array,$userComma2)) {
                    $friend2 = str_replace("$userComma2","",$friend_array); 
                }
                else if(strstr($friend_array,$user)) {
                    $friend2 = str_replace("$user","",$friend_array); 
                }
                
                $removeFriendQuery = mysql_query("UPDATE users SET friend_array='$friend1' WHERE username='$user'");
                $removeFriendQuery_username = mysql_query("UPDATE users SET friend_array='$friend2' WHERE username='$username'");
                echo "Friend Removed...";
                header("location: $username");
            }
            
            $poke_msg = "";
            if(@$_POST['poke']) {
                $check_if_poked = mysql_query("SELECT * FROM pokes where user_to='$username' && user_from='$user'");
                $num_poke_found = mysql_num_rows($check_if_poked);
                if($num_poke_found == 1) {
                    echo "You must wait to be poked back.";
                }
                else
                {
                if($username == $user) {
                    $poke_msg =  "You cannot poke yourself";
                }
                else{
                $poke_user = mysql_query("INSERT INTO pokes VALUES ('','$user','$username')");
                $poke_msg =  "$username has been poked.";
                }
                }
            }
            //Create like button if it doesn't already exist
            $check_like_button = mysql_query("SELECT * FROM like_buttons WHERE uid='$username'");
            $check_like_numrows = mysql_num_rows($check_like_button);
            if($check_like_numrows >= 1) {
                //do nothing
            }
            else
            {
            $date = date('Y-m-d');
            $create_like = mysql_query("INSERT INTO like_buttons VALUES ('','$username','http://localhost/MySocialNetwork/$username','$date','$username')");
            $insert_like = mysql_query("INSERT INTO likes VALUES ('','$username','0','$username')");
            }
        ?>
        
        <input type="submit" name="poke" value="Poke" style="margin-left: 12px;"/>
        <input type="submit" name="sendmsg" value="Send Message" style="margin-left: 12px;"/>
        <iframe src='http://localhost/MySocialNetwork/like_but_frame.php?uid=<?php echo $username; ?>' style='border: 0px; height: 27px; width: 160px; margin-top: 5px; padding-left: 100px;'> </iframe>
    </form>
        
     <?php echo $poke_msg; ?>
    <br />
    <div class="textHeader"><p id="profile_name"><?php echo $username; ?>'s Profile</p></div>
    <div class="profileLeftSideContent">
        <?php
            $about_query = mysql_query("SELECT bio FROM users WHERE username='$username'");
            $get_result = mysql_fetch_assoc($about_query);
            $about_the_user = $get_result['bio'];
            
            echo $about_the_user;
        ?>
    </div>
    <div class="textHeader"><p id="profile_name"><?php echo $username ?>'s Friends(<?php echo $countFriends; ?>)</p></div>
    <div class="profileLeftSideContent">
        <?php
            if($countFriends != 0 ) {
                foreach($friendArray12 as $key => $value)
                {
                    $i++;
                    $getFriendQuery = mysql_query("SELECT * FROM users WHERE username='$value' LIMIT 1");
                    $getFriendRow = mysql_fetch_assoc($getFriendQuery);
                    $friendUserName = $getFriendRow['username'];
                    $friendProfilePic = $getFriendRow['profile_pic'];
                    
                    if($friendProfilePic == "")
                    {
                        echo "<a href='$friendUserName'><img src='img/default.png' title='$friendUserName' heigh='60' width='60' style='padding: 3px'></a>";
                    }
                    else
                    {
                        echo "<a href='$friendUserName'><img src='userdata/profile_pics/$friendProfilePic' title='$friendUserName' heigh='60' width='60' style='padding: 3px'></a>";
                    }
                }
            }
            else
            {
                echo $username.' has no friends';
            }
        ?>
    
</div>
