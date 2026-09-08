
<?php

			function getuserdata($username){
			     global $conn;
			     $queryyu = "SELECT * FROM `stores` WHERE `id`='$username'";
                 $results = mysqli_query($conn, $queryyu);
   
                 if(mysqli_num_rows($results) == 1){
                      $sdsds = mysqli_fetch_array($results);
                      return $sdsds['phone'];
                 }
                 else{ 
                     
                     echo "User ". $username . "not found in database!";
                     exit();

                 }
                 
                 
			   
			}
			
			
			
			function sendorderconfirmcall($phone, $rowwid){
			    
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://ipcall.bd/callbroadcast/foodcollections.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'key=MksdjsjdsnjcdccudcdJsw83&phone='.$phone.'&type=marchantinform&orderid='. $rowwid,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
			}






	$sname = "localhost";
	$unmae = "foodcol2_foodcoss";
	$password = "ch22UXqLsdyPwe198";
	$db_name = "foodcol2_foodcoss";
	
	$conn = mysqli_connect($sname, $unmae, $password, $db_name);
	if (!$conn) {
	 echo "connection failed!";
	}





$sql = "SELECT * FROM `orders` WHERE `order_status` = 'confirmed' AND `call_status` IN (100,101, 102) ORDER BY FIELD(`call_status`, 100,101,102) LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        
        $userid = $row['store_id'];
        $rowwid = $row['id'];
        $updatestatus = $row['call_status'] + 1;

        $sql6 = "UPDATE `orders` SET `call_status`=888 WHERE `id` =$rowwid";
        mysqli_query($conn, $sql6);
        
        echo $userid;
        
        $userdata = getuserdata($userid);
        
        $number = str_replace("+88", "", $userdata);

        echo "<br>" . $number;
        $updates = sendorderconfirmcall($number, $rowwid);
        
        $updatesarray = json_decode($updates, true);
        
        var_dump($updatesarray);
        
        
        //exit();
        if($updatesarray['success'] === true){
            
            $sql6 = "UPDATE `orders` SET `call_status`=200 WHERE `id` =$rowwid";
            mysqli_query($conn, $sql6);
            
        }else{
            
            $sql6 = "UPDATE `orders` SET `call_status`=$updatestatus WHERE `id` =$rowwid";
            mysqli_query($conn, $sql6);
        }
        
        


        
        
    }
}








?>