<?php
require './vendor/autoload.php';
$redis = new Predis\Client();

$rand = 'B206F54654545Y45YY';
$time = Date('H:m:s A');
$newentry = '';

$conn_ = new mysqli('localhost', 'necrodrow_ct_cuc', '9276FAKISLF', 'necrodrow_ct_cuc');
$sql_ = "DELETE FROM `logs` WHERE UniqueID = '$rand' AND Exit_Time IS NULL";

if ($conn_->query($sql_)) {
    $newentry .= $rand . ': ' . $time . ' STAFF <br>';

    $cachedEntry = $redis->hgetall('user');

    if ($cachedEntry) {
        foreach ($cachedEntry as $cached) {
            $redis->hdel('user', $rand);
        }
    }

    echo "User $rand deleted: " . $newentry;
} else {
    echo "nah boi nothing to delete";
}



