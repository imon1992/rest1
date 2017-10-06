<?php
include '../../app/cars/RestServer.php';
include('../../app/cars/libs/Cars.php');
include('../../app/config.php');
include_once('../../app/cars/libs/CarInfoSql.php');
$restServer = new RestServer();
echo $restServer->run();


