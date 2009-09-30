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

    /**
     * Getter
     *
     * @return string
     */
    public function getBeginn()
    {
        return $this->beginn;
    }

    /**
     * Setter
     *
     * @param string $beginn
     * @return Seminartermin
     */
    public function setBeginn($beginn)
    {
        $this->beginn = $beginn;
        return $this;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getEnde()
    {
        return $this->ende;
    }

    /**
     * Setter
     *
     * @param string $ende
     * @return Seminartermin
     */
    public function setEnde($ende)
    {
        $this->ende = $ende;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getRaum()
    {
        return $this->raum;
    }

    /**
     * Setter
     *
     * @param string $raum
     * @return Seminartermin
     */
    public function setRaum($raum)
    {
        $this->raum = $raum;
    }

    /**
     * Getter
     *
     * @return Seminar
     */
    public function getSeminar()
    {
        return Seminar::find($this->seminar_id);
    }

    /**
     * Setter
     *
     * @param Seminar $seminar
     * @return Seminartermin
     */
    public function setSeminar(Seminar $seminar)
    {
        $this->seminar_id = $seminar->getId();
    }

    /**
     * Gibt eine kurze Beschreibung des Objekts zurück
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s: "%s" von %s bis %s',
            get_called_class(),
            $this->getSeminar()->getTitel(),
            $this->getBeginn(),
            $this->getEnde()
        );
    }

    // diese Zugriffsmethoden sind nur zur internen Verwendung

    /**
     * Getter
     *
     * @return integer
     */
    protected function getSeminar_id()
    {
        return intval($this->seminar_id);
    }

    /**
     * Setter
     *
     * @param integer $seminar_id
     * @return Seminartermin
     */
    protected function setSeminar_id($seminar_id)
    {
        $this->seminar_id = intval($seminar_id);
        return $this;
    }
}