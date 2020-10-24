<?php
require_once('../include_/dbconnect.php');

// // html and css variables
$color1 = "#333";
$page_title = "Eat in PDX";
$page_description = "A list of my favorite places to eat at in Portland, Oregon. I hope you enjoy these recommendations.";
$page_keywords = "Map,Food,Eat,Portland,Oregon,PDX,OR";
$page_name = "eatPDX.php";
$page_author = "Brandon Booth";
$page_image = "projects_eatPDX.png";
$twitter_link = "Where%20to%20eat%20in%20Portland,%20Oregon.";
$table_name = "eatPDX";
$last_update = "Spring 2020";



// // =========================================
// // = SF

// // html and css variables
// $color1 = "#333"; //grey
// $page_title = "Eat in SF";
// $page_description = "A list of my favorite places to eat at in San Francisco, California. ";
// $page_keywords = "Map,Food,Eat,San Francicso,California,SF,CA";
// $page_name = "eatdrinkSF.php";
// $page_author = "Brandon Booth";
// $page_image = "projects_eatSF.png";
// $twitter_link = "Where%20to%20eat%20in%20San%20Francisco,%20California.";
// $table_name = "eaSF";
// $last_update = "Spring 2020"
// // =========================================


// =========================================
// = SF

// // html and css variables
// $color1 = "#333"; //grey
// $page_title = "Eat in PDX";
// $page_description = "A list of my favorite places to eat at in Portland, Oregon. ";
// $page_keywords = "Map,Food,Eat,Portland,Oregon,PDX,OR";
// $page_name = "eatPDX.php";
// $page_author = "Brandon Booth";
// $page_image = "projects_eatPDX.png";
// $twitter_link = "Where%20to%20eat%20in%20Portland,%20Oregon.";
// $table_name = "eatPDX";
// $last_update = "Spring 2020"
// // =========================================



// Return the number of rows in result set
$query = "SELECT * FROM ".$table_name;
$result = mysqli_query($conn,$query);	
$rowcount=mysqli_num_rows($result);
$fieldcount = mysqli_field_count($conn);

/* Get field information for all columns */
$finfo = $result->fetch_fields();

// foreach ($finfo as $val) {
//     printf("Name:      %s\n",   $val->name);
//     printf("Table:     %s\n",   $val->table);
//     printf("Max. Len:  %d\n",   $val->max_length);
//     printf("Length:    %d\n",   $val->length);
//     printf("charsetnr: %d\n",   $val->charsetnr);
//     printf("Flags:     %d\n",   $val->flags);
//     printf("Type:      %d\n\n", $val->type);
// }
$ctr = 0;

foreach ($finfo as $val) {
	$field[$ctr] = $val->name;
	$ctr = $ctr + 1;
}

