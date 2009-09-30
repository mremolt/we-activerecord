<?php

require_once 'library/autoload.php';

use models\Benutzer;

$be4 = Benutzer::find(4);
var_dump($be4);
