<?php
/**
 * Tests für Seminar
 *
 * @package tests
 * @author Marc Remolt <m.remolt@webmasters.de>
 */

require_once 'library/autoload.php';
use \models\Seminar;


var_dump(Seminar::getTableColumns());
print Seminar::count();
//var_dump(Seminar::findAll());

$se1 = new Seminar();
$se1->setTitel('Tolles neues Seminar')
    ->setBeschreibung('bla bla')
    ->setPreis(4500.00)
    ->setKategorie('Datenbanken')
    ->save();

var_dump($se1);

$se1->setBeschreibung('Jetzt steht hier eine vernünftige Beschreibung')
    ->setPreis(2500.00)
    ->save();

var_dump($se1);

$se1->delete();

var_dump($se1);

$daten = array(
    'titel'        => 'Noch ein tolles Seminar',
    'beschreibung' => 'nix zu sehen',
    'preis'        => 1845.99,
    'kategorie'    => 'Testseminare',
    'honk'         => 'bla',
);
$se2 = new Seminar($daten);
$se2->save();

var_dump($se2);

$se3 = Seminar::find(5);
var_dump($se3);

var_dump(Seminar::findBy('kategorie', 'Programmierung'));

print $se3;
