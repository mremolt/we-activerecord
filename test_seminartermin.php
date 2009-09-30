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

var_dump($se4->getSeminartermine());

print '<p>Davor: ' .  $se4->countSeminartermine() . '</p>';
$st4 = Seminartermin::find(4);
$se4->addSeminartermin($st4);
print '<p>Danach: ' .  $se4->countSeminartermine() . '</p>';
