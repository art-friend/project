<?php 
require_once "db-config.php";
require_once "session.php";

if(isset($_POST['submit'])){
    if($_POST['mentor_id'] == "") {
        $_SESSION['message'] = "Please select Mentor";
        header("location:assign-mentor.php");     
    } else if($_POST['painter_id'] == "") {
         $_SESSION['message'] = "Please select Painter";
        header("location:assign-mentor.php"); 
    } else {
        $stmt = $mysqli->prepare("INSERT INTO matchings (mentor_id, painter_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $_POST['mentor_id'], $_POST['painter_id']);
        if($stmt->execute()){
             $_SESSION['message'] = "Mentor has been Assigned successfully.";
             $stmt->close();
             header("location:assign-mentor.php");	
        } else {
             $_SESSION['message'] = "Error Occurred While Processing Your Request. Please try again";
             header("location:assign-mentor.php");
        }
    }
}
?>


<!DOCTYPE html>
<html>
<title>assign mentor</title>
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
  <div class="w3-row w3-container">
    <div class="w3-center w3-padding-64">
      <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Assign Mentors To Painters</span>
      <div class="w3-row-padding" id="plans">
    <div class="w3-center w3-padding-64">

</div>
</div>
</div>
<!-- Surround the select box within a "custom-select" DIV element.
Remember to set the width: -->
<?php
	 if($message != "")
	  echo '<h3>'.$message.'</h3>';
	  if($_SESSION['role'] == "Admin"){
	 ?>
	    <label>Select Painter</label>
	    <form action="assign-mentor.php" method="POST" enctype="multipart/form-data">
	    	<select name="painter_id" id="painter_id" required>
	    		<option value="">-- SELECT --</option>
	    		<?php
	    		$paintr = "Painter";
	    		$stmt = $mysqli->prepare("SELECT users.name, users.id FROM users LEFT JOIN matchings ON users.id =  matchings.painter_id  WHERE matchings.painter_id IS NULL AND users.user_type = ?");

				$stmt->bind_param("s", $paintr);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows === 0) {

				} else {
					while($row = $result->fetch_assoc()) {
						echo '<option value='.$row["id"].'>'.$row['name'].'</option>';
					}
				}
				$stmt->close();

	    		?>
	    	</select><br><br>
	       <label>Assign Mentor</label>	
	    	<select name="mentor_id" required>
	    		<option value="">-- SELECT --</option>
	    		<?php
	    		$mentr = "Mentor";
	    		$stmt = $mysqli->prepare("SELECT * FROM users WHERE user_type = ?");
				$stmt->bind_param("s", $mentr);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows === 0) {

				} else {
					while($row = $result->fetch_assoc()) {
						echo '<option value='.$row["id"].'>'.$row['name'].'</option>';
					}
				}
				$stmt->close();
	    		?>
	    	</select>
	    <br>
	    <input type="submit" name="submit" value="submit">
	    </form>
	    <?php } else {
	    echo "only admin can assign Mentors.";
	    }?>
	    <div>
	    <div style="float: left; width: 50%;">
	    	<h5>Painters</h5>
	    	<p>
	    		<?php
	    	    $stmt = $mysqli->prepare("SELECT users.name, users.email FROM users INNER JOIN matchings ON users.id =  matchings.painter_id");
			//	$stmt->bind_param("i", $_SESSION['id']);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows === 0) exit('No Data');
				while($row = $result->fetch_assoc()) {
						echo "<p>";
				        echo  $row['name'];
				        echo "</p>";
				}
				$stmt->close();

	    		?>
	    	
	    	</p>
	    </div>
	    <div style="float: left; width: 50%;">
	    	<h5>Mentors</h5>
	    	
	    			<?php
	    	   $stmt = $mysqli->prepare("SELECT users.name, users.email FROM users INNER JOIN matchings ON users.id =  matchings.mentor_id");
			//	$stmt->bind_param("i", $_SESSION['id']);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows === 0) exit('No Data');
				while($row = $result->fetch_assoc()) {
						echo "<p>";
				        echo  $row['name'];
				        echo "</p>";
				}
				$stmt->close();

	    		?>
	    
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
</body>
</html>
<script>
    function log_out(){
        window.location='logout.php';
        }
</script>