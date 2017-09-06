<html>
<head>
	<title>TEK-SPACE</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/jq.js"></script>
</head>
<body>

<div class="rings">
	<span class="staticbox">
		<img src="img/minilogo.png">
	</span>
	<span class="ring one"></span>
	<span class="ring two"></span>
	<span class="ring three"></span>
	<span class="ring four"></span>
	
	<!--
	<span class="bubbles">
		<span class="bubble b1" apc-pid="1">1</span>
		<span class="bubble b2" apc-pid="2">2</span>
		<span class="bubble b3" apc-pid="3">3</span>
		<span class="bubble b4" apc-pid="4">4</span>
		<span class="bubble b5" apc-pid="5">5</span>
	</span>
	-->	
</div>
kage

<?php

include("code/stripe/init.php");

\Stripe\Stripe::setApiKey("SECRET KEY");

$products = \Stripe\Product::all();

?>

<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function(){$(".rings").addClass('loaded')}, 200);

	var prods = <?php echo substr($products, 24); ?>;
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