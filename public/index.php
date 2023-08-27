<?php

session_start();
require __DIR__."/../app/init.php";
$app = new App();
$app->run();
$topic=new Topic;
$gallery=new Gallery;