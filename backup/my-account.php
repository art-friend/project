<?php
require_once "db-config.php";
require_once "session.php";

?>
<!DOCTYPE html>
<html>
<title>My Account</title>
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


  <div class="w3-center w3-padding-64" id="contact">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Gallery</span>
  </div>
  
  
	
<h3><?php echo "Hello ".$_SESSION['username'] ?></h3>
<?php 

if($_SESSION['role'] == 'Painter' ){
		$stmt = $mysqli->prepare("SELECT * FROM drawings WHERE user_id = ? ");

		$stmt->bind_param("i", $_SESSION['id']);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows != 0) {

			while($row = $result->fetch_assoc()) {

				echo "<div class='full-row'>";
				echo "<div class='col-4'>";
				echo '<a  href="'.$row['file_path'].'" >';
				echo '<img style="width:50%;" onclick="onClick(this)" src="'.$row['file_path'].'" >';
				echo '</a>';
				echo "</div>";
				
			      	
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
						echo "</div>";
						
					} else {
					    echo "<p class='comment-text'>";
						echo "No Comments are available";
						echo "</p>";
						
					}	
				echo "</div>";
			}
		}
$stmt->close();		
} elseif ($_SESSION['role'] == 'Mentor') {
		$stmt = $mysqli->prepare("SELECT matchings.painter_id, users.name from  matchings INNER JOIN users ON users.id=matchings.painter_id WHERE mentor_id = ?");
		$stmt->bind_param("i", $_SESSION['id']);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows != 0) {

			while($row = $result->fetch_assoc()) {

				echo "<div class='col-12'>";
				echo "<p>Submited By:". $row['name']."</p>"; 
			      	
			      	$drs = $mysqli->prepare("SELECT * from drawings WHERE user_id = ?");
			      	$drs->bind_param("i", $row['painter_id']);
					$drs->execute();
					$_presult = $drs->get_result();

					if($_presult->num_rows != 0) {
					
						while($row1 = $_presult->fetch_assoc()) {

							echo "<div class='full-row'>";	
							echo "<div class='col-6'>";
							echo '<a href='.$row1['file_path'].'>';
							echo '<img style="width:50%;" onclick="onClick(this)" src='.$row1['file_path'].' />';
							echo "</a>";
							echo "</div>";
							echo "<div class='col-6'>";
							echo '<a href="drawing-comment.php?id='.$row1['id'].'">Comment</a>';
							echo "</div>";
							echo "</div>";
						}
						
					} else {
						echo "No drawings are available";
					}	
				echo "</div>";
			}
		}
$stmt->close();
}
elseif ($_SESSION['role'] == 'Admin') {
    echo "Hello ADMIN!";
    echo '<a href="assign-mentor.php">Assign Mentors</a>';
}
?>

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