<?php
include '../../app/RestServer.php';
include('../../app/Cars.php');
include('../../app/config.php');
include_once('../../app/libs/CarInfoSql.php');
$restServer = new RestServer();
echo $restServer->run();


