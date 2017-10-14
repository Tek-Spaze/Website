<?php
function footer(){
  ?>
  </div>
  <script type="text/javascript">
  $(document).ready(function(){
  	setTimeout(function(){$(".rings").addClass('loaded')}, 200);

  	$('.s-in').click(function(){
  		$("#sign-in").addClass("swoop");
  		$("#menuicon").addClass("swoop");
  		$("#menuiconuser").addClass("swoop");
  	});
  	$('#back').click(function(){
  		$("#sign-in").removeClass("swoop");
  		$("#menuicon").removeClass("swoop");
  		$("#menuiconuser").removeClass("swoop");
  	});
  	$('.s-up').click(function(){
  		$(".popup").fadeIn(200);
  	});
  	$('#popup').click(function(){
  		$(".popup").fadeOut(200);
  	});

  })
  </script>
    </body>
    </html>
  <?php
}
?>
