<?php

namespace models;
use library\Database;
use \PDO;

/**
 * Description of Benutzer
 *
 * @author Marc Remolt <m.remolt@webmasters.de>
 */
class Benutzer extends \library\ActiveRecord
{
    protected $vorname;
    protected $name;
    protected $email;
    protected $passwort;
    protected $registriert_seit;
    protected $anrede;

    /**
     * Getter 
     * 
     * @return string
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * Setter
     *
     * @param string $vorname
     * @return Benutzer
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
        return $this;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter
     *
     * @param string $name
     * @return Benutzer
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Setter
     *
     * @param string $email
     * @return Benutzer
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Setter
     *
     * @param string $passwort
     * @return Benutzer
     */
    public function setPasswort($passwort)
    {
        $this->passwort = $passwort;
        return $this;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getRegistriert_seit()
    {
        return $this->registriert_seit;
    }

    /**
     * Setter
     *
     * @param string $registriert_seit
     * @return Benutzer
     */
    public function setRegistriert_seit($registriert_seit)
    {
        $this->registriert_seit = $registriert_seit;
        return $this;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getAnrede()
    {
        return $this->anrede;
    }

    /**
     * Setter
     *
     * @param string $anrede
     * @return Benutzer
     */
    public function setAnrede($anrede)
    {
        $this->anrede = $anrede;
        return $this;
    }

    public function validatePasswort($passwort)
    {
        return $this->passwort === $passwort;
    }

    /**
     * Getter
     *
     * @return array
     */
    public function getSeminartetmine()
    {
        return Seminartermin::findByBenutzer($this);
    }

    /**
     * Fügt dem Benutzer einen neue Teilahme an einem Seminartermin hinzu.
     *
     * @param Seminartermin $seminartetmin
     * @return Benutzer
     */
    public function addSeminartermin(Seminartermin $seminartetmin)
    {
        // wir können die Zwischentabelle nicht befüllen, so lange der Seminartermin
        // nicht gespeichert ist.
        if ( ! $seminartetmin->getId() > 0 ) {
            $seminartetmin->save();
        }

        $sql = 'INSERT INTO nimmt_teil (benutzer_id, seminartermin_id) VALUES (?, ?)';
        $statement = Database::getInstance()->prepare($sql);
        $statement->execute(array( $this->getId(), $seminartetmin->getId() ));

        return $this;
    }

    /**
     * Gibt eine kurze Beschreibung des Objekts zurück
     *
     * @return string
     */
    public function __toString()
    {
        return htmlspecialchars(sprintf(
            '%s: "%s %s %s" <%s>',
            get_called_class(),
            $this->getAnrede(),
            $this->getVorname(),
            $this->getName(),
            $this->getEmail()
        ));
    }

    /**
     * Findet Benutzer eines Seminartermins über die Zwischentabelle nimmt_teil
     *
     * Hier ist ein SQL JOIN notwendig, wobei die Spalten der Zwischentabelle nicht
     * im Objekt auftauchen sollen, also kein SELECT *.
     *
     * @param Seminartermin $seminartermin
     * @return array
     */
    public static function findBySeminartermin(Seminartermin $seminartermin)
    {
        $sql = sprintf(
            'SELECT %s FROM benutzer be JOIN nimmt_teil nt ON be.id = nt.benutzer_id WHERE nt.seminartermin_id = ?',
            implode(', ', static::getTableColumns())
        );
        $statement = Database::getInstance()->prepare($sql);
        $statement->execute(array( $seminartermin->getId() ));
        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $statement->fetchAll();
    }
}