<?php

namespace models;
use library\Database;
use \PDO;

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
     * Gibt die Teilnehmer (Klasse Benutzer) des Seminartermins zurück
     * 
     * @return array
     */
    public function getTeilnehmer()
    {
        return Benutzer::findBySeminartermin($this);
    }

    /**
     * Fügt dem Seminartermin einen neuen Teilnehmer (Klasse Benutzer) hinzu.
     *
     * @param Benutzer $teilnehmer
     * @return Seminartermin
     */
    public function addTeilnehmer(Benutzer $teilnehmer)
    {
        // wir können die Zwischentabelle nicht befüllen, so lange der Benutzer
        // nicht gespeichert ist.
        if ( ! $teilnehmer->getId() > 0 ) {
            $teilnehmer->save();
        }

        $sql = 'INSERT INTO nimmt_teil (benutzer_id, seminartermin_id) VALUES (?, ?)';
        $statement = Database::getInstance()->prepare($sql);
        $statement->execute(array( $teilnehmer->getId(), $this->getId() ));

        return $this;
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

    /**
     * Findet Seminartermine eines Benutzers über die Zwischentabelle nimmt_teil
     *
     * Hier ist ein SQL JOIN notwendig, wobei die Spalten der Zwischentabelle nicht
     * im Objekt auftauchen sollen, also kein SELECT *.
     *
     * @param Benutzer $benutzer
     * @return array
     */
    public static function findByBenutzer(Benutzer $benutzer)
    {
        $sql = sprintf(
            'SELECT %s FROM seminartermine st JOIN nimmt_teil nt ON st.id = nt.seminartermin_id WHERE nt.benutzer_id = ?',
            implode(', ', static::getTableColumns())  
        );
        $statement = Database::getInstance()->prepare($sql);
        $statement->execute(array( $benutzer->getId() ));
        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $statement->fetchAll();
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