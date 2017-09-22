<?php 
require 'code/config.php';

include ROOT . 'code/model/user.php';

print_r(userExists("benjamin.lyderik@gmail.com", "6504"));

userCreate("Ida","ida.burgaard@gmail.com","1234");


?>