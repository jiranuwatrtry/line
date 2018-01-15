<!DOCTYPE html>
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
			// ที่อยู่ของเอกสาร WSDL ของเว็บเซอร์วิส ปตท");
			$wsdl = 'http://www.pttplc.com/webservice/pttinfo.asmx?WSDL';
         
         $Language = $_POST["language"];
		 $DD = $_POST["DD"];
		 $MM = $_POST["MM"];
		 $YYYY = $_POST["YYYY"];
		echo 'Language : '.$Language.'<br>'.'DATE : '.'   '.$DD.'   / '.$MM.'  / '.$YYYY.'<br>';
		
         $client = new SoapClient($wsdl,
		    	array(
			          "trace"      => 1,		// enable trace to view what is happening
			           "exceptions" => 0,		// disable exceptions
			          "cache_wsdl" => 0) 		// disable any caching on the wsdl, encase you alter the wsdl server
		           );

               $params = array(
                   'Language' => $Language,
                   'DD' => $DD,
                   'MM' => $MM,
                   'YYYY' => $YYYY
               );

		        $data = $client->GetOilPrice($params);
              $ob = $data->GetOilPriceResult;
            $xml = new SimpleXMLElement($ob);
           
               // PRICE_DATE , PRODUCT ,PRICE
              foreach ($xml  as  $key =>$val) {  
              
            if($val->PRICE != ''){
              echo $val->PRODUCT .'  '.$val->PRICE.' บาท<br>';
                }

               }
         
         
         ?>
           
   </div>
  
</body>


    
    
</html>
    