<?php
require 'vendor/autoload.php';

hmayer\Config\Settings::load("settings.json");
$operator = hmayer\Query\Telein::getOperator($argv[1]);

print $operator->agiFormat();
