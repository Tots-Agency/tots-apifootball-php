<?php

require '../vendor/autoload.php';

use Tots\ApiFootball\Services\TotsApiFootballService;

$service = new TotsApiFootballService('API_KEY');

$countries = $service->getCountries();

var_dump($countries);
exit();