<?php

namespace models;

/**
 * Description of Seminartermin
 *
 * @author Marc Remolt <m.remolt@webmasters.de>
 */
class Seminartermin extends \library\ActiveRecord
{
    protected static $_tableName = 'seminartermine';

    protected $beginn;
    protected $ende;
    protected $raum;
    protected $seminar_id;

    public function getBeginn()
    {
        return $this->beginn;
    }

    public function setBeginn($beginn)
    {
        $this->beginn = $beginn;
    }

    public function getEnde()
    {
        return $this->ende;
    }

    public function setEnde($ende)
    {
        $this->ende = $ende;
    }

    public function getRaum()
    {
        return $this->raum;
    }

    public function setRaum($raum)
    {
        $this->raum = $raum;
    }

    public function getSeminar()
    {
        return Seminar::find($this->seminar_id);
    }

    public function setSeminar(Seminar $seminar)
    {
        $this->seminar_id = $seminar->getId();
    }

    public function __toString()
    {
        return get_called_class() .  ': Von ' . $this->getBeginn() . ' bis ' . $this->getEnde();
    }

    // diese Zugriffsmethoden sind nur zur internen Verwendung
    protected function getSeminar_id() {
        return $this->seminar_id;
    }

    protected function setSeminar_id($seminar_id) {
        $this->seminar_id = $seminar_id;
    }
}