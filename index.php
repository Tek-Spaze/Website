
<?php 
	/* The folder 'keys' is ignored in git for security and privacy reasons*/
	require_once("keys/fb.php");

	function rdate($date){
		$tdiff = explode("-",date_diff(date_create($date),new DateTime())->format("%y-%m-%d"));
		if($tdiff[0]==0){
			if($tdiff[1]==0){
				if($tdiff[2]<7){
					if($tdiff[2]==0){
						return "i dag";
					}else{
						return $tdiff[1]." dage siden";
					}
				}else{
					return $tdiff[1]/7 ." uger siden";
				}
			}else{
				return $tdiff[1]." månder siden";
			}
		}else{
			return $tdiff[0]." år siden";
		}
	}

	$jsonPost = file_get_contents('https://graph.facebook.com/tekspace/posts?fields=status_type,message,created_time&access_token='.fb_app_id.'|'.fb_api_key);
	$tposts = json_decode($jsonPost);
	$posts	= [];
	foreach ($tposts->data as $key => $post) {
		if (array_key_exists('message', $post)) {
			array_push($posts, array (
				"message"	=> $post->message,
				"href"		=> "https://www.facebook.com/tekspace/posts/".explode('_', $post->id)[1],
				"rdate"		=> rdate($post->created_time)
			));
		}
	}
?>
<html>
<head>
	<title>TEK-SPACE</title>
	<link rel="icon" href="favicon.png" type="image/png"/>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/jq.js"></script>
</head>
<body>
<div id="main-grid">
	<div class="header">
		<div class="rings">
			<span class="staticbox">
				<img src="img/minilogo.png">
			</span>
			<span class="ring one"></span>
			<span class="ring two"></span>
			<span class="ring three"></span>
			<span class="ring four"></span>
		</div>
	</div>
	<div class="menuicon">
		<img class="shadow" src="img/menu.png">
	</div>
	<div class="fb">
	<?php
		for ($i=0; $i < 5; $i++) { 
			echo "<p class='shadow'>".$posts[$i]['message']."<br><a href='".$posts[$i]['href']."' target='_blank'><br>	".$posts[$i]['rdate']."</a></p>";
		}
	?>
	</div>
	<div class="content shadow">
		<h2>Hvad er Tek-Space?</h2>
		<p> Tek-Space er et kreativt værksted, et miljø, hvor du kan lege med skøre ideer, møde andre kreative mennesker, og bygge på lige netop det projekt, du har lyst til.</p>
		<p> Måske vil du gerne bygge en lille robot ud af en fjernstyret bil, måske vil du gerne montere elektronikken fra en mobiltelefon i en gammeldags telefon med drejeskive, programmere en AI til iPhone eller noget helt andet.
		</p>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function(){$(".rings").addClass('loaded')}, 200);
})



</script>
</body>

</html>