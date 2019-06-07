<?php 
require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';
require_once 'mail-conf.php';
require_once "db-config.php";
require_once "session.php";

$statusMsg = '';
$mentor = false;
// File upload path
$targetDir = ARTFUPLOADPATH;
$targetUrl = ARTFUPLOADURL;

$stmt = $mysqli->prepare("SELECT matchings.mentor_id, users.email, users.name from  matchings INNER JOIN users ON users.id=matchings.mentor_id WHERE painter_id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$stmt->execute();
$stmt->store_result();
 if($stmt->num_rows === 0) {
    $mentor = false;
 } else {
    $stmt->bind_result($mentor_id, $mentor_email, $mentor_name);
    $stmt->fetch();
    $mentor = true;
 }
 
if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
   
    $filename       = basename($_FILES["file"]["name"]);
    $fileName       = str_replace(' ', '-', $filename);
    $targetFilePath =  $targetDir . $fileName;
    $fileType       = pathinfo($targetFilePath,PATHINFO_EXTENSION);
   
    $counter = 0;
    while(file_exists($targetDir . $fileName)) {
        $fileName = $fileName ."-". $counter . '.' . $fileType;
        $counter++;
    };
    $targetFilePath =  $targetDir . $fileName;
    $targetFileUrl =  $targetUrl . $fileName;
// Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','pdf');
    if(in_array($fileType, $allowTypes)){
// Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
           
                 $stmt = $mysqli->prepare("INSERT INTO drawings (file_path, user_id, created_at) VALUES (?, ?, NOW())");
            
                 $stmt->bind_param("si", $targetFileUrl, $_SESSION['id']);
                
            if($stmt->execute()){
                $_SESSION['message'] = "The file ".$fileName. " has been uploaded successfully.";
               
                if($mentor){
                        try {
                        $mail->addAddress($mentor_email, $mentor_name);                                
                        $mail->Subject = 'New Painting !';
                        $mail->Body    = 'A Painter has just uploaded a new Drawing!!';
                        $mail->send();
                        } catch (Exception $e) {
                            echo "<br><br><br><br><br><br><br>Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                }
                 $stmt->close();
                header("location:upload.php");
            }else{
              //  print_r($stmt->errorInfo());
                 $_SESSION['message'] = "File upload failed, please try again.";
                header("location:upload.php");
            } 
        }else{
             $_SESSION['message'] = "Sorry, there was an error uploading your file.";
            header("location:upload.php");
        }
    }else{
        $_SESSION['message'] = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        header("location:upload.php");
    }
}


// Display status message

/*$query = $db->query("SELECT * FROM images ORDER BY uploaded_on DESC");

if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $imageURL = 'uploads/'.$row["file_name"];
?>
    <img src="<?php echo $imageURL; ?>" alt="" />
<?php }
}else{ ?>
    <p>No image(s) found...</p>
<?php }?>*/ 

 ?>

<!DOCTYPE html>
<html>
<title>upload</title>
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

.file-upload {
  background-color: #ffffff;
  width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.file-upload-btn {
  width: 100%;
  margin: 0;
  color: #000000;
  background: #eeeeee;
  border: none;
  padding: 10px;
  border-radius: 4px;
  border-bottom: 4px solid #eeeeee;
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.file-upload-btn:hover {
  background: #696969;
  color: #eeeeee;
  transition: all .2s ease;
  cursor: pointer;
}

.file-upload-btn:active {
  border: 0;
  transition: all .2s ease;
}

.file-upload-content {
  display: none;
  text-align: center;
}

.file-upload-input {
  position: absolute;
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  outline: none;
  opacity: 0;
  cursor: pointer;
}

.image-upload-wrap {
  margin-top: 20px;
  border: 4px dashed #eeeeee;
  position: relative;
}

.image-dropping,
.image-upload-wrap:hover {
  background-color: #eeeeee;
  border: 4px dashed #696969;
}

.image-title-wrap {
  padding: 0 15px 15px 15px;
  color: #222;
}

.drag-text {
  text-align: center;
}

.drag-text h3 {
  font-weight: 100;
  text-transform: uppercase;
  color: ##A9A9A9;
  padding: 60px 0;
}

.file-upload-image {
  max-height: 200px;
  max-width: 200px;
  margin: auto;
  padding: 20px;
}

.remove-image {
  width: 200px;
  margin: 0;
  color: #fff;
  background: #cd4535;
  border: none;
  padding: 10px;
  border-radius: 4px;
  border-bottom: 4px solid #b02818;
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.remove-image:hover {
  background: #c13b2a;
  color: #ffffff;
  transition: all .2s ease;
  cursor: pointer;
}

.remove-image:active {
  border: 0;
  transition: all .2s ease;
}

.button {
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
.form .button:hover {
  background: #CDCDCD;
}
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

<?php
	 if($message != "")
	  echo '<h3>'.$message.'</h3>';
	 ?>
	 
<form id="reportForm" method ="post" action="upload.php" enctype="multipart/form-data">
  <div class="w3-center w3-padding-64" id="contact">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Upload</span>
    <div class="w3-row-padding" id="plans">
    <div class="w3-center w3-padding-64">
     <h3>Share your draw with your mentor</h3>

  </div>
<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<div class="file-upload">
  <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>

  <div class="image-upload-wrap">
    <input class="file-upload-input" type='file' name='file'  onchange="readURL(this);" accept="image/*" />
    <div class="drag-text">
      <h3>Drag and drop a file or select add Image</h3>
    </div>
  </div>
  <div class="file-upload-content">
    <img class="file-upload-image" src="#" alt="your image" />
    <div class="image-title-wrap">
      <input class="button" type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span>
    </div>
  </div>
    <input class="button" type="submit" name="submit" value="Send">
</div>
</form>

<!--<?php
	 if($message != "")
	  echo '<h3>'.$message.'</h3>';
	 ?>
  	<form id="reportForm" method ="post" action="upload.php" enctype="multipart/form-data">

	<input class=".col-4" id="file" name='file' placeholder="drawing" type="file"/></p>

		<p><input class=".col-4" id="submit" name="submit" type="submit" value="שלח"></p>
    </form>-->

</div>
</div>
</div>

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


<script>
function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
		$('.image-upload-wrap').addClass('image-dropping');
	});
	$('.image-upload-wrap').bind('dragleave', function () {
		$('.image-upload-wrap').removeClass('image-dropping');
});
</script>

<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
