<?php


function getSunData($location){
    try {
        $date = date('Y-m-d');
        $apiKey = 'YOUR API KEY';
    
        $url = "https://api.weatherapi.com/v1/astronomy.json?key=$apiKey&q=$location&dt=$date";
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
    
        
        curl_close($ch);
        
        $result = json_decode($result,true);
        
        if(isset($result['error'])){
            echo json_encode(['success'=>false, 'message'=> 'Enter City Name Only']);
            exit();
        }
        
        $sunrise = DateTime::createFromFormat('h:i A', $result['astronomy']['astro']['sunrise']);
        $sunset = DateTime::createFromFormat('h:i A', $result['astronomy']['astro']['sunset']);
    
        $diff = $sunset->diff($sunrise);
    
        echo json_encode(['success'=>true, 'hours'=>(int)($diff->format('%h'))-2, 'minutes'=>(int)($diff->format('%i'))]);
        exit();
    } catch (Exception $e) {
        echo json_encode(['success'=>false, 'message'=> 'Something Went Wrong']);
        exit();
    }
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true);
    if( isset( $data['location'] ) ){
        getSunData( $data['location'] );
    }
}
        
        
        // getSunData( '1');
?>