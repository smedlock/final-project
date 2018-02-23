<?php

error_reporting(E_ALL);
require_once('vendor/autoload.php');


$f3 = Base::instance();
$f3->set('DEBUG', 3);

$f3->route('GET /', function(){
    echo "<h1>hello, world!</h1>";
});

$f3->run;