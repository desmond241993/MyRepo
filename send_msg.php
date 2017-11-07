<?php include("./inc/header.inc.php")?>
<?php
if(isset($_GET['u'])){
    $username = mysql_real_escape_string($_GET['u']);
    if(ctype_alnum($username)){
        //check user exists
        $check = mysql_query("SELECT username FROM users WHERE username = '$username'");
        if(mysql_num_rows($check)==1){
            $get = mysql_fetch_assoc($check);
            $username = $get['username'];
            
            //Check user isn't sending themself a private message
            if($username != $user) {
                if(isset($_POST['submit'])) {
                    $msg_title = strip_tags(@$_POST['msg_title']);
                    $msg_body = strip_tags(@$_POST['msg_body']);
                    $date = date("Y-m-d");
                    $opened = "no";
                    $deleted = "no";
                    
                    if($msg_title == "" || $msg_title == "enter a title")
                    {
                        echo "Please enter a title";   
                    }
                    else if(strlen($msg_title) <= 3)
                    {
                        echo "Your message title cannot be less than 3 characters in length!";   
                    }
                    else if($msg_body == "enter a message" || $msg_body == "") {
                        echo "Please write a message";
                    }
                    else if(strlen($msg_body) <3 )
                    {
                        echo "Your message cannot be less than 3 characters in length!";
                    }
                    else
                    {
                    $send_msg = mysql_query("INSERT INTO pvt_messages VALUES ('','$user','$username','$msg_title','$msg_body','$date','$opened','$deleted')");
                    echo "Your message has been sent";
                    }
                }
                echo "
                <center>
                <form action='send_msg.php?u=$username' method='POST'>
                    <h2>Compose a Message : ($user)</h2>
                    <input type='text' name='msg_title' size='30' onClick=\"value=''\" placeholder='enter a title'/><br /><br />
                    <textarea name='msg_body' cols='80' rows='15' title='enter a message for $username' placeholder='enter a message'></textarea><br />
                    <input type='submit' name='submit' value='Send Message'>
                </form>
                </center>
                ";
            }
            else
            {
                header("location: $user");
            }
        }
    }
}
?>