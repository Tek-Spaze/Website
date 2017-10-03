<?php
$url = 'https://api.particle.io/v1/devices/7ab7c791cf0033ba91bd90b2/GetTemp';
$data = array('arg' => '', 'access_token' => '19b35e3a0e7b51e4b1f72d374d0b3a78103d741e');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$jresult = file_get_contents($url, false, $context);
if ($jresult === FALSE) { /* Handle error */ }
$result = json_decode($jresult);
echo $result->return_value;
?>