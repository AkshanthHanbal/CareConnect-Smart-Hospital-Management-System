<?php
ob_start();
session_start();
$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$_SESSION["date"]=$date;


//import database
include("connection.php");





if($_POST){

    $email=$_POST['useremail'];
    $password=$_POST['userpassword'];
    
    $error='<label for="promter" class="form-label"></label>';

    if($result= $database->query("select * from webuser where email='$email'")){
    if($result->num_rows==1){
        $utype=$result->fetch_assoc()['usertype'];
        if ($utype=='p'){
            $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
            if ($checker->num_rows==1){


                //   Patient dashbord
                $_SESSION['user']=$email;
                $_SESSION['usertype']='p';
                
                header('location: /patient/index.php');

            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }

        }elseif($utype=='a'){
            $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
            if ($checker->num_rows==1){


                //   Admin dashbord
                $_SESSION['user']=$email;
                $_SESSION['usertype']='a';
                
                header('location: /admin/index.php');

            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }


        }elseif($utype=='d'){
            $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
            if ($checker->num_rows==1){


                //   doctor dashbord
                $_SESSION['user']=$email;
                $_SESSION['usertype']='d';

                header('location: /doctor/index.php');

            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }

        }
        
    }else{
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
    }
}





    
}else{
    $error='<label for="promter" class="form-label">&nbsp;</label>';
}
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="BMS1/img/bms-hospital-website-favicon-color.png">
        <title> BMS Hospital Login </title>

        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
                
        <!-- Boxicons CSS -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
                        
    </head>
    <body>

        <section class="container forms">
            <div id="form" class="form login">
                <div class="form-content">
                    <header>Login</header>
                    <form name="form" action="" onsubmit="return isvalid()" method="POST" >
                        <div class="field input-field">
                            <input type="text" placeholder="email" id="user" name="useremail" class="input">
                        </div>

                        <div class="field input-field">
                            <input type="password" placeholder="Password" id="pass" name="userpassword" class="password">
                            <i class='bx bx-hide eye-icon'></i>
                        </div>

                        <div  class="field button-field">
                           <input type="submit"  value="Login" class="login-btn btn-primary btn"/>
                        </div>
                    </form>

                    <div class="form-link">
                        <span>Don't have an account?<a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                    </div>
                </div>

             



          

            

        <!-- JavaScript -->
        <script>
            function isvalid(){
                var user = document.form.user.value;
                var pass = document.form.pass.value;
                if(user.length=="" && pass.length==""){
                    alert("Username and password field is empty!!!");
                    return false
                }
                else{
                    if(user.length=="" ){
                    alert("Username  is empty!!!");
                    return false
                }
                if(pass.length=="" ){
                    alert("Password  is empty!!!");
                    return false
                }
            }
            }
            </script>
    </body>
</html>
<?php
ob_end_flush(); // Flush output buffer
?>