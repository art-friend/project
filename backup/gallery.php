<?php 
require_once "db-config.php";
require_once "session.php";
?>

<!DOCTYPE html>
<html>
<title>Gallery</title>
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
	
.w3-half img{
	margin-bottom:-6px;
	margin-top:16px;
	opacity:0.8;
	cursor:pointer}
	
.w3-half img:hover{
	opacity:1}
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

  <!-- Contact -->
  <div class="w3-center w3-padding-64" id="contact">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Gallery</span>
  </div>

  <!-- Modal for full size images on click-->
  <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
    <span class="w3-button w3-black w3-xxlarge w3-display-topright">×</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
      <img id="img01" class="w3-image">
      <p id="caption"></p>
    </div>
  </div>

  

<!-- End page content -->
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
<?php 
  
if($_SESSION['role'] == 'Painter' ){
		$stmt = $mysqli->prepare("SELECT * FROM drawings WHERE user_id = ? ");

		$stmt->bind_param("i", $_SESSION['id']);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows != 0) {

			while($row = $result->fetch_assoc()) {


				echo '<img style="width:50%;" onclick="onClick(this)" src="'.$row['file_path'].'">';

			      	
			      	$drs = $mysqli->prepare("SELECT * from comments WHERE drawing_id = ?");
			      	$drs->bind_param("i", $row['id']);
					$drs->execute();
					$_presult = $drs->get_result();

					if($_presult->num_rows != 0) {
					    echo "<div class='col-8'>";
						while($row1 = $_presult->fetch_assoc()) {
						    
						    $cby = $mysqli->prepare("SELECT name FROM users WHERE id = ?");
                            $cby->bind_param("i", $row1['user_id']);
                            $cby->execute();
                            $arr = $cby->get_result()->fetch_assoc();
							
							echo "<p class='comment-text'>";
							echo  $row1['text']."~~".$arr['name'];
							echo "</p>";
						}

						
					} else {
					    echo "<p class='comment-text'>";
						echo "No Comments are available";
						echo "</p>";
						
					}	

			}
		}
}
?>
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