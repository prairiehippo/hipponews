<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../lib'));
require_once('../lib/MasterController.php');

$config = require_once('../config/config.php');
$framework = MasterController::get_instance($config);
$framework->execute();