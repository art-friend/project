<?php
require_once "db-config.php";
session_start();
if(isset($_SESSION['username'])) {
    
      $message = $_SESSION['message'];
      header("location: my-account.php");
}

$name;$email;
if (isset($_POST['registrar'])){
        $error;
		$name      = $_POST['name'];
		$email     = $_POST['email'];
		$password  = $_POST['password'];
		$password2 = $_POST['password2'];
		$user_type = $_POST['user_type'];
		
		if(empty($name)){
		      $error = "Please enter your name";
		} else if(empty($email)){
		     $error = "Please enter your Email Address";
		} else if(empty($password)){
		     $error = "Please enter your Email Address";
		} else if(empty($password2)){
		     $error = "Please Repeat the password";
		} else if($password != $password2){
		     $error = "Password don't match";
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
                         $_SESSION['username'] = $name;
                         $_SESSION['message']  = "Your account has been created Successfully!";
                         header("location:my-account.php");
                    }
            } else {
                $error = "Email already exist! please use a different email address";
            }
		    
		    
		    
		    
		}
}
		


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Rubik|Varela+Round" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../CSS/style.css">
		<title>הרשמה </title>


</head>
	<body dir=rtl>
<br><br>
  <img class="center" src="../CSS/pics/logo.png" /></a>
   <h2 style="text-align:center">Make the loneliness go away with drawings</h2>

	<br>
  	<h2 class="user_msg">Sign up here</h2>
     <?php if(!empty($error)){ ?>
              <div class="callout callout-danger">
                     <h4><?php echo $error ?></h4>
              </div>
      <?php } ?>
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
	 </div>
	 
</main>

</body>

</html>