for ($y = 1; $y <= $rowcount; $y++) {
	$query = "SELECT * FROM ".$table_name." WHERE col1 =". $y . ";";
	$results = mysqli_query($conn,$query);
	$row = mysqli_fetch_row($results);

	for ($x = 1; $x <= $fieldcount; $x++) {
		${'r' . $y. 'c'. $x} = $row[$x-1];
		${'r' . $y. 'c'. $field[$x-1]} = $row[$x-1];
	}
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $page_title ?></title>
	<meta charset="UTF-8">
	<?php echo
	'
	<meta name="description" content="'.$page_description.'">
	<meta name="keywords" content="'.$page_keywords.'">
  	<meta name="author" content="Brandon Booth">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!-- Open Graph protocol - used for social media -->
	<meta property="og:title"              content="'.$page_title.'" />
	<meta property="og:description"        content="'.$page_description.'" />
	<meta property="og:type"               content="article" />
	<meta property="og:url"                content="https://brandon-booth.com/'.$page_name.'" />
	<meta property="og:image"              content="https://brandon-booth.com/img/'.$page_image.'" />
	'
	?>
	<link rel="icon" href="/img/V8_BB_white.png">
  	<link rel="icon" type="image/png" sizes="16x16" href="img/V8_BB_white.png">
  	<link rel="icon" type="image/png" sizes="32x32" href="img/V8_BB_white.png">

	<link rel="apple-touch-icon" href="/img/V8_BB_white.png">

	<meta name="apple-mobile-web-app-title" content="BB Splash">
  	<meta name="apple-mobile-web-app-capable" content="yes">
  	<meta name="apple-mobile-web-app-status-bar-style" content="default">

  	<!-- iPhone Xs Max (1242px x 2688px) --> 
  	<link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" href="/img/bb_splash_1242x2688.png"> 
  	<!-- iPhone Xr (828px x 1792px) --> 
  	<link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" href="/img/bb_splash_828x1792.png">
  	<!-- iPhone X, Xs (1125px x 2436px) --> 
  	<link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" href="/img/bb_splash_1125x2436.jpg"> 
  	<!-- iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus (1242px x 2208px) --> 
  	<link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" href="/img/bb_splash_1242x2208.png"> 
  	<!-- iPhone 8, 7, 6s, 6 (750px x 1334px) --> 
  	<link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" href="/img/bb_splash_750x1334.png">  
  	<!-- iPad Pro 12.9" (2048px x 2732px) --> 
  	<link rel="apple-touch-startup-image" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" href="/img/bb_splash_2048x2732.png"> 
  	<!-- iPad Pro 11” (1668px x 2388px) --> 
  	<link rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" href="/img/bb_splash_1668x2388.png"> 
  	<link rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" href="/img/bb_splash_1668x2224.png"> 
  	<!-- iPad Mini, Air (1536px x 2048px) --> 
  	<link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" href="/img/bb_splash_1536x2048.png">

  	<!-- iPad Pro 10.5" (1668px x 2224px) --> 
  	<link rel="apple-touch-icon" sizes="180x180" href="/img/V8_BB_white.png">
  	<link rel="mask-icon" href="/img/V8_BB_white.png" color="#6F6F6F">
  	<meta name="msapplication-TileColor" content="#00aba9">
  	<meta name="theme-color" content="#ffffff">

  	<!-- Link to icon lib -->
  	<script src='https://kit.fontawesome.com/a076d05399.js'></script>

  	<!-- Link to google icon lib -->
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  	<!-- navbar css -->
  	<link rel="stylesheet" href="/css/navbar_maps.css">

	<!-- service worker manifest -->
  	<link rel="manifest" href="/manifest.json">

  	<!-- google maps api script google login: brandon.daniel.booth@gmail.com-->
	<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBsY6CdzKZtRcZuI4NpJNxvnW9mO138LC8&language=us"></script> -->

	<!-- #  -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDqQ5QCW1O24SmvkaQBhLJtfHFrYPN9QSM&language=us"></script>

	
<style>
	
/*+++++++++++++++++++page specific css+++++++++++++++++++*/
html, body {
	font-family: -apple-system, BlinkMacSystemFont, sans-serif;
	font-size: small;
	margin: 0;
	padding: 0;
	height: auto;
	width: 100%;
	background-color: #333;
}
	
header {
  	font-size: 12pt;
	font-weight: 100;
	background: white;
}

a {
	text-decoration:none;
	color: <?php echo $color1; ?>;
}

.mobspace {
	background-color: #333;
	height: 0vh;
	z-index: 0;
	position: sticky;
	top: 60px;
}

.bold{
	font-weight: bold;
	color: #333;
}

.mobile_content_top{
	visibility: hidden;
	position: fixed;
	top: calc(25vh + 60px); 
	/*	position: -webkit-sticky;   safari*/
	text-align: center;
	margin-left: 0%;
	width: 100%;
	height: 11px;
	background: <?php echo $color1; ?>;
	z-index: 10; 
	/*opacity: 0.5;*/
	text-align: center;
}

.stickytop{
	visibility: hidden;
	position: fixed;
	top: 0px; 
	/*	position: -webkit-sticky;   safari*/
	/*	text-align: center;    */
	margin-left: 0%;
	width: 100%;
	height: 45px;
	background: white;
	z-index: 4;
	padding-top: 7px;
}
	
.shareicontop{
	float: left;
	/*margin-top: 12px;*/
	/*margin-bottom: 12px;*/
	/*margin-right: 10px;*/
	/*margin-left: 15%;*/
	font-weight: 400;
	/*width:100%;*/
	background: white;
	margin-left: 15%; 
	margin-right: 5px; 
	margin-top: 12px; 
	float: left;
}

.shareicon{
	margin-top: 10px; float: left;
}

.topbox {
	background-color: <?php echo $color1; ?>;
	padding: 5px;
	color: white;
}
	
.textcolor1{
	color: <?php echo $color1; ?>;
}
		
.textcolor2{
	color: #777777;
}

.smalltext{
	font-size: 10pt;
	font-weight: 100;
	padding-left: 10px;
	padding-bottom: 5px;
}

.textpadding{
	padding-top: 5px; 
	padding-left: 10px; 
}

.p1{
	font-weight: 600;
	font-size: 28pt;
    padding-left: 10px;
    padding-right: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
}
   
.p2{
	font-weight: 100;
	font-size: 12pt;
	padding-left: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
}

.linkbuttons{
	font-size: 16pt;
	font-weight: 100;
    height: 35px;
    width: auto;
    padding-left: 5px;
    padding-bottom:20px;
    background-color: white;
}



.icon_holder { 
    text-align:center;
    float:left;
    vertical-align:middle;
	width:30px;
	height:30px;
	margin-right:10px;
	display:inline-block; 
	border-radius:40px; 
	border: 1px solid;
	border-color:#333; 
	box-shadow: 0px 0px 1px #333; 
	padding: 0.2em 0.2em;
}


.floated, .inside {
	width:auto;
    height:30px;
    /*border:1px #ccc solid;*/  
    text-align:center;
    float:left;
    vertical-align:middle;
    display:table-cell;
	margin-top: 5px;
    margin-left:5px;
	margin-right:0px;
	padding-right: 3px;
	color: white;
	background-color:  <?php echo $color1; ?>;
}

.inside { 
    float:none;
    border:none;
}

.buttonicon{
	padding-top: 2px;
	padding-left: 2px;
}

.buttonicon2{
	padding-top: 2px;
	padding-left: 2px;
 }
.buttonicon3{
	padding-top: 3px;
	padding-left: 2px;
}

.sticky {
	position: fixed;
	top: 60px;
	height: 100%;
	right: 0;
	left: 0;
	bottom: 0;
	width: 100%;
	z-index: 3;
}
	
.map_keep {
	height: calc(100vh - 50px);  
	width: 100%;
}
	

#map {
	font-family: Nobel;
	font-size: small;
	margin: 0;
	padding: 0;
	height: 100%;
	width: 100%;
}
	
