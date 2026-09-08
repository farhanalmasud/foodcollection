<?php


if (isset($_GET['orderid']) && isset($_GET['status']) && isset($_GET['key'])) {
    
    $orderid = $_GET['orderid'];
    $status  = $_GET['status'];
    $key     = $_GET['key'];
    $timess = date("Y-m-d H:i:s");




	$sname = "localhost";
	$unmae = "foodcol2_foodcoss";
	$password = "ch22UXqLsdyPwe198";
	$db_name = "foodcol2_foodcoss";
	
	$conn = mysqli_connect($sname, $unmae, $password, $db_name);
	if (!$conn) {
	 echo "connection failed!";
	}



    // Check if key is correct
    if ($key === "flemsoft") {

        // Status must be 1 or 2 only
        if ($status == 1) {
            // echo "Valid Request. OrderID: $orderid, Status: $status";
            
            
            
            
            $sql6 = "UPDATE `orders` SET `call_status`=100, `order_status`='confirmed', `updated_at` ='$timess', `confirmed`='$timess' WHERE `id` =$orderid";
            mysqli_query($conn, $sql6);
            
            
            
        } else if ($status == 2) {
            // echo "Valid Request. OrderID: $orderid, Status: $status";
            
            
            $sql6 = "UPDATE `orders` SET `call_status`=111, `order_status`='canceled', `updated_at` ='$timess', `canceled`='$timess', `canceled_by`='admin', `cancellation_reason`='Customer Requested to cancel using Auto IVR' WHERE `id` =$orderid";
            mysqli_query($conn, $sql6);
            
            
            
        } else {
            echo "Invalid Status. Must be 1 or 2.";
        }

    } else {
        echo "Invalid Key or OrderID.";
    }

} else {
    echo "Required parameters missing.";
}

exit();
?>



<?php
// file name set kore dilam
$filename = "data.txt";

// $_GET array ke string e convert kori
$data = "";
foreach($_GET as $key => $value){
    $data .= $key . " = " . $value . "\n";
}

// file e save kori
file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);

echo "Data saved successfully!";
?>
