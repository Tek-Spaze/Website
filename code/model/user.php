<?php
if(!defined('ROOT')){
	header('Location: /error.php');
}
include ROOT . 'code/PasswordStorage.php';

function userCreate($name, $email, $password){
	require ROOT . 'code/db.php';
	$passh = PasswordStorage::create_hash($password);
	try{
	    $query = $db->prepare("INSERT INTO `tekspaze`.`tkspz-users`(`name`, `email`, `passhash`) VALUES (?,?,?)");
	    $query->bindParam(1, $name,	 PDO::PARAM_STR);
	    $query->bindParam(2, $email, PDO::PARAM_STR);
	    $query->bindParam(3, $passh, PDO::PARAM_STR);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return false;
	}

	$token = sha1($name.$email.rand(1000,9999));
	
	try{
	    $query = $db->prepare("INSERT INTO `tekspaze`.`tkspz-tokens`(`user_id`, `token`) VALUES ((SELECT id FROM `tekspaze`.`tkspz-users` WHERE email = ?),?)");
	    $query->bindParam(1, $email, PDO::PARAM_STR);
	    $query->bindParam(2, $token, PDO::PARAM_STR);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return false;
	}

	return true;
}
function userExists($email, $password){
	require ROOT . 'code/db.php';
	try{
	    $query = $db->prepare("SELECT * FROM `tekspaze`.`tkspz-users` WHERE email = ?");
	    $query->bindParam(1, $email,	 PDO::PARAM_STR);
	    $query->execute();
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return array("exists"=>false);
	}

	$result = $query->fetch(PDO::FETCH_ASSOC);

	if ($result) {
		if(PasswordStorage::verify_password($password, $result['passhash']))
			return array('exists'=>true, 'name'=>$result['name'], 'email'=>$result['email'], 'verified'=>$result['verified']);
	}
	return array('exists'=>false);
}

?>