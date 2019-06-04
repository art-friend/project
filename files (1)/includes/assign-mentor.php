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
             $_SESSION['message'] = "Error Accured While Processing Your Request. Please try again";
             header("location:assign-mentor.php");
        }
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
	    <?php
	 if($message != "")
	  echo '<h3>'.$message.'</h3>';
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

						echo '<option  value='.$row["id"].'>'.$row['name'].'</option>';
					}
				}
				$stmt->close();

	    		?>
	    	</select><br><br>
	       <label>Assign Mentor</label>	
	    	<select  name="mentor_id" required>
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
	    <input type="submit" name="submit" value="submit">
	    </form>
	    <div>
	    <div style="float: left; width: 50%;">
	    	<h5>Painters</h5>
	    	<p>
	    		<?php
	    	    $stmt = $mysqli->prepare("SELECT users.name, users.email FROM users INNER JOIN matchings ON  users.id =  matchings.painter_id");
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
	    	   $stmt = $mysqli->prepare("SELECT users.name, users.email FROM users INNER JOIN matchings ON  users.id =  matchings.mentor_id");
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
	</body>
</html>