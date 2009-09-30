<?php
/**
 * Tests für Benutzer
 *
 * @package tests
 * @author Marc Remolt <m.remolt@webmasters.de>
 */

require_once 'library/autoload.php';
use models\Benutzer, models\Seminartermin;

$be1 = Benutzer::find(1);
var_dump($be1);

$st = $be1->getSeminartetmine();

$st2 = Seminartermin::find(2);
var_dump($st2->getTeilnehmer());

$be5 = Benutzer::find(5);
print $be5;

$st2->addTeilnehmer($be5);
