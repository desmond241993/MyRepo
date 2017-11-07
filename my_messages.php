<?php include("./inc/header.inc.php");?>

<?php
 echo "<h2>My Unread Messages</h2>";
//Grab the messages for the logged in user
$grab_messages = mysql_query("SELECT * FROM pvt_messages WHERE user_to='$user' && opened = 'no' && deleted='no'");
$numrows = mysql_numrows($grab_messages);
if($numrows != 0) {
while($get_msg = mysql_fetch_assoc($grab_messages)) {
    $id = $get_msg['id'];
    $user_from = $get_msg['user_from'];
    $user_to = $get_msg['user_to'];
    $msg_title = $get_msg['msg_title'];
    $msg_body = $get_msg['msg_body'];
    $date = $get_msg['date'];
    $opened = $get_msg['opened'];
    $deleted = $get_msg['deleted'];
 ?>   
    <script language="javascript">
 function toggle<?php echo $id; ?>() {
  var ele = document.getElementById("toggleText<?php echo $id; ?>");
  var text = document.getElementById("displayText<?php echo $id; ?>");
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
    if(strlen($msg_title) > 50) {
        $msg_title = substr($msg_title, 0, 50)."...";
    }
    else
    {
        $msg_title = $msg_title;
    }
    
    if(strlen($msg_body) > 150) {
        $msg_body = substr($msg_body, 0, 150)."...";
    }
    else
    {
        $msg_body = $msg_body;
    }
    
    if(@$_POST['setopened_' . $id .'']) {
         //echo "This is a test";
         //Update the private message table
         $setopened_query = mysql_query("UPDATE pvt_messages SET opened='yes' WHERE msg_title='$msg_title'");
        }
    
    echo "
    <form action='my_messages.php' method='POST' name='$msg_title'>
      <div class='posted_by'><a href='$user_from'>$user_from</a> -- $date </div> --
      <input type='button' name='openmsg' value='$msg_title' onClick='javascript:toggle$id();'>
      <input type='submit' name='setopened_$id' value=\"I've read this\">
    </form><br />
    <div id='toggleText$id' style='display: none;'>
      <b>message</b>--$msg_body
    </div>
    <hr />.<br/ >
    ";
}
}
else
{
    echo "You have no new message";
}

?>

<?php
 echo "<h2>My Read Messages</h2>";
//Grab the messages for the logged in user
$grab_messages = mysql_query("SELECT * FROM pvt_messages WHERE user_to='$user' && opened = 'yes' && deleted='no'");
$numrows_read = mysql_numrows($grab_messages);
if($numrows_read != 0) {
while($get_msg = mysql_fetch_assoc($grab_messages)) {
    $id = $get_msg['id'];
    $user_from = $get_msg['user_from'];
    $user_to = $get_msg['user_to'];
    $msg_title = $get_msg['msg_title'];
    $msg_body = $get_msg['msg_body'];
    $date = $get_msg['date'];
    $opened = $get_msg['opened'];
    $deleted = $get_msg['deleted'];
    
    ?>   
    <script language="javascript">
 function toggle<?php echo $id; ?>() {
  var ele = document.getElementById("toggleText<?php echo $id; ?>");
  var text = document.getElementById("displayText<?php echo $id; ?>");
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
    
    if(strlen($msg_title) > 50) {
        $msg_title = substr($msg_title, 0, 50)."...";
    }
    else
    {
        $msg_title = $msg_title;
    }
    
    if(strlen($msg_body) > 150) {
        $msg_body = substr($msg_body, 0, 150)."...";
    }
    else
    {
        $msg_body = $msg_body;
    }
    
    if(@$_POST['delete_'. $id .'']) {
     //echo "Deleted";
     $delete_msg_query = mysql_query("UPDATE pvt_messages SET deleted='yes' where id='$id'");
    }
    if(@$_POST['reply_'. $id .'']) {
     header("location: msg_reply.php?u=$user_from");
     echo "<meta http-equiv=\"refresh\" content=\"0; url=msg_reply.php?u=$user_from\">";
    }
    echo "
    <form action='my_messages.php' method='POST' name='$msg_title'>
      <div class='posted_by'><a href='$user_from'>$user_from</a> -- $date </div> --
      <input type='button' name='openmsg' value='$msg_title' onClick='javascript:toggle$id();'>
      <input type='submit' name='delete_$id' value=\"X\" title='delete'>
      <input type='submit' name='reply_$id' value=\"Reply\">
    </form><br />
    <div id='toggleText$id' style='display: none;'>
      <b>message</b>--$msg_body
    </div>
    <hr />.<br/ >
    ";
}
}
else
{
    echo "You haven't read any messages yet";
}

?>
