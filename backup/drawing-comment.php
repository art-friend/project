<?php 
require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';
require_once 'mail-conf.php';
require_once "db-config.php";
require_once "session.php";

if(isset($_GET['id'])){
    $drawing_id = $_GET['id'];
} else {
    echo "Invalid Request";
    exit();
}

  if(isset($_POST['submit'])){
        if (empty($_POST['comment'])) {
    		$_SESSION['message'] = "Please Enter Comment text";
    		header("location:drawing-comment.php?id=".$drawing_id);
    	}
        $stmt1 = $mysqli->prepare("INSERT INTO comments (drawing_id, user_id, text) VALUES (?,?,?)");
		$stmt1->bind_param("iis", $drawing_id, $_SESSION['id'], $_POST['comment']);	
		
		if ($stmt1->execute()) {
		    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $_POST['painter']);
            $stmt->execute();
            $arr = $stmt->get_result()->fetch_assoc();
            if(is_array($arr)) {
                // Send Mail to painter
    		    try {
                $mail->addAddress($arr['email'], $arr['name']);                                 // Set email format to HTML
                $mail->Subject = 'New Comment !';
                $mail->Body    = 'Your mentor has just posted a new comment on your drawing!!';
                $mail->send();
                $_SESSION['message'] = "Comment has been submitted Sucessfully !";
    		    header("location:drawing-comment.php?id=".$drawing_id);
                } catch (Exception $e) {
                    echo "<br><br><br><br><br><br><br>Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
<title>Drawing Respond</title>
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
</style>
<body>

<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-large w3-light-grey">
    <div class="w3-col s2">
      <a href="index.php" target="_parent" class="w3-button w3-block">Home</a>
    </div>
    <?php
    if ($_SESSION['role'] == 'Painter'){
        ?>
    <div class="w3-col s2">
      <a href="about.php" target="_parent" class="w3-button w3-block">About</a>
    </div>
        <div class="w3-col s2">
      <a href="CanvasWithSave.php" target="_parent" class="w3-button w3-block">Draw</a>
    </div>
    <div class="w3-col s2">
      <a href="upload.php" target="_parent" class="w3-button w3-block">Upload</a>
    </div>
    <div class="w3-col s2">
      <a href="gallery.php" target="_parent" class="w3-button w3-block">Gallery</a>
    </div>
    <?php
    }
	?>
	
	<?php
	if ($_SESSION['role'] == 'Mentor'){
        ?>
    <div class="w3-col s2">
      <a href="my-account.php" target="_parent" class="w3-button w3-block">Drawings Respond</a>
    </div>
    <?php
    }
	?>
	
	<?php
	if ($_SESSION['role'] == 'Admin') { 
	?>
	<div class="w3-col s2">
      <a href="assign-mentor.php" target="_parent" class="w3-button w3-block">Assign Mentor</a>
    </div>
    <?php
    }
	?>
	
	<?php
	if ($loggedin) {
	    ?>
	<div class="w3-col s2">
      <a href="index.php?logout" target="_parent" class="w3-button w3-block">Logout</a>
    </div>
    <?php
    }
	?>
	
  </div>
</div>

<!-- Content -->
<div class="w3-content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

  <div class="w3-panel">
    <h1><b>ART FRIEND</b></h1>
  </div>

  
  <!-- Grid -->
  <div class="w3-row w3-container">
    <!--<div class="w3-center w3-padding-64">-->
      <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Comments gallery</span>
      <!--<div class="w3-row-padding" id="plans">-->
    <div class="w3-center w3-padding-64">
	  <h3>Write here your comment</h3>
	</div>
  </div>
	
<!-- Modal for full size images on click-->
  <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
    <span class="w3-button w3-black w3-xxlarge w3-display-topright">×</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
      <img id="img01" class="w3-image">
      <p id="caption"></p>
    </div>
  </div>

</div>

<script>
// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</div>

<!-- Photo grid (modal) -->
<div class="w3-row-padding">
<div style="text-align:center;">
<div style="text-align:center;">
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
        			echo '<img src='.$row['file_path'].' onclick="onClick(this)" style="width:50%">';
        			echo "</a>";
    	    	}
            }
            else {
		    	echo "Invalid request";
            }
endif;
if ($_SESSION['role'] == 'Mentor' || $_SESSION['role'] == 'Admin'):?>
	    <form action="drawing-comment.php?id=<?php echo $drawing_id ?>" method="POST" >
	    	<br><textarea placeholder='Enter your Comment..' name="comment" required=""></textarea>
	    	<input type="hidden" name="painter" value="<?php echo $painter_id ?>"/>
	    	<br /><input type="submit" name="submit"><br><br>
	    </form>
<?php endif; ?>
</div></div></div>
<!-- Footer -->

<footer class="w3-container w3-padding-32 w3-light-grey w3-center">
  <div class="w3-xlarge w3-section">
    <a href="https://www.facebook.com/artinthecommunityisrael/"> <i class="fa fa-facebook-official w3-hover-opacity"></i></a>
  </div>
</footer>
</body>
</html>
<script>
    function log_out(){
        window.location='logout.php';
        }
</script>
</body>
</html>