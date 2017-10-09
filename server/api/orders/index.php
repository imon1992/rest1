<?php
include '../../app/orders/RestServer.php';
include('../../app/orders/libs/Orders.php');
include('../../app/config.php');
include_once('../../app/orders/libs/OrderInfoSql.php');
$restServer = new RestServer();
echo json_encode($restServer->run());


