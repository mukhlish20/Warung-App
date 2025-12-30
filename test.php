<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->handle(Illuminate\Http\Request::create('/'));
echo "Test OK";
?>