.container   {
	left: 0%;
	width:450px;
	height: auto;
	/*  max-width: 50%;   */
	/*  height: 500px;    */
	background-color: white;
	/*  border: 1px solid tomato;*/
	/*	opacity: 0.5;*/
	/*  border: 1px solid red;      */
	margin: 20px;
	/*	box-shadow: 1px 1px 1px grey;*/	
	font-size: 135%;
	padding: 0;
	visibility: visible;
	pointer-events: all;
	position: relative;
	z-index: 3;
    /*	background-image: url("img/containerbackground.jpg");*/	
	}
		
	.thumbnail img {
		width: 100%;
		/*    margin-bottom: 10px;    */
	}

@media only screen and (max-width: 600px) {
	
	header {
    	position: relative;
	}
	
	.mobspace{
		height: calc(25vh - 0px);	
	}
	
	.sticky {
		/*height: 35vh;*/
		height: calc(25vh + 30px);
		/*top: calc(35vh + 60px);*/
		width: 100vw;
		top: 30px;
	}
	
	.mobile_content_top{
    	visibility: visible;
    }
	
	.stickytop{
    	visibility: visible;
    }
	
	#map {
		font-family: Nobel;
		font-size: small;
		height:100%;
		width: 100%;
		margin: 0;
		padding: 0;		
	}
	
	.map_keep {
		width: 100%;
		/*   height: calc(50vh - 50px); */
		height: 100%;
		top: 0%;
		margin: 0;
	}
	
	.container   {
		z-index: 1;
		width: 100%;
		/*	border-top: 2px solid #D63100;
		border-bottom: 2px solid #D63100;*/
		margin-top: 1px;	
		margin-bottom: 5px;
		margin-left: 0px;
		margin-right: 0px;
	}
	
	.thumbnail img {
		width: 100%;
		bottom: 0%;
	}

}

