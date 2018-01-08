<?php
$access_token = 'v8+dLBrQQq0eb26mIOI8TSJjhxsJFrAOaDz1MdncVOyRqv7mdtPTI6fxa6YsJbU16n40F+OTHzWarptr9kYgRGPZbxC+RvXYKPyG+uKxfExyvkfzap7Hw90e/E+IOofq0cv2a+ShZSR4DY3d/uJbGgdB04t89/1O/w1cDnyilFU=';

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

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text."จ้า"
				
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
$client = new SoapClient("http://www.pttplc.com/webservice/pttinfo.asmx?WSDL", // URL ของ webservice
		    	array(
			           "trace"      => 1,		// enable trace to view what is happening
			           "exceptions" => 0,		// disable exceptions
			          "cache_wsdl" => 0) 		// disable any caching on the wsdl, encase you alter the wsdl server
		           );
               


         // ตัวแปลที่ webservice ต้องการสำหรับ GetOilPriceResult เป็นวันเดือนปีและ ภาษา  
               $params = array(
                   'Language' => "th",
                   'DD' => date('08'),
                   'MM' => date('01'),
                   'YYYY' => date('2018')
               );

              // เรียกใช้ method GetOilPrice และ ใส่ตัวแปลเข้าไป 
              $data = $client->GetOilPrice($params);
              
              //เก็บตัวแปลผลลัพธ์ที่ได้
              $ob = $data->GetOilPriceResult;
              
             // เนื่องจากข้อมูลที่ได้เป็น string(ในรูปแบบ xml) จึงต้องแปลงเป็น object ให้ง่ายต่อการเข้าถึง
              $xml = new SimpleXMLElement($ob);
           
             // attr  PRICE_DATE , PRODUCT ,PRICE
            //loop เพื่อแสดงผล  
            foreach ($xml  as  $key =>$val) {  
            
              // ถ้าไม่มีราคาก็ไม่ต้องแสดงผล เนื่องจากมีบางรายการไม่มีราคา   
              if($val->PRICE != ''){
              echo $val->PRODUCT .'  '.$val->PRICE.' บาท<br>';
                }

               }
