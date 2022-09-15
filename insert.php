<?php
require './vendor/autoload.php';
$redis = new Predis\Client();
/**--------set get-------***/
// $rand = 'B106F860';
// $time = Date('H:m:s A');
// $newentry = '';
// $i = rand(99,999);
// ${"user_" . $i} = "user_" . $i;
// $conn_ = new mysqli('localhost', 'necrodrow_ct_cuc', '9276FAKISLF', 'necrodrow_ct_cuc');
//     $sql_ = "INSERT INTO logs (UniqueID, Enter_Time,Position,Role,Exit_Time,Date,Method,Covid)  
//     VALUES ( '$rand ' , '$time','Student','Form5',NULL,'2022-09-15','QR','0' )";

//     $conn_->query($sql_);

//     $newentry .= $rand . ': ' . $time .' STAFF <br>';

//     $redis->set("${"user_" . $i}", $newentry);

// echo ${"user_" . $i}.'<br>';
// echo "New entry added:".$newentry;


/**--------lpush-------***/
// $rand = 'U555F860';
// $time = Date('H:m:s A');
// $newentry = [];

// $conn_ = new mysqli('localhost', 'necrodrow_ct_cuc', '9276FAKISLF', 'necrodrow_ct_cuc');
//     $sql_ = "INSERT INTO logs (UniqueID, Enter_Time,Position,Role,Exit_Time,Date,Method,Covid)  
//     VALUES ( '$rand ' , '$time','Student','Form5',NULL,'2022-09-15','QR','0' )";

//     $conn_->query($sql_);
//     $newentry[] = array($rand => array("Time"=>$time));
//     $redis->lpush('array',json_encode($newentry));

//     echo "New entry added: ";
//     print_r($newentry);



/**--------hset-------***/
$rand = 'B206F636';
$time = Date('H:m:s A');
$role = 'Staff';
$newentry = '';

$conn_ = new mysqli('localhost', 'necrodrow_ct_cuc', '9276FAKISLF', 'necrodrow_ct_cuc');
$sql_ = "INSERT INTO logs (UniqueID, Enter_Time,Position,Role,Exit_Time,Date,Method,Covid)  
    VALUES ( '$rand' , '$time','Student','Form5',NULL,'2022-09-15','QR','0' )";

$conn_->query($sql_);

$newentry .= "<div style='    display: block;
    border: 1px solid green;
    box-shadow: 1px 2px 1px;
    border-radius: 6px;
    padding: 12px;margin:2px;
    width: 50%;'><img width='72px' src='https://source.unsplash.com/random/200x200?sig=1' alt=''> " . $rand . " - " . $time . "-" . $role . "</div>";

$redis->hset('user', $rand, $newentry);


echo "New entry added:" . $newentry;
