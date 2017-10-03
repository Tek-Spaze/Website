<!DOCTYPE html>
<html>
<head>
	<title>Particle test</title>
	<script type="text/javascript" src="/file/js/jq"></script>
	<style type="text/css">
		body {
		    background: #29434e;
		    font-family: arial;
		    color: #000;
		    margin-bottom: 1em;
		}
		.main{
			width: 400px;
			height: 140px;
			padding: 20px;
			position: fixed;
			left: 50%;
			top: 50%;
			margin-left: -220px;
			margin-top:  -90px;
			background: #fff;
			-webkit-border-radius: 2pt;
			border-radius: 2pt;
		}
	</style>
</head>
<body>
<div class="main">
	<p>Particle test, press the button to get the temperature of the cpu on my Pi!<p>
	<button onclick="get_temp()">Przz mi plz</button>
	<p class="result"></p>
</div>
<script type="text/javascript">
	function get_temp() {
		$.get("particle-test.php", function( data ) {
  			$(".result").html(data + " degrees!");
	});
	}

</script>
</body>
</html>