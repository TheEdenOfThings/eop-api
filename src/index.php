<?php

class Location
{

    public $id;
    public $zone;
    public $lat;
    public $long;
    public $name;
    public $sensors;

    function addSensor(Sensor $sensor)
    {
        $this->sensors[]=$sensor;
    }

        function __construct($locationId, $name, $zoneName, $latitude, $longatude)
    {
        $this->id =$locationId;
        $this->name =$name;
        $this->lat =$latitude;
        $this->long =$longatude;
        $this->zone =$zoneName;

        $this->sensors = array();
    }

}

class Sensor
{

    public $id;
    public $unit;
    public $type;
    public $current;
    public $last;

    function __construct($sensorId, $unit, $sensorType, $currentValue, $lastSeen)
    {
        $this->id =$sensorId;
        $this->unit =$unit;
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
//make fake locations
$l1 = new Location (1, 'Waterfall', 'Tropical', 50, 120);
$l2 = new Location (2, 'Balcony', 'Moon', 100, 1200);
$l3 = new Location (3, 'Platform ', 'Mediterranean',70, 130);

// uni fake sensors


$s1 = new Sensor (1, 'C', 'Temperature', 45, 600);
$l1->addSensor($s1);
$s2 = new Sensor (2, '%', 'Humidity', 70, 600);
$l2->addSensor($s2);
$s3 = new Sensor (3, 'L', 'Light', 200, 600);
$l3->addSensor($s3);

$data = array($l1, $l2, $l3);
$result = json_encode($data);
echo $result;