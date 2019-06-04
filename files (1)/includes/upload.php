<?php 
require_once "db-config.php";
require_once "session.php";



$statusMsg = '';

// File upload path
$targetDir = ARTFUPLOADPATH;

$targetUrl = ARTFUPLOADURL;



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
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="/CSS/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Upload a drawing</title>
	

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
			        <li><a class="menulinks" href="CanvasWithSave.php" target="_parent">Draw</a></li> 
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
    
    <main>    
	<br><br><h1 class="user_msg">Upload a drawing</h1><br>
	    
	 <h3 class="user_msg">Upload your drawing and wait for your mentor feedback</h3><b>
	 <?php
	 if($message != "")
	  echo '<h3>'.$message.'</h3>';
	 ?>
  	<form id="reportForm" method ="post" action="upload.php" enctype="multipart/form-data">

	<input class=".col-4" id="file" name='file' placeholder="drawing" type="file"/></p>

		<p><input class=".col-4" id="submit" name="submit" type="submit" value="שלח"></p>
		<br>
	
			<br><br>
    </form>
	
</main>
</body>

</html>

<script>
            function log_out(){
                window.location='logout.php';
            }
        </script>