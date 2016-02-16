<?php
function sensor ($sensorId, $locationId, $latitude, $longatude, $sensorType, $currentValue, $lastSeen)
{
    $sensor =new stdClass;
    $sensor->id = $sensorId;
    $sensor->location = $locationId;
    $sensor->lat=$latitude;
    $sensor->long=$longatude;
    $sensor->type=$sensorType;
    $sensor->current=$currentValue;
    $sensor->last=$lastSeen;
    return $sensor;
}

$task =$_GET['task'];
$operation =$_GET['operation'];
if ($task != 'api' || $operation != 'sensors')
{
    exit();
}

// uni fake sensors

$s1 = sensor (1, 1, 12, 52, 'temp', 15, 10);
//var_dump($s1);
$s2 = sensor (2, 2, 13, 28, 'humid', 83, 64);
//var_dump($s2);
$s3 = sensor (3, 3, 78, 43, 'day', 450, 120);
//var_dump($s3);
$data = array($s1, $s2, $s3);
//var_dump($data);
$result = json_encode($data);
//var_dump($result);
echo $result;