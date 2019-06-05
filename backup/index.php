<?php 
require_once "db-config.php";
require_once "session.php";
?>
<!DOCTYPE html>
<html>
<title>Art Friend</title>
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
  
<h3><?php echo "Hello ".$_SESSION['username'] ?></h3>
 

  <!-- Slideshow -->
  <div class="w3-container">
    <div class="w3-display-container mySlides">
      <img src="css/images/streetart.jpg" style="width:100%">
    </div>
    <div class="w3-display-container mySlides">
      <img src="css/images/streetart2.jpg" style="width:100%">
    </div>
    <div class="w3-display-container mySlides">
      <img src="css/images/streetart3.jpg" style="width:100%">
    </div>
	<div class="w3-display-container mySlides">
      <img src="css/images/streetart4.jpg" style="width:100%">
    </div>


    <!-- Slideshow next/previous buttons -->
    <div class="w3-container w3-dark-grey w3-padding w3-xlarge">
      <div class="w3-left" onclick="plusDivs(-1)"><i class="fa fa-arrow-circle-left w3-hover-text-teal"></i></div>
      <div class="w3-right" onclick="plusDivs(1)"><i class="fa fa-arrow-circle-right w3-hover-text-teal"></i></div>
    
      <div class="w3-center">
        <span class="w3-tag demodots w3-border w3-transparent w3-hover-white" onclick="currentDiv(1)"></span>
        <span class="w3-tag demodots w3-border w3-transparent w3-hover-white" onclick="currentDiv(2)"></span>
        <span class="w3-tag demodots w3-border w3-transparent w3-hover-white" onclick="currentDiv(3)"></span>
		<span class="w3-tag demodots w3-border w3-transparent w3-hover-white" onclick="currentDiv(4)"></span>
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
// Slideshow
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demodots");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length} ;
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" w3-white", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-white";
}
</script>	
</body>
</html>
<script>
    function log_out(){
        window.location='logout.php';
        }
</script>