</style>
</head>

<body>
	<header>
		<div class="navcontainer">
			<a href="index.html" class="navlogo">
				<img src="img/V8_BB_white.png" width="40" height="40">
			</a>
			<nav class="site-nav">
				<ul>
					<li><a href="https://brandon-booth.com/" class="textcolor1"><i class="fa fa-home site-nav--icon"></i>Home</a></li>
				</ul>
			</nav>
		</div>
	</header>  

<!-- bar below map - used to get distance from top in mobile view -->
<div id="ystart" class="mobile_content_top"></div>

<!-- Message bar behind NavBar -->
<div class="stickytop textcolor2">
	<div width="20" height="20"  class="shareicontop textcolor2">
		<span class="bold"><?php echo $page_title ?></span> - SHARE
	</div>
<?php echo
'
	<a class="shareicon" href="https://twitter.com/intent/tweet?url=https%3A%2F%2Fwww.brandon-booth.com%2F'.$page_name.'&text='.$twitter_link.'">
		<img src="img/share_twittericon.png" alt="twitter" width="20" height="20">
	</a>
	<a class="shareicon" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fbrandon-booth.com%2F'.$page_name.'&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">
		<img src="img/share_facebookicon.png" alt="facebook" width="20" height="20">
	</a>
</div>
'
?>
<!-- space behind map on mobile -->
<div id="x" class="mobspace"></div> 

<!-- map -->
<div class="sticky">
	<div class="map_keep">
		<div id="map"></div>
	</div>
</div>

<!----------------------------------------- Header Content Box ----------------------------------------------------------->
<div class="container" onclick="mapc();">
	<div class= "smalltext topbox"></div>
	<div class="p1 textcolor1 textpadding"><?php echo $page_title ?></div>
	<div class="p2 textcolor2 textpadding"><?php echo $page_description ?></div>
	<div class="p2 textcolor2"><span>By </span><span class="textcolor1"><?php echo $page_author ?></span><span> | </span><span class="textcolor1"><?php echo $last_update ?></span></div>
</div>

<!-----------------------------------------Content Boxes ----------------------------------------------------------->

