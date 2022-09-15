<?php
require './vendor/autoload.php';
$redis = new Predis\Client();


//echo $redis->ping();

$cachedEntry = $redis->hvals('user');
$t0 = 0;
$t1 = 0;


if ($cachedEntry) {
    echo "<b>From Redis cache</b> <br>";
    $t0 = microtime(true) * 1000;
    //print_r($cachedEntry);
    if(isset($_GET['id'])){
        echo $redis->hget('user',$_GET['id']);
        $t1 = microtime(true) * 1000;
    echo 'Time taken: ' . round($t1 - $t0, 4) . 'milliseconds';
        exit();
    }

    foreach ($cachedEntry as $cached) {
        echo $cached;
    }

    $t1 = microtime(true) * 1000;
    echo 'Time taken: ' . round($t1 - $t0, 4) . 'milliseconds';
    exit();
} else {
    $t0 = microtime(true) * 1000;
    $conn = new mysqli('localhost', 'necrodrow_ct_cuc', '9276FAKISLF', 'necrodrow_ct_cuc');
    $sql = "SELECT * FROM students WHERE End_Year = '2026'";
    $result = $conn->query($sql);
    echo "From database <br>";
    $temp = '';

    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {

            // echo "<div style='display:inline-block;
            // border: 1px solid green;
            // box-shadow: 1px 2px 1px;
            // border-radius: 6px;
            // padding: 12px;
            // width: 50%;'>". $row['UniqueID'] .'-'. $row['FirstName'] . " - " . $row['LastName'] . "<br>" . $row['Role'] . "</div>";


            $temp = "<div style='display:inline-block;
            border: 1px solid green;
            box-shadow: 1px 2px 1px;
            border-radius: 6px;
            padding: 12px;
            width: 50%;'>". $row['UniqueID'] .'-'. $row['FirstName'] . " - " . $row['LastName'] . "<br>" . $row['Role'] . "</div>";

            $redis->hset('user', $row['UniqueID'], $temp);
        } 
        
        if(isset($_GET['id'])){
            echo $redis->hget('user',$_GET['id']);
        }

        $t1 = microtime(true) * 1000;
        echo 'Time taken: ' . round($t1 - $t0, 4) . 'milliseconds';

       
        //$redis->expire('user', 10);
        exit();
    } else {
        echo "no data to satify query";
    }
}

