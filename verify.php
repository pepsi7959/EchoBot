<?php
$access_token = 'xTYSjesloGzLAnGw7/e9yQ4RoFhGXwpaFug74sxvoP0Xi3l7Y+jYQPUPtj5Ef3hweFCWfoFpfDktf5jJ23TLOwtzaFrKuQxMeQUU3jkAv1r6R+scZ8ASvkQ2qhTNSd6kgBn5bFIHtZ5SgP3GezsSAQdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
