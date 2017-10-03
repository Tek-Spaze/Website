<?php
if(!defined('ROOT')){
	header('Location: /error.php');
}


function userCreate($name, $email, $password, $cardnr){
	require ROOT . 'code/db.php';
	include ROOT . 'code/PasswordStorage.php';
	$passh = PasswordStorage::create_hash($password);
	try{
	    $query = $db->prepare("INSERT INTO `tek_space_dk`.`ts_users`(`name`, `email`, 	`passhash`) VALUES (?,?,?)");
	    $query->bindParam(1, $name,	 PDO::PARAM_STR);
	    $query->bindParam(2, $email, PDO::PARAM_STR);
	    $query->bindParam(3, $passh, PDO::PARAM_STR);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return false;
	}

	/*$token = sha1($name.$email.rand(1000,9999));
	
	try{
	    $query = $db->prepare("INSERT INTO `tekspaze`.`tkspz-tokens`(`user_id`, `token`) VALUES ((SELECT id FROM `tekspaze`.`tkspz-users` WHERE email = ?),?)");
	    $query->bindParam(1, $email, PDO::PARAM_STR);
	    $query->bindParam(2, $token, PDO::PARAM_STR);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return false;
	}*/

	try{
	    $query = $db->prepare("INSERT INTO `tek_space_dk`.`ts_ucards`(`user_id`, `card_number`) VALUES ((SELECT user_id FROM `tek_space_dk`.`ts_users` WHERE email = ?),?)");
	    $query->bindParam(1, $email, PDO::PARAM_STR);
	    $query->bindParam(2, $cardnr, PDO::PARAM_STR);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    var_dump($e);
	    return false;
	}

	return true;
}
function userExists($email, $password){
	require ROOT . 'code/db.php';
	include ROOT . 'code/PasswordStorage.php';
	try{
	    $query = $db->prepare("SELECT * FROM `tek_space_dk`.`ts_users` WHERE email = ?");
	    $query->bindParam(1, $email,	 PDO::PARAM_STR);
	    $query->execute();
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return array("exists"=>false);
	}

	$result = $query->fetch(PDO::FETCH_ASSOC);

	if ($result) {
		if(PasswordStorage::verify_password($password, $result['passhash']))
			return array('exists'=>true, 'id'=>$result['user_id'], 'name'=>$result['name'], 'email'=>$result['email'], 'verified'=>$result['verified']);
	}
	return array('exists'=>false);
}

function userCardExists($cardnr){
	require ROOT . 'code/db.php';
	try{
	    $query = $db->prepare("SELECT * FROM `tek_space_dk`.`ts_users` WHERE card_number = ?");
	    $query->bindParam(1, $cardnr, PDO::PARAM_STR);
	    $query->execute();
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    var_dump($e);
	}

	$result = $query->fetch(PDO::FETCH_ASSOC);

	if ($result) {
		return array('exists'=>true, 'id'=>$result['user_id'], 'name'=>$result['name'], 'email'=>$result['email'], 'wallet'=>$result['wallet']);
	}

	try{
	    $query = $db->prepare("SELECT * FROM `tek_space_dk`.`ts_ucards`");
	    $query->execute();
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    var_dump($e);
	    return array("exists"=>false);
	}

	$user_id = false;
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        if(strpos($cardnr, $row['card_number']) !== false){
        	$user_id = $row['user_id'];
        }
    }
    if($user_id !== false){

    	try{
		    $query = $db->prepare(" UPDATE `tek_space_dk`.`ts_users` SET `card_number` = ? WHERE user_id = ?");
		    $query->bindParam(1, $cardnr, PDO::PARAM_STR);
		    $query->bindParam(2, $user_id, PDO::PARAM_STR);
		    $query->execute(); 
		}catch(Exception $e){
		    echo "Could not retrieve data from database.";
		    var_dump($e);
		    return false;
		}
		try{
		    $query = $db->prepare("SELECT * FROM `tek_space_dk`.`ts_users` WHERE card_number = ?");
		    $query->bindParam(1, $cardnr, PDO::PARAM_STR);
		    $query->execute(); 
		}catch(Exception $e){
		    echo "Could not retrieve data from database.";
		    var_dump($e);
		    return false;
		}
		try {
			$result = $query->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			var_dump($e);
		}
		

		if ($result) {
			return array('exists'=>true, 'id'=>$result['user_id'], 'name'=>$result['name'], 'email'=>$result['email'], 'wallet'=>$result['wallet']);
		}
    }
	return array('exists'=>false);
}

function userBuyProduct($userID, $price){
	require ROOT . 'code/db.php';
	try{
	    $query = $db->prepare("SELECT * FROM `tek_space_dk`.`ts_users` WHERE user_id = ?");
	    $query->bindParam(1, $userID, PDO::PARAM_STR);
	    $query->execute();
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    var_dump($e);
	    return array("error"=>true);
	}
	try {
			$result = $query->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			var_dump($e);
	}

	if ($result) {
		if($result['wallet'] < $price){
			return array('error' => true);
		}
	}

	try{
	    $query = $db->prepare("UPDATE `tek_space_dk`.`ts_users` SET wallet = IF(wallet >= ?, wallet - ?, wallet) WHERE user_id = ?");
	    $query->bindParam(1, $price,  PDO::PARAM_STR);
	    $query->bindParam(2, $price,  PDO::PARAM_STR);
	    $query->bindParam(3, $userID, PDO::PARAM_STR);
	    $query->execute();
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return false;
	}
	return array('error' => false);
}
?>