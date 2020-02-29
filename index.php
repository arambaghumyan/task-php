<?php

define('ENV', 'dev');

require_once __DIR__ . '/autoload.php';

use core\App;

$config = require(__DIR__ . '/config/web.php');

(new App($config))->start();
