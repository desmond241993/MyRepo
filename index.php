<?php include ("./inc/header.inc.php"); ?>
<?php
$reg = @$_POST['reg'];
//declaring variables to prevant errors
$fn = ""; //First Name
$ln = ""; //Last Name
$un = ""; //Username
$em = ""; //Email
$em2 = ""; //Email2
$pswd = ""; //Password
$pswd2 = ""; //Password2
$d = ""; //Sign up Date
$u_check = ""; //Check if username exists
//registration form
$fn = strip_tags(@$_POST['fname']);
$ln = strip_tags(@$_POST['lname']);
$un = strip_tags(@$_POST['username']);
$em = strip_tags(@$_POST['email']);
$em2 = strip_tags(@$_POST['email2']);
$pswd = strip_tags(@$_POST['password']);
$pswd2 = strip_tags(@$_POST['password2']);
$d = date("Y-m-d"); //YEAR-MONTH-DAY

if ($reg) {
    if($em==$em2) {
        //Check if user already exists
        $u_check = mysql_query("SELECT username FROM users WHERE username='$un'");
        //Count the amount of rows where username=$un
        $check = mysql_num_rows($u_check);
        //Check whether Email already exists in the database
        $e_check = mysql_query("SELECT email FROM users WHERE email='$em'");
        //count the number of rows returned
        $email_check = mysql_num_rows($e_check);
        if($check == 0 ){
            if($email_check == 0) {
        //check all of the fields have been filled in
        if($fn && $ln && $un && $em && $em2 && $pswd && $pswd2) {
            //check that passwords match
            if($pswd == $pswd2) {
                //check the maximum length of username/firstname/lastname does not exceed 25 characters
                if(strlen($un)>25 || strlen($fn)>25 || strlen($ln)>25) {
                    echo "The maximum limit for username/firstname/lastname is 25 characters!";
                }
                else
                {
                    //check the maximum length of password does not exceed 30 characters and is not less than 5 characers
                    if(strlen($pswd)>30 || strlen($pswd)<5){
                        echo "Your password must be between 5 and 30 characters long!";
                    }
                    else{
                        //encrypt password and password2 using md5 before sending to database
                        $pswd = md5($pswd);
                        $pswd2 = md5($pswd2);
                        $query = mysql_query("INSERT INTO users VALUES ('','$un','$fn','$ln','$em','$pswd','$d','0','Write something about yourself','','','no')");
                        die("<h2>WELCOME to findFriends</h2>Login to your account to get started ...");
                    }
                }
            }
            else
            {
                echo "Your passwords don't match!";
            }
        }
        else
        {
            echo "Please fill in all the fields";
        }
        }
        else
        {
            echo "Sorry, but it looks like someone has already used that email!";
        }
        }
        else
        {
           echo "Username already taken ..."; 
        }
    }
    else
    {
        echo "Your e-mails don't match!";
    }
}

        //User login Code
        
        if(isset($_POST["user_login"]) && isset($_POST["password_login"])){
            $user_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["user_login"]); //filter everything but numbers and letters
           // echo "$user_login"."\n";
            $password_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password_login"]); //filter everything but numbers and letters
            //echo "$password_login";
            $password_login_md5 = md5($password_login);
            //echo "$password_login_md5";
        $sql = mysql_query("SELECT id FROM users WHERE username = '$user_login' AND password = '$password_login_md5' AND closed='no' LIMIT 1");
            //check for their existence
            $userCount = mysql_num_rows($sql); //Count the number of rows returned
            if($userCount == 1){
                while($row = mysql_fetch_array($sql)){
                    $id = $row["id"];
                }
                    $_SESSION["user_login"] = $user_login;
                    header("location: home.php");
                    exit();
            } 
            else{
                echo 'Incorrect Username and Password';
                exit();
            }
            }       
?>
            <div style="width: 1500px; margin: 0px auto 0px auto;">
            <table>
                <tr>
                    <td width="100%" valign="top">
                        <h2>Already a member? Sign in below!</h2>
                        <form action="index.php" method="POST">
                            <input type="text" name="user_login" size="25" required="1" placeholder="Usename" autocomplete="off"/> <br><br>
                            <input type="password" name="password_login" size="25" required="1" placeholder="Password"/> <br><br>
                            <input type="submit" name="login" value="Login">
                        </form>
                    </td>
                    <td width="40%" valign="top">
                        <h2>Sign Up Below</h2>
                        <form action="#" method="POST">
                            <input type="text" name="fname" size="25" required="1" placeholder="first name" autocomplete="off"/> <br><br>
                            <input type="text" name="lname" size="25"  required="1"placeholder="last name" autocomplete="off"/> <br><br>
                            <input type="text" name="username" size="25" required="1" placeholder="Username" autocomplete="off"/> <br><br>
                            <input type="text" name="email" size="25" required="1" placeholder="Email Address" autocomplete="off"/> <br><br>
                            <input type="text" name="email2" size="25" required="1" placeholder="Confirm Email" autocomplete="off"/> <br><br>
                            <input type="password" name="password" size="25" required="1" placeholder="Password"/> <br><br>
                            <input type="password" name="password2" size="25" required="1" placeholder="Confirm Password"/> <br><br>
                            <input type="submit" name="reg" value="Sign Up!"/>
                        </form>
                    </td>
                </tr>
            </table>
<?php include ("./inc/footer.inc.php"); ?>            