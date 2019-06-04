<!DOCTYPE html>


<html>
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="/CSS/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>צור קשר</title>
		
		<script>
		function onlyHebrew() {
    		var txt = document.getElementById("name");
    		var length=txt.value.length-1;
			if(!((txt.value.charAt(length)>='א'&&txt.value.charAt(length)<='ת')||txt.value.charAt(length)==" "))
				{
					txt.value="";
					txt.style.borderColor="red";
					txt.placeholder="Please type a name";
					return false;
					
				}
				else
				txt.style.borderColor="inherit";
    		
    		return true;
		}
		
		function onlyDigits() {
    		var txt = document.getElementById("tel");
    		var length=txt.value.length-1;
			if(!(txt.value.charAt(length)>='0'&&txt.value.charAt(length)<='9'))
				{
					txt.value="";
					txt.style.borderColor="red";
					txt.placeholder="Numbers only"
					return false;
					
				}
				else
				txt.style.borderColor="inherit";
		
		    return true;
		}
		
		function TelValidation() {
    		var txt = document.getElementById("tel");
    		var length = txt.value.length;
			if(length<10)
				{
					window.alert("Digits missing");
					txt.style.borderColor="red";
					return false;
				}
				else
					if(txt.value.substring(0,2)!="05")
					{
					 window.alert("Prefix has to be 05");
					txt.style.borderColor="red";
					return false;
					}
					else
				txt.style.borderColor="inherit";
		
		    return true;
		}
		
		function validateAll() {
		    boli=TelValidation() && onlyHebrew() && onlyDigits();
		    return boli;
		} 
		
		</script>

</head>
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
				   
		        </ul>
	        </nav>
	    </header>

	<main>	    
	<br><h1 class="user_msg">Contact</h1><br>
	
	<h3 class="user_msg">Leave your details and we will get back to you</h3><br>


	    
	    	<?php
		
		if(!empty($_GET['msg']))
			echo "<div id='validation_response' onclick='this.parentNode.removeChild(this)' title='Close the comment'>X| ".$_GET['msg']."</div>";
			
			?>
  	<form id="reportForm" method ="post" action="addReport.php" onsubmit="return validateAll()">

		<p><b>שם מלא<span class="contact">*</span></b><br><input onkeyup="onlyHebrew()" id="name" name='name' placeholder="Full Name" type="text" required/></p>
		
		<p><b>כתובת מייל<span class="contact">*</span></b><br><input id="email" name="email" placeholder="Email" type="email" required/></p>

		<p><b>תוכן<span class="contact">*</span></b><br><textarea class="fault_txtarea" rows="5" input id="comments" name='comments' placeholder="Content" required></textarea></p>
		

		<p><input id="submit" name="submit" type="submit" value="Send"></p>

			<br><br>
    </form>
	
</main>
</body>

</html>