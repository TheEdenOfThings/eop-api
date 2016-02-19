<?php
include 'init.php';

class Location
{

    /**
     * Location identifier
     *
     * @var int
     */
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

//the database query
$sql=<<<EOF
SELECT l.id AS location_id, s.id AS sensor_id, sd.value, st.type, s.unit, l.longitude, l.lattitude, l.name AS lname, z.id AS zone_id, z.name AS zname

,sd.value, TIMEDIFF(NOW() , sd.date_added) AS last_seen_todo, 10 AS last_seen

FROM locations l
INNER JOIN sensors s
ON l.id = s.location_id

INNER JOIN zones z
ON z.id = l.zone_id

INNER JOIN sensor_data sd
ON sd.sensor_id=s.id

INNER JOIN sensor_types st
ON s.sensor_type_id= st.id



GROUP BY s.id

ORDER BY sd.sensor_id, sd.sequence

EOF;
$sth = $dbh->prepare($sql);
if ($sth->execute() == false)
{
    die('YOU HAVE FAILED');
}
$results = $sth->fetchAll(PDO::FETCH_OBJ);
//var_dump($results);






$locationArr=array ();
foreach($results as $result)
{
    //var_dump ($result);
    if(isset($locationArr[$result->location_id])== false)
    {

        $l = new Location ($result->location_id, $result->lname, $result->zname, $result->lattitude, $result->longitude);
        $locationArr[$result->location_id] =$l;
    }

    $s = new Sensor ($result->sensor_id, $result->unit, $result->type, $result->value, $result->last_seen);
    $locationArr[$result->location_id]->addSensor($s);
}

//var_dump($locationArr[1]);


/*make fake locations
$l1 = new Location (1, 'Waterfall', 'Tropical', 50, 120);
$l2 = new Location (2, 'Balcony', 'Moon', 100, 1200);
$l3 = new Location (3, 'Platform ', 'Mediterranean',70, 130);
*/
// uni fake sensors


/*$s1 = new Sensor (1, 'C', 'Temperature', 45, 600);
$l1->addSensor($s1);
$s2 = new Sensor (2, '%', 'Humidity', 70, 600);
$l2->addSensor($s2);
$s3 = new Sensor (3, 'L', 'Light', 200, 600);
$l3->addSensor($s3);
*/
$result = json_encode($locationArr);
echo $result;