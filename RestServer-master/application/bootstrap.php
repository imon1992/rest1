<?php
/**
 *
 * File wich booting all core classes
 * File wich starts routing
 * 
 */
namespace application;
use application\core as routeCore;

$server = new routeCore\Route;
$server->start();