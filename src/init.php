<?php
$dbh = new PDO('mysql:host=178.62.121.17;dbname=sensorbase', 'core', 'db20160218');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);