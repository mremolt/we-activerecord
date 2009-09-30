<?php

require_once 'library/autoload.php';
use \models\Seminartermin;
use \models\Seminar;

$st3 = Seminartermin::find(3);
var_dump($st3);

var_dump($st3->getSeminar());

$se4 = Seminar::find(4);

$st3->setSeminar($se4);
$st3->save();

print $st3;