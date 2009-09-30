<?php
/**
 * Tests für Seminartermin
 *
 * @package tests
 * @author Marc Remolt <m.remolt@webmasters.de>
 */

require_once 'library/autoload.php';
use \models\Seminartermin, \models\Seminar, \models\Benutzer;

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

$be1 = Benutzer::find(1);
$st3->addTeilnehmer($be1);