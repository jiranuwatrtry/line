<html lang="en">
	<head>
		<title>PTT WEB SERVICE</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">



<style>

*{margin:0;padding:0;}

                        

</style>

  
</head>                  

<body>
       <div style="max-width:100%;width:400px;margin:auto;">
         <h3>ราคานำ้มันวันนี้</h3>
    
         <?php

// สร้าง object 
// URL ของ webservice
$client = new SoapClient("http://www.pttplc.com/webservice/pttinfo.asmx?WSDL", 
	array(
		   "trace"      => 1,	// enable trace to view what is happening
		   "exceptions" => 0,	// disable exceptions
		  "cache_wsdl" => 0) 	// disable any caching on the wsdl, encase you alter the wsdl server
	   );
               
$lang = 'en';
$day = '11';
$month ='01';
$year ='2018';

// ตัวแปลที่ webservice ต้องการสำหรับ GetOilPriceResult เป็นวันเดือนปีและ ภาษา  
$params = array(
	'Language' => "en",
	'DD' => date($day),
    'MM' => date($month),
    'YYYY' => date($year)
    );

// เรียกใช้ method GetOilPrice และ ใส่ตัวแปลเข้าไป 
$data = $client->GetOilPrice($params);

//เก็บตัวแปลผลลัพธ์ที่ได้
$ob = $data->GetOilPriceResult;

// เนื่องจากข้อมูลที่ได้เป็น string(ในรูปแบบ xml) จึงต้องแปลงเป็น object ให้ง่ายต่อการเข้าถึง
$xml = new SimpleXMLElement($ob);

// attr  PRICE_DATE , PRODUCT ,PRICE

echo "Language = $lang , Date = $day $month $year <br><br>";
//loop เพื่อแสดงผล
foreach ($xml  as  $key =>$val) {
	// ถ้าไม่มีราคาก็ไม่ต้องแสดงผล เนื่องจากมีบางรายการไม่มีราคา   
	if($val->PRICE != ''){
	echo $val->PRODUCT .'  '.$val->PRICE.' baht.<br>';
	}

}

?>
           
   </div>
  
</body>


    
    
</html>
    
