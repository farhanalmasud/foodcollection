<?php

echo "aaaa";
exit();
	$sname = "localhost";
	$unmae = "foodcol2_foodcoss";
	$password = "ch22UXqLsdyPwe198";
	$db_name = "foodcol2_foodcoss";
	
	$conn = mysqli_connect($sname, $unmae, $password, $db_name);
	if (!$conn) {
	 echo "connection failed!";
	}


$sql = "SELECT * FROM `users` WHERE `zone_id`='4' AND `order_count` > 0";

$result = mysqli_query($conn, $sql);

// === 2. Loop through each SMS ===
while ($sms = mysqli_fetch_assoc($result)) {
    
    
    echo $sms['phone'] ."<br>";
}

?>