<?php 
require_once "db-config.php";
require_once "session.php";
?>
<!DOCTYPE html>
<html>
<title>About</title>
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

  
  <!-- Grid -->
  <div class="w3-row w3-container">
    <div class="w3-center w3-padding-64">
      <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">About</span>
      <div class="w3-row-padding" id="plans">
    <div class="w3-center w3-padding-64">
	  <h3>Who We Are</h3>
      <p>.העמותה לאמנות בקהילה ודיאלוג בינתרבותי הוקמה בשנת 1998 על ידי עדי יקותיאלי, אמן, אוצר ויזם חברתי</p>
	  <p>.מאז הקמתה הייתה מעורבת ביזום והובלה של מעל 300 פרויקטים בכ-30 מדינות, בהם השתתפו כ-600,000 איש ואישה אשר יצרו במגוון דיסיפלינות אמנותיות</p>
	  <p>.פעילות העמותה מוקדשת ליצירת דיאלוג בין קהילות ובתוך קהילות באמצעות עשייה אמנותית שותפנית המבוססת על השוני בין אנשים, עשייה המעודדת קבלה, נדיבות וסובלנות, ליצירת תוצרים מרהיבים במרחב הציבורי</p>
	  <p>.העמותה מעסיקה ומכשירה צוות קבוע ומנוסה של אמני קהילה ומערך מתנדבים, ומקדמת בברכה מתנדבים חדשים</p>
	  <p>.העמותה פיתחה ומנהלת את תכנית ההכשרה לאמנות בקהילה - החממה ליזמות יצירתית במכללת שנקר בשיתוף עם קרן רוטשילד קיסריה</p>
	  <p>.התוכנית קיימת משנת 2013, ובוגריה משתלבים בעשייה אמנותית-קהילתית בפרויקטים ברחבי הארץ</p>
	  <p>.המערכת נועדה לסייע לבני הגיל השלישי/בודדים/בעלי מוגבלויות ליצור קשר ולפתח דיאלוג מקרב ומעצים באמצעות אמנות (ציור ציורים או צילום תמונות ושליחתם) עם מנחים מטעם העמותה שמלווים את הציירים</p>
    </div>
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