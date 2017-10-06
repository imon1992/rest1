<?php
include '../../app/auth/RestServer.php';
include('../../app/auth/libs/Auth.php');
include('../../app/config.php');
include_once('../../app/auth/libs/AuthSql.php');
$restServer = new RestServer();
echo $restServer->run();


