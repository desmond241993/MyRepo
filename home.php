<?php include ("./inc/header.inc.php"); ?>

<?php
if(!isset($_SESSION["user_login"])) {
    echo  "<meta http-equiv=\"refresh\" content=\"0; url=home.php>";
}
else
{
    echo "";
}
?>
<br />
<div class="newsFeed">   
<h2 style="text-align: center;">Your Newsfeed</h2>
</div>
<br />
<?php
//If the user is logged in
$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$user' ORDER BY id DESC LIMIT 10");
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
            
            ?>
            <script language="javascript">
 function toggle<?php echo $id; ?>() {
  var ele = document.getElementById("toggleComment<?php echo $id; ?>");
  var text = document.getElementById("displayComment<?php echo $id; ?>");
  if (ele.style.display == "block") {
   ele.style.display = "none";
   text.innerHTML = "show";
  }
  else
  {
   ele.style.display = "block";
  }
 }
 </script>
            <?php
            echo "
            <div class='newsFeedPost'>
            <div class='newsFeedPostOptions'>
            <a href='#' onclick='javascript:toggle$id()'><p style='float: right;'>Show Comments</p></a>
            </div>
            <div style='float: left;margin-left: 10px;'>
                <img src='$profile_pic_info' height='50'>
            </div>
            <div class='posted_by'>
            Posted by:
            <a href='$added_by'>$added_by</a> on $date_added - </div>
            <br /><br />
            <div style='max-width: 600px; background-color:#FFFFFF'>$body<br /><br /><p /><p />
            </div>
            <div id='toggleComment$id' style='display: none;'>
            <iframe src='./comment_frame.php?id=$id' frameborder='0' style='height:auto; width:100%; min-height: 10px; max-height: 150px;'></iframe>
            </div>
            <p /><br />
            </div><br />
            ";
        
}
?>