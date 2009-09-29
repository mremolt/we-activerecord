<?php

namespace library;
use library\Database;

/**
 * Basisklasse für alle Datenbank-Modelle
 *
 * @author Marc Remolt <m.remolt@webmasters.de>
 */
abstract class ActiveRecord
{
    protected $id = 0;
    protected $errors = array();
    
    protected static $_tableName = '';

    /**
     * Konstruktor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        if ($data) {
            foreach ($data as $k => $v) {
                $setterName = 'set' . ucfirst($k);
                $this->$setterName($v);
            }
        }
    }

    /**
     * Gibt eine kurze Beschreibung des Objekts zurück
     * 
     * @return string
     */
    public function __toString()
    {
        return get_called_class() .  ': ' . $this->id;
    }

    /**
     * Gibt die ID zurück
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setzt die ID
     * 
     * @param string $id
     * @return ActiveRecord
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Gibt die Datenbank-Attribute dieses Exemplars zurück.
     * 
     * @param boolean $withId Soll auch das Attribut ID mit zurückgegeben werden?
     * @return array $values
     */
    public function toArray($withId = true)
    {
        $values = array();
        foreach (static::getTableColumns($withId) as $column) {
            $getterName = 'get' . ucfirst($column);
            $values[$column] = $this->$getterName();
        }
        return $values;
    }

    /**
     * Gibt alle aufgetretenen Fehler zurück
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Erzeugt einen neuen Fehler
     *
     * @param string $attributeName
     * @param string $message
     * @return ActiveRecord
     */
    public function addError($attributeName, $message)
    {
        $this->errors[$attributeName] = $message;
        return $this;
    }

    /**
     * Sind beim Setzen der Attribute Fehler aufgetreten?
     *
     * @return boolean
     */
    public function isValid()
    {
        return count($this->getErrors()) === 0;
    }
    
    /**
     * Speichert das Exemplar in der Datenbank
     *
     * Je nachdem, ob das Attribut ID einen Wert größer als 0 hat, also in der
     * Datenbank als Eintrag existiert, wird die Methode _insert() oder _update()
     * aufgerufen.
     *
     * @return ActiveRecord
     */
    public function save()
    {
        $this->_insert();
        print '<br />';
        $this->_update();

        return $this;
    }

    /**
     * Löscht das Exemplar aus der Datenbank
     * 
     * @return ActiveRecord
     */
    public function delete()
    {
        if ($this->getId() > 0) {
            $sql = 'DELETE FROM ' . static::getTableName() . 'WHERE id = ?';
            
        }
        return $this;
    }

    /**
     * Gibt den Datensatz mit der passenden ID als Objekt zurück
     * 
     * @param integer $id
     * @return ActiveRecord
     */
    public static function find($id)
    {
        $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE id = ?';
    }

    /**
     * Gibt alle Datensätze der verwalteten Tabelle als Objekte zurück
     * 
     * @return array
     */
    public static function findAll()
    {
        $sql = 'SELECT * FROM ' . static::getTableName();
    }

    public static function findByWhere($where = '1')
    {
        
    }

    /**
     * Gibt den Namen der Datenbank-Tabelle zurück, die diese Klasse verwaltet
     * 
     * @return string $tableName
     */
    public static function getTableName()
    {
        if (static::$_tableName) {
            $tableName = static::$_tableName;
        } else {
            $className = static::_stripNamespace(get_called_class());
            $tableName = strtolower($className);
        }
        return $tableName;
    }

    /**
     * Gibt die Spalten der verwalteten Tabelle zurück
     * 
     * Die Methode liest die tatsächliche Struktur der Tabelle aus (per SQL)
     * und verwendet die gefundenen Spaltennamen.
     * 
     * @param boolean $withId Soll auch die Spalte ID zurückgegeben werden?
     * @return array $columns
     */
    public static function getTableColumns($withId = true)
    {
        $sql = 'SHOW COLUMNS from ' . static::getTableName();
        if (! $withId) {
            // hole alle Spaltennamen außer id
            $sql .= ' WHERE Field != "id"';
        }
        $statement = Database::getInstance()->query($sql);

        $columns = array();
        foreach ($statement->fetchAll() as $row) {
            // hole nur die Feldnamen (Field-spalte) aus den Datensätzen
            $columns[] = $row['Field'];
        }
        return $columns;
    }

    /**
     * Speichert das Objekt als neuen Eintrag in der verwalteten Tabelle
     *
     * 
     */
    protected function _insert()
    {
        $columns = static::getTableColumns(false);
        $columnSql = implode(', ', $columns);
        
        // Die benannten Parameter in SQL benötigen einen : vor dem Namen,
        // also können wir nicht einfach nur implode() verwenden
        $parameters = array();
        foreach ($columns as $column) {
            $parameters[] = ':' . $column;
        }
        $parameterSql = implode(', ', $parameters);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            static::getTableName(),
            $columnSql,
            $parameterSql
        );
        echo $sql;
    }

    /**
     * Aktualisiert den Datensatz in der verwalteten Tabelle
     *
     * 
     */
    protected function _update()
    {
        $columns = static::getTableColumns(false);

        $columnStatements = array();
        foreach ($columns as $column) {
            $columnStatements[] = sprintf('%s = :%s', $column, $column);
        }
        $columnSql = implode(', ', $columnStatements);

        $sql = sprintf(
            'UPDATE %s SET %s WHERE id = :id',
            static::getTableName(),
            $columnSql
        );
        echo $sql;
    }

    /**
     * Entfernt das Namespace-Prefix vom Klassennamen
     *
     * @param string $className
     * @return string $strippedClassName
     */
    protected static function _stripNamespace($className)
    {
        $parts = explode('\\', $className);
        return array_pop($parts);
    }

}
