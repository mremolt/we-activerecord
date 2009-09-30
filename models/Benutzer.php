<?php

namespace models;

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

    public function getVorname()
    {
        return $this->vorname;
    }

    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPasswort($passwort)
    {
        $this->passwort = $passwort;
        return $this;
    }

    public function getRegistriert_seit()
    {
        return $this->registriert_seit;
    }

    public function setRegistriert_seit($registriert_seit)
    {
        $this->registriert_seit = $registriert_seit;
        return $this;
    }

    public function getAnrede()
    {
        return $this->anrede;
    }

    public function setAnrede($anrede)
    {
        $this->anrede = $anrede;
        return $this;
    }

    public function validatePasswort($passwort)
    {
        return $this->passwort === $passwort;
    }
}