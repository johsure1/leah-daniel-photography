<?php 

require_once 'config.php';
require_once 'backend.php';

$_SESSION=[];

session_destroy();

header('location: home.php');



?>