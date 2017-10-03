<?php 
if(isset($_POST["email"]) && isset($_POST["pass"])){

	require_once "code/config.php";
	require_once ROOT . "/code/model/user.php";

	$user = userExists($_POST["email"], $_POST["pass"]);

	if($user['exists']){
		session_start();
		$_SESSION['user'] = $user;
		header("Location: /");
	}else {
		echo "Something went wrong :(";
	}
}else {
	echo "Something went wrong :(";
}
?>