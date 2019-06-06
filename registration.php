<?php
require_once "db-config.php";
session_start();
if(isset($_SESSION['username'])) {
    
      $message = $_SESSION['message'];
      header("location: my-account.php");
}


$message = "";
$name="";
$email="";
if (isset($_POST['registrar'])){
        $error;
		$name      = $_POST['name'];
		$email     = $_POST['email'];
		$password  = $_POST['password'];
		$password2 = $_POST['password2'];
		$user_type = $_POST['user_type'];
		
		if(empty($name)){
		      $message = "Please enter your name";
		} else if(empty($email)){
		     $message = "Please enter your Email Address";
		} else if(empty($password)){
		     $message = "Please enter your Email Address";
		} else if(empty($password2)){
		     $message = "Please Repeat the password";
		} else if($password != $password2){
		     $message = "Password don't match";
		}
		else {
		    $password = md5($password);
		    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0) {
                $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, user_type, created_at) VALUES (?, ?, ?, ?, NOW())");
                    $stmt->bind_param("ssss", $name, $email, $password, $user_type);
                    if($stmt->execute()) {
                         $stmt->close();
                       
                         $_SESSION['message']  = "Your account has been created Successfully!";
                             $_SESSION['username'] = $name;
                             $_SESSION['email']    = $email;
                             $_SESSION['role']     = $user_type;
                             $_SESSION['id']       = $mysqli->insert_id;
                         header("location:index.php");
                    }
            } else {
                $message = "Email already exist! please use a different email address";
            }
		}
}
		
?>



<!DOCTYPE html>
<html>
<title>Art Friend- Registration</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
.form button:hover,.form button:active,.form button:focus {
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
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Registration</span>
  </div>


<div class="login-page">
  <div class="form">
    <form class="register-form" method ="post" action="registration.php">
        <input type="text" id="name" name="name" value="<?php echo $name ?>" placeholder="Full Name" required>
        <input type="email" id="email" name="email" value="<?php echo $email ?>" placeholder="Email Address" required>
		<input type="password" name="password" placeholder="Password" required>
		<input type="password" name="password2" placeholder="Repeat Password" required>
		<label>Who are you</label>
		<select id ="user_type" name="user_type" required="">
               <option value = "Painter">Painter</option>
               <option value = "Mentor">Mentor</option>
             </select>
      <input class="button" type="submit" name="registrar" value="create">
      <p class="message">Already registered? <a href="login.php">Sign In</a></p>
      </div>
    </form>
  </div>
</div>
 <?php if(!empty($message)){ ?>
              <div class="callout callout-danger">
                     <h4><?php echo $message ?></h4>
              </div>
      <?php } ?>
  	<!---<h2 class="user_msg">Sign up here</h2>
    
      
	<form id="RegistrationForm" method ="post" action="registration.php">
	
	<div class="row">
      <div class="col-3">
        <input type="text" id="name" name="name" value="<?php echo $name ?>" placeholder="Full Name" required>
        <input type="email" id="email" name="email" value="<?php echo $email ?>" placeholder="Email Address" required>
		<input type="password" name="password" placeholder="Password" required>
		<input type="password" name="password2" placeholder="Repeat Password" required>
		<label>Who are you</label>
		<select id = "user_type" name="user_type" required="">
               <option value = "Painter">Painter</option>
               <option value = "Mentor">Mentor</option>
             </select>
        <input type="submit" name="registrar" value="Sign UP">
      </div>
    </form>
	 </div>--->
	 


</div>

<script>function onSignIn(){
window.location.href = 'index.php';
}</script>

<!-- Footer -->

<footer class="w3-container w3-padding-32 w3-light-grey w3-center">
  <div class="w3-xlarge w3-section">
    <a href="https://www.facebook.com/artinthecommunityisrael/"> <i class="fa fa-facebook-official w3-hover-opacity"></i></a>
  </div>
</footer>

</body>
</html>