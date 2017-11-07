<?php
include ("./inc/connect.inc.php");
session_start();
if(!isset($_SESSION["user_login"])){
    $user = "";
}
else{
    $user = $_SESSION['user_login'];
}
?>
<!doctype html>
    <html>
        <head>
            <title>FindFriends</title>
            <link rel="stylesheet" type="text/css" href="./css/style.css" media="screen"/>
        </head>
        <body>
            <?php
                $get_unread_query = mysql_query("SELECT opened FROM pvt_messages WHERE user_to='$user' && opened='no'");
                $get_unread = mysql_fetch_assoc($get_unread_query);
                $unread_numrows = mysql_numrows($get_unread_query);
                $unread_numrows = "(".$unread_numrows.")";
            ?>
            
            <div class="headerMenu">
                <div id="wrapper">
                    <div class="logo">
                        <img src="./img/custom.png"/>
                    </div>
                    
                        
                        <script>
                            function showHint(str) {
                                if (str.length == 0) { 
                                    document.getElementById("txtHint").innerHTML = "";
                                    return;
                                }
                                else {
                                        var xmlhttp = new XMLHttpRequest();
                                        xmlhttp.onreadystatechange = function() {
                                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                                        }
                                };
                                xmlhttp.open("GET", "getHint.php?q=" + str, true);
                                xmlhttp.send();
                                }
                            }
                        </script>                   
                        <?php
                            if($user){
                                echo "
                                <div class='search_box'>
                                    <form method='GET' id='search'>
                                        <input type='text' name='search' size='60' onkeyup='showHint(this.value)' placeholder='search ...' autocomplete='off'/>
                                    </form>
                                </div>
                                ";
                                
                               echo '<div id="menu"><a href="'.$user.'">'.$user.'</a>
                                <a href="friend_requests.php">Friend Requests</a>
                                <a href="account_settings.php">Acount Settings</a>
                                <a href="my_messages.php">My Messages'.$unread_numrows.'</a>
                                <a href="my_pokes.php">Pokes</a>
                                <a href="logout.php">Logout</a></div>';
                            }
                            else{
                                echo '<div id="menu"><a href="index.php">Sign Up</a>
                                <a href="index.php">Login</a></div>';
                            }
                        ?>
                    
                </div>
            </div>