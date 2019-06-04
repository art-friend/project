<?php 
require_once '../phpmailer/Exception.php';
require_once '../phpmailer/PHPMailer.php';
require_once '../phpmailer/SMTP.php';
require_once 'mail-conf.php';
require_once "db-config.php";
require_once "session.php";



$drawing_id = $_GET['id'];

  if(isset($_POST['submit'])){
        if (empty($_POST['comment'])) {
    		$_SESSION['message'] = "Please Enter Comment text";
    		header("location:drawing-comment.php?id=".$drawing_id);
    	}
        $stmt1 = $mysqli->prepare("INSERT INTO comments (drawing_id, user_id, comment) VALUES (?,?,?)");
		$stmt1->bind_param("iis", $drawing_id, $_SESSION['id'], $_POST['comment']);	
		
		if ($stmt1->execute()) {
		    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $_POST['painter']);
            $stmt->execute();
            $arr = $stmt->get_result()->fetch_assoc();
            if(is_array($arr)) {
                // Send Mail to painter
    		    try {
    		    $mail->setFrom('contact@kynetweb.com', 'Art Friend');
                $mail->addAddress($arr['email'], $arr['name']);
                                                  // Set email format to HTML
                $mail->Subject = 'New Comment !';
                $mail->Body    = 'Your mentor has just posted a new comment on your drawing!!';
                $mail->send();
                $_SESSION['message'] = "Comment has been submitted Sucessfully !";
    		    header("location:drawing-comment.php?id=".$drawing_id);
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
		    
		}
		else{
		   $_SESSION['message'] = "Error in saving comment! Please try again";
		   header("location:drawing-comment.php?id=".$drawing_id);
		}
	}

	


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Rubik|Varela+Round" rel="stylesheet">
    <title>דף הבית</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
</head>

<body dir="rtl">
	<header class="col-12">
            <a href="index.php" target="_parent"><img id="logo" src="../CSS\pics\logo.png" /></a>

				
			<script>
                function menuFunction() {
                    var x = document.getElementById("navbar");
					  if (x.style.display === "block") {
					      x.style.display="none";
					  } else {
					      x.style.display = "block";
					  }
					}

					function menuResize()
					{
					    if (window.outerWidth > 1300)
					        document.getElementById("navbar").style.display = "block";
                        else
					        document.getElementById("navbar").style.display = "none";
					}
					
					</script>
								
            <a href="#" onclick="menuFunction()">
                <div class="hamburger"></div>
			    <div class="hamburger"></div>
			    <div class="hamburger"></div>
            </a>

				
	      <nav id="navbar">
		        <ul>
			        <li><a class="menulinks" href="index.php" target="_parent">Homepage</a></li>
					<li><a class="menulinks" href="about.php" target="_parent" >About</a></li> 
			        <li><a class="menulinks" href="CanvasWithSave.php" target="_parent" >Draw</a></li> 
			        <li><a class="menulinks" href="upload.php" target="_parent">Upload a drawing</a></li> 
			        <li><a class="menulinks" href="gallery.php" target="_parent">Gallery</a></li> 
					<li><a class="menulinks" href="contact.php" target="_parent" >Contact</a></li> 
					<li><a class="menulinks" href="my-account.php" target="_parent" >My Account</a></li>
				   
				   <?php 
					 if ($loggedin) { ?>
					<li><a class="menulinks" href="my-account.php?logout" target="_parent" >Logout</a></li>
				   <?php } ?>
		        </ul>
	        </nav>
	    </header>
	    <h3><?php echo $message ?></h3>
<?php
 if (isset($drawing_id)):
            $painter_id;
    	    $stmt = $mysqli->prepare("SELECT * FROM  drawings WHERE id = ?");
    		$stmt->bind_param("i", $drawing_id);
    		$stmt->execute();
    		$result = $stmt->get_result();

    		if($result->num_rows != 0) {
    			while($row = $result->fetch_assoc()) {
    			    $painter_id = $row['user_id'];
        	    	echo '<a href='.$row['file_path'].'>';
        			echo '<img src='.$row['file_path'].'>';
        			echo "</a>";
    	    	}
            }
            else {
		    	echo "Invalid request";
            }
endif;
if ($_SESSION['role'] == 'Mentor' || $_SESSION['role'] == 'Admin'):?>
	    <form action="drawing-comment.php?id=<?php echo $drawing_id ?>" method="POST" >
	    	<textarea placeholder='Enter your Comment..' name="comment" required=""></textarea>
	    	<input type="hidden" name="painter" value="<?php echo $painter_id ?>"/>
	    	<input type="submit" name="submit">
	    </form>
<?php endif; ?>
</body>
</html>
