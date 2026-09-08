<?php
header('Content-Type: application/json');


	$sname = "localhost";
	$unmae = "foodcol2_foodcoss";
	$password = "ch22UXqLsdyPwe198";
	$db_name = "foodcol2_foodcoss";
	
	$conn = mysqli_connect($sname, $unmae, $password, $db_name);
	if (!$conn) {
	 echo "connection failed!";
	}


if (!isset($_GET['number'])) {
    echo json_encode(['status' => false, 'message' => 'number missing']);
    exit;
}

$number = trim($_GET['number']);

// +88 বা 88 রিমুভ করা
$clean = preg_replace('/^\+?88/', '', $number);

// সময় সেট করা
date_default_timezone_set('Asia/Dhaka');
$currentTime = date('Y-m-d H:i:s');
$timeLimit = date('Y-m-d H:i:s', strtotime('-30 minutes'));

// phone_verifications এ চেক করা
$sql = "
SELECT * FROM phone_verifications 
WHERE (
    phone = '$clean' 
    OR phone = '0$clean' 
    OR phone = '88$clean' 
    OR phone = '+88$clean'
)
AND smsstatus = 0
AND currenttss BETWEEN '$timeLimit' AND '$currentTime'
LIMIT 1
";

$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $id = $row['id'];

    // smsstatus update করা
    $update = "UPDATE phone_verifications SET smsstatus = 1 WHERE id = '$id'";
    mysqli_query($conn, $update);

    echo json_encode(['status' => true, 'message' => 'smsstatus updated']);
    exit;
}

// যদি phone_verifications এ না মেলে, users টেবিলে চেক করা
$sql2 = "
SELECT * FROM users 
WHERE (
    phone = '$clean' 
    OR phone = '0$clean' 
    OR phone = '88$clean' 
    OR phone = '+88$clean'
)
LIMIT 1
";

$res2 = mysqli_query($conn, $sql2);

if (mysqli_num_rows($res2) > 0) {
    echo json_encode(['status' => true, 'message' => 'user exists']);
    exit;
}

// কিছু না পেলে
echo json_encode(['status' => false, 'message' => 'no record found']);
?>
