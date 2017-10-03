
<?php 
	/* The folder 'keys' is ignored in git for security and privacy reasons*/
	require_once("code/config.php");
	require_once( ROOT . "code/keys/fb.php");

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

	$jsonPost = file_get_contents('https://graph.facebook.com/tekspace/posts?fields=status_type,message,created_time&access_token='.FB_APP_ID.'|'.FB_API_KEY);
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
	<link rel="stylesheet" type="text/css" href="file/css/main">
	<script type="text/javascript" src="file/js/jq"></script>
</head>
<body>
<div id="main-grid">
	<div class="header">
		<div class="rings">
			<span class="staticbox">
				<img src="file/png/minilogo">
			</span>
			<span class="ring one"></span>
			<span class="ring two"></span>
			<span class="ring three"></span>
			<span class="ring four"></span>
		</div>
	</div>
	<div id="menuicon" class="card-1">
			<a href="/">Forside</a>
			<a href="/projects">Projekter</a>
			<a href="https://drive.google.com/drive/folders/0B8xJgnZAr6LsNmhBVlNjWUZYc28" target="_blank">Offentlige dokumenter</a>
	</div>
	<div id="menuiconuser" class="card-1"><a>Sign in</a></div>
	<div class="fb">
	<?php
		for ($i=0; $i < 5; $i++) { 
			echo "<p class='card-1'>".$posts[$i]['message']."<br><a href='".$posts[$i]['href']."' target='_blank'><br>	".$posts[$i]['rdate']."</a></p>";
		}
	?>
	</div>
	<div class="content">
		<div class="card-1">
			<h2>Hvad er Tek-Space?</h2>
			<p> Tek-Space er et kreativt værksted, et miljø, hvor du kan lege med skøre ideer, møde andre kreative mennesker, og bygge på lige netop det projekt, du har lyst til.</p>
			<p> Måske vil du gerne bygge en lille robot ud af en fjernstyret bil, måske vil du gerne montere elektronikken fra en mobiltelefon i en gammeldags telefon med drejeskive, programmere en AI til iPhone eller noget helt andet.
			</p>
		</div>
		<div class="card-1">
			<h2>Hvornår er TEK-Space åbent?</h2>
			<p>TEK-Space afholdes en aften om ugen, skiftevis tirsdag og onsdag i robotlaboratoriet RoboLab på Syddansk Universitet. Du kan se en oversigt over aftenerne i TEK-Space kalenderen. Med mindre andet er anført ovenfor, er der åbent kl. 17.30-21.30. Nogle af aftenerne bliver der desuden holdt et oplæg for interesserede. Se mere om det i kalenderen.</p>
		</div>
		<div class="card-1">
			<h2>Hvem kan være med i TEK-Space?</h2>
			<p>TEK-Space er åbent for alle interesserede, der er fyldt 18 år. Det er selvfølgelig en forudsætning, at du overholder ordensreglerne samt anvisninger fra laboratoriets ansatte. Vi har endnu ikke begrænsning på antallet, men det kan måske blive aktuelt senere, så skynd dig at komme med 🙂</p>
			<p>TEK-Space er sjovest, hvis du bruger det aktivt, dvs. det er dig selv, der skal finde på et projekt og udføre al arbejdet. Du kan få hjælp til det praktiske og også gode ideer og råd til, hvordan du løser problemer indenfor elektronik, software, metalarbejde mv. Mangler du en ide til et projekt, så kig forbi. Vi har RoboCard print på lager.</p>
		</div>
	</div>
</div>
<div class="popup" id="popup"></div>
<div class="popup" id="puwin">kage</div>
<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function(){$(".rings").addClass('loaded')}, 200);

		$('#menuiconuser').click(function(){
			$(".popup").fadeIn(200);
		});
		$('#popup').click(function(){
			$(".popup").fadeOut(200);
		});

	})
</script>
</body>
</html>