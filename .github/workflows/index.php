<?php
// $arr_browsers = ["Opera", "Edg", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
 
// $agent = $_SERVER['HTTP_USER_AGENT'];
 
// $user_browser = '';
// foreach ($arr_browsers as $browser) {
//     if (strpos($agent, $browser) !== false) {
//         $user_browser = $browser;
//         break;
//     }   
// }
  



// if ($user_browser =="Chrome") {
  
//     echo "You are using  browser";
// }else {
//     echo "You are not using  browser";
// }
  



// function get_browser_name($user_agent){
//     $t = strtolower($user_agent);
//     $t = " " . $t;
//     if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;   
//     elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;   
//     elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;   
//     elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;   
//     elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;   
//     elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet_Explorer';
//     return 'Unkown';
// }




// if (get_browser_name($_SERVER['HTTP_USER_AGENT']) =="Internet_Explorer") {
//      echo "You are using  browser";
//  }else {
//      echo "You are not using  browser";
//  }
// function getIp(){
//     if(!empty($_SERVER['HTTP_CLIENT_IP'])){
//       $ip = $_SERVER['HTTP_CLIENT_IP'];
//     }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
//       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     }else{
//       $ip = $_SERVER['REMOTE_ADDR'];
//     }
//     return $ip;
//   }
//   echo 'The client\'s IP address is : '.getIp();



//   function get_client_ip() {
//     $ipaddress = '';
//     if (isset($_SERVER['HTTP_CLIENT_IP']))
//         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
//     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED'];
//     else if(isset($_SERVER['REMOTE_ADDR']))
//         $ipaddress = $_SERVER['REMOTE_ADDR'];
//     else
//         $ipaddress = 'UNKNOWN';
//     return $ipaddress;
// }

// echo 'The client\'s IP address is : '.get_client_ip();



// $url = "https://api.myip.com/";

// $curl = curl_init($url);
// $resp = curl_exec($curl);


// echo $curl; 

function ip_visitor_country()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $country  = "Unknown";
    $city  = "Unknown";

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=".$ip);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $ip_data_in = curl_exec($ch); // string
    curl_close($ch);

    $ip_data = json_decode($ip_data_in,true);
    $ip_data = str_replace('&quot;', '"', $ip_data); // for PHP 5.2 see stackoverflow.com/questions/3110487/

    if($ip_data && $ip_data['geoplugin_countryName'] != null) {
        $country = $ip_data['geoplugin_countryName'];
        $city = $ip_data['geoplugin_city'];
    }

    return '{"ip": "'.$ip.'", "Country": "'.$country.'", "city": "'.$city.'"}';
}

echo ip_visitor_country(); // output Coutry name

?>
