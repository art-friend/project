<?php
require_once "db-config.php";
if(!session_id()){
    session_start();
}

if(isset($_SESSION["accessToken"])){
    $client->setAccessToken($_SESSION['accessToken']);
} else if(isset($_GET['code'])) {
    
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION["accessToken"] = $token;
  
} else {
    header("location:index.php");
}

$oAuth = new Google_Service_Oauth2($client);
$user = $oAuth->userinfo->get();

  $name  = $user->name;
 $email = $user->email;

          
            $password = "";
            $user_type = "Painter";
		    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
		    
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows === 0) {
                $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, user_type, created_at) VALUES (?, ?, ?, ?, NOW())");
                    $stmt->bind_param("ssss", $name, $email, $password, $user_type);
                    if($stmt->execute()) {
                         $stmt->close();
                             $_SESSION['username'] = $name;
                             $_SESSION['email']    = $email;
                             $_SESSION['role']     = $user_type;
                             $_SESSION['id']       = $mysqli->insert_id;
                         header("location:my-account.php");
                    }
            } else {
                        $stmt->bind_result($id);
                        $stmt->fetch();
                                                
                        $stmt = $mysqli->prepare("UPDATE users SET name = ?  WHERE id = ?");
                        $stmt->bind_param("si", $name, $id);
                        $stmt->execute();
                        $stmt->close();
                        $_SESSION['username'] = $name;
                             $_SESSION['email']    = $email;
                             $_SESSION['role']     = $user_type;
                             $_SESSION['id']       = $id;
                             header("location:my-account.php");
            }

