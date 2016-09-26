<?php

defined('ACCESS_SYSTEM') or die;

session_start();

// App
require('app/config.php');

require('includes/define.php');
require('libraries/function.php');
require('libraries/registry.php');
require('libraries/session.php');

// MVC
require('libraries/controller.php');
require('libraries/model.php');

// Database
require('libraries/database.php');
require('libraries/query_buider.php');

require('libraries/app.php');
require('libraries/route.php');

?>