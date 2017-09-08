<html>
<head>
	<title>TEK-SPACE</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon"/>
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
	<div class="content">
		<h2>Hvad er Tek-Space?</h2>
		<p> Tek-Space er et kreativt værksted, et miljø, hvor du kan lege med skøre ideer, møde andre kreative mennesker, og bygge på lige netop det projekt, du har lyst til.</p>
		<p> Måske vil du gerne bygge en lille robot ud af en fjernstyret bil, måske vil du gerne montere elektronikken fra en mobiltelefon i en gammeldags telefon med drejeskive, programmere en AI til iPhone eller noget helt andet.
		</p>
	</div>
</div>
<?php
/*
include("code/stripe/init.php");

\Stripe\Stripe::setApiKey("SECRET KEY");

$products = \Stripe\Product::all();
*/
?>

<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function(){$(".rings").addClass('loaded')}, 200);
	/*
	var prods = <?php //echo substr($products, 24); ?>;
	//console.log(prods);
	prods.data.forEach(function(element) {
    	console.log(element.name);
    	console.log(element.skus.data[0].price/100 + " " + element.skus.data[0].currency);
	});

/*$(".bubbles .bubble").mouseenter(function(e){
	$(".bubbles .bubble.active").removeClass('active');
	$(this).addClass('active');
	$(".staticbox .viewer.show").removeClass('show');
	var pid = $(this).attr("apc-pid");
	$(".staticbox .viewer[apc-pid=" + pid +"]").addClass("show");
})*/

})



</script>
</body>

</html>