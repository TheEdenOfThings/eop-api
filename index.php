<?php

class Sensor
{

    public $id;
    public $location;
    public $lat;
    public $long;
    public $type;
    public $current;
    public $last;

    function __construct($sensorId, $locationId, $latitude, $longatude, $sensorType, $currentValue, $lastSeen)
    {
        $this->id =$sensorId;
        $this->location =$locationId;
        $this->lat =$latitude;
        $this->long =$longatude;
        $this->type =$sensorType;
        $this->current =$currentValue;
        $this->last =$lastSeen;
    }
}

//check if the array exists
if (isset ($_GET['task']))
{
    $task =$_GET['task'];
}
else

{
    $task='';
}
//supress error message (the same as checking if the array exists)
$operation =@$_GET['operation'];
if ($task != 'api' || $operation != 'sensors')
{
    exit();
}

// uni fake sensors


$s1 = new Sensor (1, 1, 12, 52, 'temp', 15, 10);
$s2 = new Sensor (2, 2, 13, 28, 'humid', 83, 64);
$s3 = new Sensor (3, 3, 78, 43, 'day', 450, 120);


$data = array($s1, $s2, $s3);
$result = json_encode($data);
echo $result;