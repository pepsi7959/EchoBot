<?php
	$question = $_GET['question'];
	$url = "http://ask.pannous.com/api?input=".urlencode($question)."&locale=en_US&timeZone=420&login=test-user&ip=fe80:0:0:0:9068:1693:742:472&botid=0&key=guest&exclude=Dialogues,ChatBot&out=json&clientFeatures=show-images,reminder,say&debug=true";
	$headers = array('Content-Type: application/json','Connection: keep-alive','Connection: close');
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	$ret_result=json_decode($result, true);
	//echo "---->\r\n\r\n".$ret_result['output'][0]['actions']['say']['text']; 
	if( $ret_result == NULL ){
		echo "I have no answer.";
	}else{
		echo $ret_result['output'][0]['actions']['say']['text'];
	}
?>
