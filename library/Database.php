<?php
/**
 * Repräsentiert eine Datenbankverbindung
 *
 * Diese Klasse stellt eine Variante des Singleton-Design-Patterns dar, da nicht ein
 * Exemplar der Klasse selbst, sondern ein PDO-Objekt zurückgegeben wird.
 *
 * @author Marc Remolt <m.remolt@webmasters.de>
 */
final class Database
{
    /**
     * @var PDO
     */
    private static $db = null;

    /**
     * Verhindere, dass von Database ein Exemplar erzeugt werden kann.
     */
    private function  __construct()
    {

    }

    /**
     * Gibt die Datenbankverbindung (PDO) zurück.
     * 
     * @return PDO
     */
    public static function getInstance()
    {
        if (! static::$db) {
            static::$db = new PDO('mysql:dbname=filmdb;host=127.0.0.1', 'root', '');
        }
        return static::$db;
    }
}