<?php 
require_once "db-config.php";
require_once "session.php";
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
				echo '<img style="width:auto" src="'.$row['file_path'].'" >';
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
							echo  $row1['comment']."~~".$arr['name'];
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
							echo '<img style="width:auto" src='.$row1['file_path'].' />';
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
</body>
</html>
