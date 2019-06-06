<?php 
require_once "db-config.php";
require_once "session.php";
?>
<!DOCTYPE html>
<html>
<title>Draw</title>
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

#can {
  position: absolute;
  top: 80px;
  left: 0px;
  background-color: #AAA;
}

.colors {
  border: 1px solid black;
  display: inline-flex;
}

.swatch {
  min-width: 16px;
  min-height: 16px;
  max-width: 16px;
  border: 1px solid black;
  display: inline-block;
  margin: 2px;
  cursor: pointer;

}

.highlight {
  border: 1px solid red;
}
    </style>
</head>
<header>

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

</header>
<body style="margin-top: 50px">
    <canvas id="can"></canvas>
    <div class="colors" id="colorSel"></div>
<div style="position: absolute; float:left">
<form id="reportForm" method ="post" action="upload.php" enctype="multipart/form-data">
	<p><input class=".col-4" id="submit" name="submit" type="submit" value="Send"></p>
    </form>
   </div> 
    
<script>
// size of drawing and its starting background colour
const drawingInfo = {
  width: 600 ,
  height: 600,
  bgColor: "white",
}
const brushSizes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
const colors = "Wheat ,Khaki,yellow,Gold,orange,red,Crimson,Brown,BurlyWood,Moccasin,pink,LightCoral,Coral,DeepPink,Magenta,PaleVioletRed,DarkViolet,purple,LightCyan,Chartreuse,green,OliveDrab,DarkGreen,Aquamarine,PowderBlue,SkyBlue,RoyalBlue,Indigo,blue,Teal,SteelBlue,white,gray,DimGray,LightGrey,black".split(",");
var currentColor = "blue";
var currentWidth = 2;
var currentSelectBrush;
var currentSelectColor;
const colorSel = document.getElementById("colorSel");
colors.forEach((color, i) => {
  var swatch = document.createElement("span");
  swatch.className = "swatch";
  swatch.style.backgroundColor = color;
  if (currentColor === color) {
    swatch.className = "swatch highlight";
    currentSelectColor = swatch;
  } else {
    swatch.className = "swatch";
  }
  swatch.addEventListener("click", (e) => {
    currentSelectColor.className = "swatch";
    currentColor = e.target.style.backgroundColor;
    currentSelectColor = e.target;
    currentSelectColor.className = "swatch highlight";
  });
  colorSel.appendChild(swatch);
})
brushSizes.forEach((brushSize, i) => {
  var brush = document.createElement("canvas");
  brush.width = 16;
  brush.height = 16;
  brush.ctx = brush.getContext("2d");
  brush.ctx.beginPath();
  brush.ctx.arc(8, 8, brushSize / 2, 0, Math.PI * 2);
  brush.ctx.fill();
  brush.brushSize = brushSize;
  if (currentWidth === brushSize) {
    brush.className = "swatch highlight";
    currentSelectBrush = brush;
  } else {
    brush.className = "swatch";
  }

  brush.addEventListener("click", (e) => {
    currentSelectBrush.className = "swatch";
    currentSelectBrush = e.target;
    currentSelectBrush.className = "swatch highlight";
    currentWidth = e.target.brushSize;

  });
  colorSel.appendChild(brush);
})


const canvas = document.getElementById("can");
const mouse = createMouse().start(canvas, true);
const ctx = canvas.getContext("2d");
var updateDisplay = true; // when true the display needs updating
var ch, cw, w, h; // global canvas size vars


var currentLine;

var displayOffset = {
  x: 0,
  y: 0
};

// a point object creates point from x,y coords or object that has x,y
const point = (x, y = x.y + ((x = x.x) * 0)) => ({
  x,
  y
});
// function to add a point to the line
function addPoint(x, y) {
  this.points.push(point(x, y));
}

function drawLine(ctx, offset) { // draws a line
  ctx.strokeStyle = this.color;
  ctx.lineWidth = this.width;
  ctx.lineJoin = "round";
  ctx.lineCap = "round";
  ctx.beginPath();
  var i = 0;
  while (i < this.points.length) {
    const p = this.points[i++];
    ctx.lineTo(p.x + offset.x, p.y + offset.y);
  }
  ctx.stroke();
}

function createLine(color, width) {
  return {
    points: [],
    color,
    width,
    add: addPoint,
    draw: drawLine,
  };
}



// creates a canvas
function createCanvas(width, height) {
  const c = document.createElement("canvas");
  c.width = width;
  c.height = height;
  c.ctx = c.getContext("2d");
  return c;
}
// resize main display canvas and set global size vars
function resizeCanvas() {
  ch = ((h = canvas.height = innerHeight - 32) / 2) | 0;
  cw = ((w = canvas.width = innerWidth) / 2) | 0;
  updateDisplay = true;
}

