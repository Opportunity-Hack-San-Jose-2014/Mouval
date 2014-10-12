<?php
// This is the API, 2 possibilities: show the app list or show a specific app by id.
// This would normally be pulled from a database but for demo purposes, I will be hardcoding the return values.
function get_db_result($query){
$con=mysqli_connect("localhost","root","","wordpress");

// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	return $result = mysqli_query($con,$query);
    
    
}
function get_by_location($keyword,$location,$phone_number)
{
  $app_info = array();
  
  $q=build_query($keyword,$location);

  $res=get_db_result($q);
  $send_message="";
  while($row = mysqli_fetch_array($res)) {
                
        $send_message.=$row['post_title']."\r";
        $var_input = strstr($row['meta_value'],"\"");
        
        $len=strlen($var_input);
        $var_input2 =substr($var_input,1,$len-1);
        
    $var1 = unserialize($var_input2);
    $send_message.=$var1["address"]."\r";
    $send_message.=$var1["phone"]."\r";
    $send_message.=$var1["email"]."\r";
    $send_message.=$var1["website"]."\r\r";        
    }
  echo $send_message;
  $phone_number=substr($phone_number,2);
  $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
    $msg = $phone_number;
    fwrite($myfile, $msg);
    fclose($myfile);
  echo $send_message;
  send_message($send_message,$phone_number);	

}

function build_query($keyword,$location){
	$qry="SELECT wp_posts.post_title, meta_value
	FROM wp_postmeta, wp_posts, (

	SELECT table1.ID
	FROM (

	SELECT wp_posts.ID
	FROM `wp_term_relationships` , `wp_terms` , `wp_posts` 
	WHERE wp_term_relationships.term_taxonomy_id = wp_terms.term_id
	AND wp_terms.name LIKE '%".$location."%'
	AND wp_posts.ID = wp_term_relationships.object_id
	) AS table1, (

	SELECT wp_posts.ID
	FROM `wp_term_relationships` , `wp_terms` , `wp_posts` 
	WHERE wp_term_relationships.term_taxonomy_id = wp_terms.term_id
	AND wp_terms.name LIKE '%".$keyword."%'
	AND wp_posts.ID = wp_term_relationships.object_id
	) AS table2
	WHERE table1.ID = table2.ID
	)table3
	WHERE wp_posts.ID = table3.ID
	AND wp_postmeta.post_id = wp_posts.ID
	AND wp_postmeta.meta_key = 'directory_meta' LIMIT 0,3";
	return $qry;
}
function get_by_zip($keyword,$zip,$phone_number){
	$country="";
	echo $phone_number;
#   if(strcmp ( strstr($phone_number,0,2), "+1") == 0){	   
   if( substr($phone_number,0,2) === "+1"){	   
   		echo "inside if";
   		
   		$phone=substr($phone_number,2);
   		echo $phone_number;
	   	$country="US";	
   }elseif( substr($phone_number,0,3) === "+62"){
   		echo "inside else";   		
   		$phone=substr($phone_number,3);
      	$country="Indonesia";	
   }
   $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=" .$zip."+".$country."&key=AIzaSyDT2_1dWMCEpbnNKEDR4HcPoSKZWXER354";
    echo $details_url."<br>";
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $details_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $geoloc = json_decode(curl_exec($ch), true);   
   $result = curl_exec($ch);
   $location1 = $geoloc['results'][0]['address_components'][2]['long_name'];
   curl_close($ch);  
   $q=build_query($keyword,$location1);
   
  $res=get_db_result($q);
  $send_message="";
  while($row = mysqli_fetch_array($res)) {
                
        $send_message.=$row['post_title']."\r";
        $var_input = strstr($row['meta_value'],"\"");
        
        $len=strlen($var_input);
        $var_input2 =substr($var_input,1,$len-1);
        
    $var1 = unserialize($var_input2);
    $send_message.=$var1["address"]."\r";
    $send_message.=$var1["phone"]."\r";
    $send_message.=$var1["email"]."\r";
    $send_message.=$var1["website"]."\r\r";        
    }
  echo $send_message;
  $phone_number=substr($phone_number,2);
  $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
    $msg = $phone_number;
    fwrite($myfile, $msg);
    fclose($myfile);
  echo $send_message;
  send_message($send_message,$phone);	

}

function get_by_address($message,$phone_number)
{
  $first_word = strstr($message,0,9);
  $rest_of_words = strstr($message," ");
  $input= explode (",",$rest_of_words);
  $keyword = $input[0];
  $address = $input[1];
  $cityclean = str_replace (" ", "+", $address);
  echo $address;
  $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=" .$cityclean ."&key=AIzaSyDT2_1dWMCEpbnNKEDR4HcPoSKZWXER354";

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $details_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $geoloc = json_decode(curl_exec($ch), true);   
   $result = curl_exec($ch);

	echo $geoloc['results'][0]['address_components'][3]['long_name'];
	curl_close($ch);  
}
function send_message($message,$phone){
	echo $phone;
	$ch = curl_init();
	$curlConfig = array(
    	CURLOPT_URL            => "http://textbelt.com/text",
	    CURLOPT_POST           => true,
    	CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POSTFIELDS     => array(
        'number' => $phone,
        'message' => $message,
    	)
	);
	curl_setopt_array($ch, $curlConfig);

	$result = curl_exec($ch);
	curl_close($ch);
	$responseData = json_decode($result);
	echo $result;
	echo $responseData->{'success'};		

}

function get_by_keyword($message,$phone_number)
{
  //normally this info would be pulled from a database.
  //build JSON array
  $phone_number = substr($phone_number, -10);

  $phone_prefix = 
  $app_list = array(array("id" => 1, "location" => "123 ABC St"), array("id" => 2, "location" => "456 sample st"), array("id" => 3, "location" => "san jose"), array("id" => 4, "name" => "Music Sleep Timer")); 

  return $app_list;
}

$possible_url = array("get_by_keyword", "get_by_location","get_by_address");



/*  if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
 {
    switch ($_GET["action"])
      {
        case "get_by_keyword":
          if (isset($_GET["message"]) && isset($_GET["number"]))
  	        $value = get_by_keyword($_GET["message"],$_GET["number"]);
          else
            $value = "Missing argument";
          break;

        case "get_by_location":
          if (isset($_GET["message"]) && isset($_GET["number"]) )
            $value = get_by_location($_GET["message"],$_GET["number"]);
          else
            $value = "Missing argument";
          break;
        case "get_by_address":
          if (isset($_GET["message"]) && isset($_GET["number"]) )
            $value = get_by_address($_GET["message"],$_GET["number"]);
          else
            $value = "Missing argument";
          break;  
      }
  }*/
 if (isset($_GET["message"]) && isset($_GET["number"])){
     $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    $msg = $_GET["message"];
    fwrite($myfile, $msg);
    fclose($myfile);
    
    $first_word = strstr($_GET["message"],0,9);
	$rest_of_words = strstr($_GET["message"]," ");
    $input= explode (",",$rest_of_words);
    $keyword = $input[0];
	$parameter = $input[1];

    $trimmed_parameter=trim($parameter);
        echo $keyword.trim($parameter);
    if (is_numeric($trimmed_parameter)) {
	    get_by_zip($keyword,$trimmed_parameter,$_GET["number"]);
    }else{
	    get_by_location($keyword,$parameter,$_GET["number"]);    
    }

 }

?>