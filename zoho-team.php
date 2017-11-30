<?php 
//Get active users in CRM
header("Content-type: application/xml");
$token="123456"; //Your token
$url = "https://crm.zoho.com/crm/private/xml/Users/getUsers";
$param= "authtoken=".$token."&scope=crmapi&type=ActiveUsers";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
?>