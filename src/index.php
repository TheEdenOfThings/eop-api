<?php
include 'init.php';
/**
 * Sensor locations
 */
class Location
{

    /**
     * Location identifier
     *
     * @var int
     */
    public $id;

    /**
     * Zone of the location (biome)
     *
     * @var string
     */
    public $zone;

    /**
     * Latitude of location
     *
     * @var float
     */
    public $lat;

    /**
     * Longitude of location
     *
     * @var float
     */
    public $long;

    /**
     * Name of zone
     *
     * @var string
     */
    public $name;

    /**
     * Collection of sensors
     *
     * @var Sensor[]
     */
    public $sensors;

    /**
     * Add a sensor to the collection of senspors
     *
     * @param Sensor $sensor Sensor to add
     * @return void
     */
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

/**
 * Sensor device
 */
class Sensor
{
    /**
     * Sensor identifier
     *
     * @var int
     */
    public $id;

    /**
     * Unit of measurement for sensor
     *
     * @var string
     */
    public $unit;

    /**
     * Type of sensor
     *
     * @var string
     */
    public $type;

    /**
     * Current value of sensor
     *
     * @var string
     */
    public $current;

    /**
     * Seconds ago of last value logged
     *
     * @var int
     */
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


$result = json_encode($locationArr);
echo $result;