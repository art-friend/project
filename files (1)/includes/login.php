<?php

require_once('db-config.php');
require_once('../../vendor/autoload.php');

session_start();

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
             //echo "יוזר לא קיים או סיסמה לא תקינה";
    } else {
            $stmt->bind_result($id, $name, $email, $user_type);
            $stmt->fetch();
            
             $_SESSION['username'] = $name;
             $_SESSION['email']    = $email;
             $_SESSION['role']     = $user_type;
             $_SESSION['id']       = $id;
             header("location:my-account.php");
    }

}
    
    if(isset($_POST["googleLogin"])){
      // Call Google API
      $user=$_POST["email"];
      $pass=$_POST["password"];
      
      $client = new Google_Client();
      $client->setAuthConfig("../google-api-php-client/config/credentials.json");
      $client->setApplicationName("Login to ArtFriend");
      $client->setRedirectUri("location:index.php");
      $client->fetchAccessTokenWithAuthCode($_GET['code']);
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-signin-client_id" content="484522142320-j8jec60dihk91afi6ep3ktd5s47857r4.apps.googleusercontent.com">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Rubik|Varela+Round" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../CSS/style.css">
	<title>כניסה</title>

</head>

<body dir=rtl>

<div class="container">
<br><br>
  <img class="center" src="../CSS/pics/logo.png" /></a>
   <h2 style="text-align:center">הפגת הבדידות באמצעות ציורים</h2>
  <?php if($message != ""){ ?>
          <div class="callout callout-danger">
                 <h4><?php echo $message ?></h4>
          </div>
  <?php } ?>
  <form action="login.php" method="post">
  <br>
    <br><h2 class="user_msg">כניסה למערכת</h2>

	<div class="row">
      <div class="col-3">
        <input type="text" name="email" placeholder="כתובת מייל" required>
        <input type="password" name="password" placeholder="סיסמא" required>
        <input type="submit" name="logmein" value="Login">
        <div class="g-signin2" data-onsuccess="onSignIn" />
    </div>
    	
    <a href="registration.php" class="btn" id="login-text">לא רשום? צור חשבון</a>
	<a href="#" class="btn" id="login-text">שכחת סיסמא? אפס סיסמא</a>
  </form>
</div>
</body>

<script>function onSignIn(){
window.location.href = 'index.php';
}</script>

</html>

