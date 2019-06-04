
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Rubik|Varela+Round" rel="stylesheet">
    <title>About</title>
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
			        <li><a class="menulinks" href="CanvasWithSave.php" target="_parent">Draw</a></li> 
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
<main class="col-6" style="text-align: center; float:right;">
	<h1>About</h1><br>
    <p>העמותה לאמנות בקהילה ודיאלוג בינתרבותי
הוקמה בשנת 1998 על ידי עדי יקותיאלי, אמן, אוצר ויזם חברתי. מאז הקמתה הייתה מעורבת ביזום והובלה של מעל 300 פרויקטים בכ-30 מדינות, בהם השתתפו כ-600,000 איש ואישה אשר יצרו במגוון דיסיפלינות אמנותיות. ויצרו דיאלוג מקרב ומעצים באמצעות אמנות. </p>
<p> פעילות העמותה מוקדשת ליצירת דיאלוג בין קהילות ובתוך קהילות באמצעות עשייה אמנותית שותפנית המבוססת על השוני בין אנשים, עשייה המעודדת קבלה, נדיבות וסובלנות, ליצירת תוצרים מרהיבים במרחב הציבורי. העמותה מעסיקה ומכשירה צוות קבוע ומנוסה של אמני קהילה ומערך מתנדבים, ומקדמת בברכה מתנדבים חדשים.</p>
    <p> העמותה פיתחה ומנהלת את תכנית ההכשרה לאמנות בקהילה - החממה ליזמות יצירתית במכללת שנקר בשיתוף עם קרן רוטשילד קיסריה. התוכנית קיימת משנת 2013, ובוגריה משתלבים בעשייה אמנותית-קהילתית בפרויקטים ברחבי הארץ.
</p>
<p >המערכת נועדה לסייע לבני הגיל השלישי/בודדים/בעלי מוגבלויות ליצור קשר ולפתח דיאלוג מקרב ומעצים באמצעות אמנות (ציור ציורים או צילום תמונות ושליחתם) עם מנחים מטעם העמותה שמלווים את הציירים.</p>
</main>

</body>
</html>
