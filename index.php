<?php

error_reporting(E_ALL);
require_once('vendor/autoload.php');


$f3 = Base::instance();
$f3->set('DEBUG', 3);

$f3->route('GET /', function(){
    $template = new Template();
    echo $template->render('views/home.html');
});

$f3->run();