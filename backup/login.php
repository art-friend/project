<?php
require_once('db-config.php');
session_start();

$message ="";
if(isset($_SESSION['username'])){
  header("location: index.php");
}

 if(isset($_POST["logmein"])){

    $email     =  $_POST["email"];
    $password  =  md5($_POST["password"]);

    $stmt = $mysqli->prepare("SELECT id, name, email, user_type FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows === 0) {
            $_SESSION['message'] = "Wrong Email or Password";
             $message = $_SESSION['message'];
             //echo "wrong user or pwd";
    } else {
            $stmt->bind_result($id, $name, $email, $user_type);
            $stmt->fetch();
             $_SESSION['username'] = $name;
             $_SESSION['email']    = $email;
             $_SESSION['role']     = $user_type;
             $_SESSION['id']       = $id;
             //echo "ok";
             header("location:index.php");
    }

}

 if(isset($_POST["loggoogle"])){
/*
    $email     =  $_POST["email"];
    $stmt = $mysqli->prepare("SELECT id, name, email, user_type FROM users WHERE email = ?");
    $stmt->bind_param("ss", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $email, $user_type);
    $stmt->fetch();
    $_SESSION['username'] = $name;
    $_SESSION['email']    = $email;
    $_SESSION['role']     = $user_type;
    $_SESSION['id']       = $id;
     //echo "ok";
     header("location:index.php");
*/
}
    
    if(isset($_GET["googleLogin"])){
       $authUrl = $client->createAuthUrl();
      header("location:". $authUrl);
    }
?>

<!DOCTYPE html>
<html>
<title>Art Friend- Login</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!--- Google Api--->
	<meta name="google-signin-client_id" content="594557232387-khtinlmi42rhl01dqnoqochqu5l8p4cc.apps.googleusercontent.com">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>


<style>
html,body,h1,h2,h3,h4 {
	font-family:"Lato", sans-serif}
.mySlides {
	display:none}
.w3-tag, .fa {
	cursor:pointer}
.w3-tag {
	height:15px;
	width:15px;
	padding:0;
	margin-top:6px}
	
@import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #A9A9A9;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form .button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #696969;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #ffffff;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form .button:hover,.form button:active,.form button:focus {
  background: #CDCDCD;
}

.form .message {
  margin: 15px 0 0;
  color: #696969;
  font-size: 12px;
}
.form .message a {
  color: #CDCDCD;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #ffffff;
}
.container .info span {
  color: #CDCDCD;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}

</style>
<body>
<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-large w3-light-grey">


  </div>
</div>
<!-- Content -->
<div class="w3-content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

  <div class="w3-panel">
    <h1><b>ART FRIEND</b></h1>
	<h2><b>Solving loneliness by drawing paintings</b></h2>
	<?php if($message != ""){ ?>
          <div class="callout callout-danger">
                 <h4><?php echo $message ?></h4>
          </div>
  <?php } ?>
  </div>


  <div class="w3-center w3-padding-32" id="contact">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Log In</span>
  </div>


<!---<form action="login.php" method="post">
  <br>
	<div class="row">
      <div class="col-3">
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="logmein" value="Login">
        <div class="g-signin2" data-onsuccess="onSignIn" />
    </div>
    	
    <a href="registration.php" class="btn" id="login-text">לא רשום? צור חשבון</a>
	<a href="#" class="btn" id="login-text">שכחת סיסמא? אפס סיסמא</a>
  </form>--->


<div class="login-page">
  <div class="form">
    
    <form class="login-form" method="post">
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
      <!--<button>login</button>-->
      <input class="button" type="submit" name="logmein" value="Login">
      <p class="message">Not registered? <a href="registration.php">Create an account</a></p>
      <a class="loginBtn loginBtn--google" href="login.php?googleLogin">Login With Google </a>
     <!-- <div class="g-signin2" data-onsuccess="onSignIn" />-->
    </form>
  </div>
</div>
</div>
</div>

<!-- Footer -->

<footer class="w3-container w3-padding-32 w3-light-grey w3-center">
  <div class="w3-xlarge w3-section">
    <a href="https://www.facebook.com/artinthecommunityisrael/"> <i class="fa fa-facebook-official w3-hover-opacity"></i></a>
  </div>
</footer>

<script>
    function log_out(){
        window.location='logout.php';
        }
</script>

<script>
function onSignIn(googleUser){
    var profile = googleUser.getBasicProfile();
    var emailAddr = profile.getEmail();
    //document.body.innerHTML += '<form id="dynForm" action="login.php" method="post"><input type="hidden" name="email" value="' + emailAddr +'"><input type="hidden" name="loggoogle" value="d"></form>';
    //document.getElementById("dynForm").submit();
}
</script>

</body>
</html>