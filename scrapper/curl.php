<?php 
error_reporting(0);

function get_client_ip() {
$ipaddress = '';
if (isset($_SERVER['HTTP_CLIENT_IP'])) {
	$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
} else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
	$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
} else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
	$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
} else if(isset($_SERVER['HTTP_FORWARDED'])) {
	$ipaddress = $_SERVER['HTTP_FORWARDED'];
} else if(isset($_SERVER['REMOTE_ADDR'])) {
	$ipaddress = $_SERVER['REMOTE_ADDR'];
} else {
	$ipaddress = 'UNKNOWN';
}
return $ipaddress;
}

$externalIpAdress = get_client_ip();

class cURL {
    function getheader($url) {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
        curl_setopt($process, CURLOPT_HTTPHEADER, array('X-Forwarded-For: ' .$externalIpAdress,));
        curl_setopt($process, CURLOPT_HEADER, 1);
        curl_setopt($process, CURLOPT_TIMEOUT, 60);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_NOBODY, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($process,CURLOPT_CAINFO, NULL);
        curl_setopt($process,CURLOPT_CAPATH, NULL);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }

    function get($url) {
        $process = curl_init($url); 
        curl_setopt($process, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($process, CURLOPT_HTTPHEADER, array('X-Forwarded-For: ' .$externalIpAdress,));
        curl_setopt($process, CURLOPT_TIMEOUT, 60); 
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }

    function post($url, $data) {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
        curl_setopt($process, CURLOPT_HTTPHEADER, array('X-Forwarded-For: ' .$externalIpAdress,));
        curl_setopt($process, CURLOPT_TIMEOUT, 60);
        curl_setopt($process, CURLOPT_POST, TRUE);
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }

}
?>