<?php 
for ($rownum = 1; $rownum <= $rowcount; $rownum++) {
	echo
	'
	<!-- Content Box'.$rownum.'-->
	<div id="b'.$rownum.'"class="container">
		<div id="y'.$rownum.'"></div>
		<div class="p1 textpadding"><span class="textcolor1">' . ${'r' . $rownum .'cname'} .'</span></div>
		<div class="p2 textcolor2">' .  ${'r' . $rownum .'caddress'} .'</div>
		<div class="p2 textcolor2"><span>Price: </span><span class="textcolor1 bold">' .  ${'r' . $rownum .'cprice_range'} . '</span><span>' .  ${'r' . $rownum .'cprice_range_grey'} . '</span></div>



		<div style="padding: 0px 10px 10px 10px; font-size: 16px;">
			<span>yelp</span>							
			<i class="fab fa-yelp" style="font-size:16px; color:#d32323;"></i>
			<span> : </span>
			<span class="textcolor1">' .  ${'r' . $rownum .'cyelp_rating'} .'</span>
			<img class="" src="img/yelp_stars/web_and_ios/small/small_' .  ${'r' . $rownum .'cyelp_stars'} . '.png" alt="" width="" height="">	
			<span class="textcolor2">' .  ${'r' . $rownum .'cyelp_review_count'} . ' Reviews</span>
		</div>	







		
		<div class="" style="padding: 0px 10px 10px 10px; font-size: 16px;">
			<i class="fab fa-google" style="font-size:16px; color:#4285F4;"></i><span style="color:#DB4437;">o</span><span style="color:#F4B400;">o</span><span style="color:#4285F4;">g</span><span style="color:#0F9D58;">l</span><span style="color:#DB4437;">e</span>
			<span>: </span><span class="textcolor1">' .  ${'r' . $rownum .'cgoogle_rating'} .'</span>
			<span class="material-icons" style="font-size:16px;vertical-align: -2px;color:#FDCC0D">' .  ${'r' . $rownum .'cgoogle_stars'} .' ' .  ${'r' . $rownum .'cgoogle_stars_grey'} . '</span>
			<span class="textcolor2">' .  ${'r' . $rownum .'cgoogle_review_count'} . ' Reviews</span>

		</div>







		<div class="thumbnail">
			<img data-src="' . ${'r' . $rownum .'cphoto'}. '" alt="TBD">
		</div>
			<a name="'.$rownum.'"></a>
			<div class="p2 textcolor2"><span class="textcolor1"></span><span>Photo: </span><span class="textcolor1">'. ${'r' . $rownum .'cphoto_credit'} . '</span><span class="textcolor1"></span></div>
			<div class="linkbuttons">



			<!---	

				<a href="' . ${'r' . $rownum .'cwebsite'} . '">
					<div class="icon_holder">  
							<i class="fab fa-safari" style="font-size:22px; color:#333; margin-top: 5px;; "></i>
					</div>
				
					<span class="icon_holder fa-stack fa-2x">
						<i class="far fa-circle fa-stack-2x"></i>
						<i class="fab fa-linkedin fa-stack-1x"></i>
				  	</span>
				</a>

				<a href="' . ${'r' . $rownum .'cgoogle_maps_link'} . '">
					<div class="icon_holder">  
							<i class="fas fa-images" style="font-size:20px; color:#333; margin-top: 5px;"></i>
					</div>

					<span class="icon_holder fa-stack fa-2x">
						<i class="far fa-circle fa-stack-2x"></i>
						<i class="fab fa-linkedin fa-stack-1x"></i>
				  	</span>

				</a>

				<a href="' . ${'r' . $rownum .'cgoogle_maps_link'} . '">
					<div class="icon_holder">  
							<i class="fas fa-directions" style="font-size:22px; color:#333; margin-top: 5px; "></i>
					</div>
					<span class="icon_holder fa-stack fa-2x">
						<i class="far fa-circle fa-stack-2x"></i>
						<i class="fab fa-linkedin fa-stack-1x"></i>
				  	</span>
				</a>

				-->








				
				<div align="left">
						
				<a aria-label="Safari" href="' . ${'r' . $rownum .'cwebsite'} . '">
				  <span class="media_button fa-stack">
					<i class="far fa-circle fa-stack-2x"></i>
					<i class="fab fa-safari fa-stack-1x"></i>
				  </span>
				</a>
		
				<a aria-label="Images" href="' . ${'r' . $rownum .'cgoogle_maps_link'} . '">
				  <span class="media_button fa-stack">
					<i class="far fa-circle fa-stack-2x"></i>
					<i class="media_button_icon fas fa-images fa-stack-1x"></i>
				  </span>
				</a>
		
				<a aria-label="Directions" href="' . ${'r' . $rownum .'cgoogle_maps_link'} . '">
				  <span class="media_button fa-stack">
					<i class="far fa-circle fa-stack-2x"></i>
					<i class="media_button_icon fas fa-directions fa-stack-1x"></i>
				  </span>
				</a>
		
			  </div>






		<!---			
	
				<a href="' . ${'r' . $rownum .'cfull_website'} . '">
					<div class="floated">  
						<div class="inside">
							<img class="buttonicon" src="img/website_icon.png" alt="website" width="20" height="20">
						</div>
						<div class="inside">WEBSITE</div>
					</div>
				</a>

				<a href="' . ${'r' . $rownum .'cgoogle_maps_link'} . '">
					<div class="floated">  
						<div class="inside">
							<img class="buttonicon2" src="img/directionicon.png" alt="website" width="18" height="18">
						</div>
						<div class="inside">DIRECTIONS</div>
					</div>
				</a>
				
				<a href="' . ${'r' . $rownum .'cinstagram_link'} . '">
					<div class="floated">  
						<div class="inside">
							<img class="buttonicon3" src="img/instagramiconwhite.png" alt="website" width="20" height="20">
						</div>
						<div class="inside">PHOTOS</div>
					</div>
				</a>
-->


			</div>
		</div>
	</div>
	';}
	?>

	<!-----------------------------------------Footer Content Box -------------------------------------------------->
	<div class="container">
		<div class="p1 textpadding"><span class="textcolor1">Let me know what you think.</span></div>
		<div class="p2 textcolor2"><span>Contact me</span>
			<span><a class="textcolor1" href="mailto:brandon.booth@yahoo.com?Subject=Hello%20" target="_top">here</a>
			</span>
			<span></span>
		</div>
	</div>	


<script>
var go = 0;	
window.addEventListener('scroll', function() { 
	var relposition = [];
	var topidPos = document.getElementById('ystart').getBoundingClientRect();
	var ipos = 1;

	for (ipos = 1; ipos < "<?php echo $rowcount ?>"; ipos++) {
		var Posin = document.getElementById('y'+ipos).getBoundingClientRect();
		relativePos = {};					
		relativePos.top = Posin.top - topidPos.top;
		relposition.push(relativePos.top); //push to relposition
	}

	var i;
	for (i = 0; i < "<?php echo $rowcount ?>"; i++) {	
		if(go != i) {
			if (relposition[i] < 100 && relposition[i] > -325) {
				outall();
				z=i+1;
				hover(z);
				go = i;
			}
		}
	}
});
</script>

<!-- +++++++++++++++++++++++++++++++google map below+++++++++++++++++++++++++++++++++++++ -->
<script>
	
	window.onscroll = function() {myFunction();};

	function myFunction() {

	}
	var icon1 = "img/mapicon_back.png";
	var icon2 = "img/mapicon_front.png";
	var allMarkers = [];

	<?php 
	for ($row = 1; $row <= $rowcount; $row++) {
		echo
		'var marker'.$row.'lat = '.${'r' . $row .'clat'}.';'.
		'var marker'.$row.'lng = '.${'r' . $row .'clng'}.';'
		;}
		?> 

		function initialize() {
			var points = [{ lat: marker1lat, lng: marker1lng }, { lat: marker2lat, lng: marker2lng }, { lat: marker3lat, lng: marker3lng }],
			sel_point = 0;

			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 13,
				center: points[sel_point],

				scrollwheel:false,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControl: false,
				mapTypeControlOptions: {
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
					position: google.maps.ControlPosition.TOP_CENTER
				},
				zoomControl: true,
				zoomControlOptions: {
					position: google.maps.ControlPosition.RIGHT_CENTER
				},
				scaleControl: true,
				streetViewControl: false, 
				fullscreenControl: false,
				fullscreenControlOptions: {
					position: google.maps.ControlPosition.RIGHT_TOP
				}
			});


