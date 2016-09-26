<?php

define('ACCESS_SYSTEM', 'true');

require('includes/bootstrap.php');

$registry = new Registry();
$registry->viewComposer = ['toolbar' => 'ToolbarProvider'];

$pageMeta = ['title' => 'Study Project', 'description' => '', 'keyword' => '']; 

// App Routes
$route = new Route();
$registry->route = $route;
require('app/route.php');
$route->end();

?>