function createMouse() {
  function preventDefault(e) { e.preventDefault() }
  const mouse = {
    x: 0,
    y: 0,
    buttonRaw: 0,
    prevButton: 0
  };
  const bm = [1, 2, 4, 6, 5, 3]; // bit masks for mouse buttons
  const mouseEvents = "mousemove,mousedown,mouseup".split(",");
  const m = mouse;
  // one mouse handler
  function mouseMove(e) {
    m.bounds = m.element.getBoundingClientRect();
    m.x = e.pageX - m.bounds.left - scrollX;
    m.y = e.pageY - m.bounds.top - scrollY;
    
    if (e.type === "mousedown") {
      m.buttonRaw |= bm[e.which - 1];
    } else if (e.type === "mouseup") {
      m.buttonRaw &= bm[e.which + 2];
    }
    // check if there should be a display update
    if (m.buttonRaw || m.buttonRaw !== m.prevButton) {
      updateDisplay = true;
    }
    // if the mouse is down and the prev mouse is up then start a new line
    if (m.buttonRaw !== 0 && m.prevButton === 0) { // starting new line
      currentLine = createLine(currentColor, currentWidth);
      currentLine.add(m); // add current mouse position
    } else if (m.buttonRaw !== 0 && m.prevButton !== 0) { // while mouse is down
      currentLine.add(m); // add current mouse position      
    }
    m.prevButton = m.buttonRaw; // remember the previous mouse state
    e.preventDefault();
  }
  // starts the mouse 
  m.start = function(element, blockContextMenu) {
    m.element = element;

    mouseEvents.forEach(n => document.addEventListener(n, mouseMove));
    if (blockContextMenu === true) {
      document.addEventListener("contextmenu", preventDefault)
    }
    return m
  }
  return m;
}
var cursor = "crosshair";
function update(timer) { // Main update loop
  cursor = "crosshair";
  globalTime = timer;
  // if the window size has changed resize the canvas
  if (w !== innerWidth || h !== innerHeight) {
    resizeCanvas()
  }
  if (updateDisplay) {
    updateDisplay = false;
    display(); // call demo code
  }
 
  ctx.canvas.style.cursor = cursor;
  requestAnimationFrame(update);
}
// create a drawing canvas.
const drawing = createCanvas(drawingInfo.width, drawingInfo.height);
// fill with white
drawing.ctx.fillStyle = drawingInfo.bgColor;
drawing.ctx.fillRect(0, 0, drawing.width, drawing.height);

// function to display drawing 
function display() {
  ctx.clearRect(0, 0, w, h);
  ctx.fillStyle = "rgba(0,0,0,0.25)";
  const imgX = cw - (drawing.width / 2) | 0;
  const imgY = ch - (drawing.height / 2) | 0;
  // add a shadow to make it look nice
  ctx.fillRect(imgX + 5, imgY + 5, drawing.width, drawing.height);

  // add outline
  ctx.strokeStyle = "black";
  ctx.lineWidth = "2";
  ctx.strokeRect(imgX, imgY, drawing.width, drawing.height);
  // draw the image
  ctx.drawImage(drawing, imgX, imgY);
  if (mouse.buttonRaw !== 0) {
    if (currentLine !== undefined) {
      currentLine.draw(ctx, displayOffset); // draw line on display canvas
      cursor = "none";
      updateDisplay = true; // keep updating 
    }
  } else if (mouse.buttonRaw === 0) {
    if (currentLine !== undefined) {
      currentLine.draw(drawing.ctx, {x: -imgX, y: -imgY }); // draw line on drawing
      currentLine = undefined;
      updateDisplay = true;
      // next line is a quick fix to stop a slight flicker due to the current frame not showing the line
      ctx.drawImage(drawing, imgX, imgY);

    }
  }
}

var link = document.createElement('a');
link.innerHTML = 'download image';
link.addEventListener('click', function(ev) {
    link.href = canvas.toDataURL();
	var x = canvas.toDataURL();
    link.download = "mypainting.png";
}, true);
document.body.appendChild(link);

file= link.download;

/*var btn = document.createElement('BUTTON');
    btn.innerHTML = 'upload image';
btn.addEventListener('click', function(ev) {
    var formData = new FormData();
        formData.append("img", canvas.toDataURL());
   const http = new XMLHttpRequest()
        http.open('POST', '')
        http.send(formData) // Make sure to stringify
}, true);
document.body.appendChild(btn);*/


requestAnimationFrame(update);

/* load and add image to the drawing. It may take time to load. */
/*function loadImage(url){
    const image = new Image();
    image.src = url;
    image.onload = function(){
        if(drawing && drawing.ctx){
            drawing.width = image.width;
            drawing.height = image.height;
            drawing.ctx.drawImage(image,0,0);
        };
    }

 }
 loadImage("https://i.stack.imgur.com/C7qq2.png?s=328&g=1");*/
</script>
<a href="javascript:location.reload(true)">new draw</a>


</body>
<!-- Footer -->

<footer class="w3-container w3-padding-32 w3-light-grey w3-center">
  <div class="w3-xlarge w3-section">
    <a href="https://www.facebook.com/artinthecommunityisrael/"> <i class="fa fa-facebook-official w3-hover-opacity"></i></a>
</footer>


</body>
</html>
<script>
    function log_out(){
        window.location='logout.php';
        }
</script>

<script>
<?php
    if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
   
    $fileName       = basename($_FILES["file"]["name"]);
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
 ?>
</script>