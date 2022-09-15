
<?php
require './vendor/autoload.php';
$redis = new Predis\Client();

$rand = 'B206F636';
$time = Date('H:m:s A');
$newentry = '';

$conn_ = new mysqli('localhost', 'necrodrow_ct_cuc', '9276FAKISLF', 'necrodrow_ct_cuc');
$sql_ = "UPDATE logs
SET Exit_Time = '$time'
WHERE Exit_Time IS NULL and UniqueID = '$rand'";

    $newentry .= $rand . ': ' . $time . ' STAFF <br>';

    $cachedEntry = $redis->hgetall('user');

    if ($cachedEntry) {
        foreach ($cachedEntry as $cached) {
            $redis->hdel('user', $rand);
        }
    }

    echo "User $rand deleted: " . $newentry;

