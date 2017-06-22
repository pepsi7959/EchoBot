<?php
$access_token = 'HWbSOXBHsXaZ6ohJESJp7w9d8Nw6s1aqb7YUbx+yAZgr+JIUR/erXpUv2Wf5cC+YrFdeWk0eKn0e49WhmaOp6bHg0sV0Ym9tR6LZ95gwf+77iRrDIx7VQ9AKDvqpE4hj8oZ5jfFAPoQCzvX1Ww+9aQdB04t89/1O/w1cDnyilFU=';

function ask($msg){
	global $access_token;
	$url = 'http://ask.pannous.com/api?input='.urlencode($msg).'&locale=en_US&timeZone=420&login=test-user&ip=fe80:0:0:0:9068:1693:742:472&botid=0&key=guest&exclude=Dialogues,ChatBot&out=json&clientFeatures=show-images,reminder,say&debug=true';
	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	//echo $result . "\r\n";
	$ret_result=json_decode($result, true);
	//echo "---->\r\n\r\n".$ret_result['output'][0]['actions']['say']['text']; 
	return $ret_result['output'][0]['actions']['say']['text'];
}


// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Ask Pandora 
			$answer = ask($text);
			
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $answer
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