// markers--------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>	
// markers--------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>	
// markers--------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

var getPositionAtCenter = function (element) {
	var data = element.getBoundingClientRect();
	return {
//x: data.left,//+ data.width / 2,
x: data.bottom,
y: data.top //+ data.height / 2 - 126
};
};



var getDistanceToTop = function (a) {
	var aPosition = getPositionAtCenter(a);

	return (aPosition.y);
};

<?php 
for ($marker = 1; $marker <= $rowcount; $marker++) {
	echo
	'var distance'.$marker.'abs = getDistanceToTop(document.getElementById("b'.$marker.'"));'
	;} 
	?>



	var topspace = -250;
//alert('window.innerWidth= '+window.innerWidth);
if (window.innerWidth < 600) {
	topspace = -250;
// alert('1topspace= '+topspace);
}
else {
	topspace = -80;
//alert('2topspace= '+topspace);
}




<?php 
for ($marker = 1; $marker <= $rowcount; $marker++) {
	echo
	'var marker'.$marker.' = new google.maps.Marker({'.
	'position: new google.maps.LatLng(marker'.$marker.'lat, marker'.$marker.'lng),'.
	'map: map,'.
	'id: '.$marker.','.
	'icon: icon1,'.
	'title: "'.$marker.'"'.
	'});'.
	'allMarkers.push(marker'.$marker.');'.

	'marker'.$marker.'.addListener(\'click\', function() {'.
	'outall();'.
	'hover('.$marker.');'.
	'window.scrollBy(0, -100000000);'.
	'document.getElementById(\'b'.$marker.'\').scrollIntoView();'.
	'window.scrollBy(0, topspace);'.
	'});'
	;}

	?>
}

