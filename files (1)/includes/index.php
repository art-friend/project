
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
					if ($_SESSION['role'] == 'Admin') { ?>
					<li><a class="menulinks" href="assign-mentor.php" target="_parent" >Assign Mentor</a></li>
				<?php	} ?>
		        </ul>
	        </nav>
	    </header>

</body>
</html>
