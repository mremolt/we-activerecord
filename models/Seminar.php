<?php

namespace models;

/**
 * Description of Seminar
 *
 * @author Marc Remolt <m.remolt@webmasters.de>
 */
class Seminar extends \library\ActiveRecord
{
    protected static $_tableName = 'seminare';

    protected $titel;
    protected $beschreibung;
    protected $preis;
    protected $kategorie;

    /**
     * Getter
     * 
     * @return string
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * Setter
     *
     * @param string $titel
     * @return Seminar
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;
        return $this;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
    }

    /**
     * Setter
     *
     * @param string $beschreibung
     * @return Seminar
     */
    public function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
        return $this;
    }

    /**
     * Getter
     *
     * @return double
     */
    public function getPreis()
    {
        return $this->preis;
    }

    /**
     * Setter
     *
     * @param double $preis
     * @return Seminar
     */
    public function setPreis($preis)
    {
        $this->preis = $preis;
        return $this;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getKategorie()
    {
        return $this->kategorie;
    }

    /**
     * Setter
     * 
     * @param string $kategorie
     * @return Seminar
     */
    public function setKategorie($kategorie)
    {
        $this->kategorie = $kategorie;
        return $this;
    }

    public function __toString()
    {
        return get_called_class() .  ': ' . $this->getTitel() . ' (Preis: ' . $this->getPreis() . '€)';
    }
}