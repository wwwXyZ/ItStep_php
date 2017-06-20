<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//connect requirements
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

//Maybe something else?)

require_once 'core/route.php';

Route::start(); //router start
