<?php
require './vendor/autoload.php';
$redis = new Predis\Client();

//echo $redis->ping();
//$redis->set('name', 'Kerwin Thompson');
//echo $redis->get('name');

$cachedEntry = $redis->hvals('user');
$t0 = 0;
$t1 = 0;
if ($cachedEntry) {
    echo "<b>From Redis cache</b> <br>";
    $t0 = microtime(true) * 1000;
    //print_r($cachedEntry);
    foreach ($cachedEntry as $cached) {
        echo $cached;
    }


    $t1 = microtime(true) * 1000;
    echo 'Time taken: ' . round($t1 - $t0, 4) . 'milliseconds';
    exit();
} else {
    $t0 = microtime(true) * 1000;
    $conn = new mysqli('localhost', 'necrodrow_ct_cuc', '9276FAKISLF', 'necrodrow_ct_cuc');
    $sql = "SELECT * FROM logs WHERE Exit_Time IS NULL AND Date = '2022-09-15' GROUP BY UniqueID";
    $result = $conn->query($sql);
    echo "From database <br>";
    $temp = '';

    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "<div style='display: block;
            border: 1px solid green;
            box-shadow: 1px 2px 1px;
            border-radius: 6px;
            padding: 12px;
            width: 50%;'><img width='72px' src='https://source.unsplash.com/random/200x200?sig=1' alt=''>" . $row['UniqueID'] . " - " . $row['Enter_Time'] . "-" . $row['Role'] . "</div>";


            $temp .= "<div style='display: block;
            border: 1px solid green;
            box-shadow: 1px 2px 1px;
            border-radius: 6px;
            padding: 12px;
            width: 50%;'><img width='72px' src='https://source.unsplash.com/random/200x200?sig=1' alt=''>" . $row['UniqueID'] . " - " . $row['Enter_Time'] . "-" . $row['Role'] . "</div>";
        }
        $t1 = microtime(true) * 1000;
        echo 'Time taken: ' . round($t1 - $t0, 4) . 'milliseconds';

        $redis->hset('user', $row['UniqueID'], $temp);
        //clear cache after 10 seconds
        // $redis->expire('user', 10);
        exit();
    } else {
        echo "no data to satify query";
    }
}

