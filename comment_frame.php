<?php
session_start();
if(!isset($_SESSION["user_login"])){
    $user = "";
}
else{
    $user = $_SESSION['user_login'];
}
?>

<style>
*{
    font-size: 12px;
    font-family: Arial, Helvetica, sans-serif;
.hr{
    height: 1px;
    background-color: #DCE5EE;
    border: 0px;
}
}
</style>

<?php
include("./inc/connect.inc.php");

$get_id = $_GET['id'];
?>

<script language="javascript">
 function toggle() {
  var ele = document.getElementById("toggleComment");
  var text = document.getElementById("displayComment");
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
    if(isset($_POST['postComment'.$get_id.''])) {
        
        $post_body = $_POST['post_body'];
        $posted_to = "avi343";
        $inserPost = mysql_query("INSERT INTO post_comments VALUES ('','$post_body','$user','$posted_to','0','$get_id')");
        echo "Comment Posted<p />";
    }
?>


<a href="javascript:;" onclick="javacsript:toggle()"><div style="float: right; display: inline;">Post Comment</div></a>
<div id='toggleComment' style="display: none">
<form action="comment_frame.php?id=<?php echo $get_id; ?>" method="POST" name="postComment<?php echo $get_id; ?>">
    Enter your comments below:<p />
    <textarea rows="2" cols="60" name="post_body"></textarea>
    <input type="submit" name="postComment<?php echo $get_id; ?>" value="Post Comment" />
</form>
</div>
<?php
//Get Relevant comments
$get_comments = mysql_query("SELECT * FROM post_comments WHERE post_id='$get_id' ORDER BY id DESC");
$count = mysql_num_rows($get_comments);
if($count != 0){
while($comment = mysql_fetch_assoc($get_comments)) {
            $comment_body = $comment['post_body'];
            $posted_to = $comment['posted_to'];
            $posted_by = $comment['posted_by'];
            $post_removed = $comment['post_removed'];
            
            echo "<b>$posted_by said : </b><br />".$comment_body."<hr /><br />";
}
}
else
{
    echo "<center><br /><br />No comments to display!</center>";
}
?>