google.maps.event.addDomListener(window, 'load', initialize);

function mapc() {            
	map.panTo(new google.maps.LatLng(37.7603, -122.3900));
return false; //this will cancel your navigation                   
}

//Function called when hover the div
function hover(id) {
//     alert("Step#0 - function Hover(id) was called");
for (var i = 0; i < allMarkers.length; i++) {
	if (id === allMarkers[i].id) {
//alert("Step#1 - Marker Icon");
allMarkers[i].setIcon(icon2);
allMarkers[i].setZIndex(5);
//allMarkers[i].setZIndex(50);
//var position = allMarkers[i].position;
//alert(position);
var lat = allMarkers[i].getPosition().lat();
var lng = allMarkers[i].getPosition().lng();
//alert("lat: "+ lat + "lng: " + lng);






	// var mapObject = new google.maps.Map(document.getElementById("map"), _mapOptions);
	var zoom = map.getZoom();
	// map.getCameraPosition().zoom
	// alert(zoom);


	if (window.innerWidth < 600){
		map.panTo(new google.maps.LatLng(lat, lng));
	} else {

		if (zoom > 19) {
			map.panTo(new google.maps.LatLng(lat, lng - 0.0001));
		} 		
		else if (zoom > 16) {
			map.panTo(new google.maps.LatLng(lat, lng - 0.0005));
		} 		
		else if (zoom > 13) {
			map.panTo(new google.maps.LatLng(lat, lng - 0.005));
		}
		else {
			map.panTo(new google.maps.LatLng(lat, lng - 0.05));
		}
	}

}
} 
}

//Function called when out the div
function out(id) {
	for (var i = 0; i < allMarkers.length; i++) {
		if (id === allMarkers[i].id) {
			allMarkers[i].setIcon(icon1);
//allMarkers[i].setZIndex(10);
break;
}
}
}

//Function called when out the div
function outall() {
	for (var i = 0; i < allMarkers.length; i++) {
		allMarkers[i].setIcon(icon1);
		allMarkers[i].setZIndex(1);
	}
}
</script>

<script>
	function opendd() {
		var x = document.getElementById("dropDIV");
		if (x.style.display === "block") {
			x.style.display = "none";
		} else {
			x.style.display = "block";
		}
	}
</script>

<script>
	function func1() {
		/*alert("This is the first.");*/
		hover(1);
	}
	window.onload=func1;	
</script>


<script src="/js/lazy-load.js"></script>

<!-- Service Worker Navigator-->
<script src="/js/app.js"></script> 

</body>
</html>