<?php
require_once("code/config.php");
require_once( ROOT . "code/keys/fb.php");
session_start();

function rdate($date){
  $tdiff = explode("-",date_diff(date_create($date),new DateTime())->format("%y-%m-%d"));
  if($tdiff[0]==0){
    if($tdiff[1]==0){
      if($tdiff[2]<7){
        if($tdiff[2]==0){
          return "i dag";
        }else{
          return $tdiff[2]." dage siden";
        }
      }else{
        return $tdiff[2]/7 ." uger siden";
      }
    }else{
      return $tdiff[1]." månder siden";
    }
  }else{
    return $tdiff[0]." år siden";
  }
}

function head($title="Tek-space"){
  if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
    $loggedin = true;
  }else{
    $loggedin = false;
  }

  ?>
  <html>
  <head>
  	<title>TEK-SPACE</title>
  	<link rel="icon" href="/file/png/favicon" type="image/png"/>
  	<link rel="stylesheet" type="text/css" href="/file/css/main">
  	<script type="text/javascript" src="/file/js/jq"></script>
  </head>
  <body>
  <div id="main-grid">
  	<div class="header">
  		<div class="rings">
  			<span class="staticbox">
  				<img src="/file/png/minilogo">
  			</span>
  			<span class="ring one"></span>
  			<span class="ring two"></span>
  			<span class="ring three"></span>
  			<span class="ring four"></span>
  		</div>
  	</div>

  	<div id="menuicon" class="card-1">
  		<a href="/">Forside</a>
      <a href="/pizza">Pizza</a>
  		<a href="/projects">Projekter</a>
  		<a href="https://drive.google.com/drive/folders/0B8xJgnZAr6LsNmhBVlNjWUZYc28" target="_blank">Offentlige dokumenter</a>
  	</div>
  	<?php if(!$loggedin){ ?>
  		<div id="menuiconuser" class="card-1"><a class="s-in">Sign in</a><a class="s-up">Sign up</a></div>
  		<div id="sign-in">
  			<form action="/signin" method="post">
  				<input class="field" type="mail" placeholder="Email" name="email"/>
  				<input class="field" type="password" placeholder="Password" name="pass">
  				<button class="btt"  type="submit">Sign in</button>
  			</form>
  			<div id="back"></div>
  		</div>
  	<?php } else{?>
  		<div id="menuiconuserl"><a class="login-link" href="/user/"><?php echo $user["name"]?></a></div>
  	<?php } ?>

  	<div class="fb">

  	<?php
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
  		for ($i=0; $i < 5; $i++) {
  			echo "<p class='card-1'>".$posts[$i]['message']."<br><a href='".$posts[$i]['href']."' target='_blank'><br>	".$posts[$i]['rdate']."</a></p>";
  		}
  	?>
  	</div>
  	<div class="content">
    <?php
}
?>
