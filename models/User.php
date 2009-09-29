<?php
require_once '../library/ActiveRecord.php';

/**
 * Description of User
 *
 * @author Marc Remolt <m.remolt@webmasters.de>
 */
class Film extends ActiveRecord
{
    
}

class Filmgesellschaft extends ActiveRecord
{
    
}

print Film::getTableName();

var_dump(Film::getTableColumns());
var_dump(Film::getTableColumns(false));

var_dump(Filmgesellschaft::getTableColumns());

$u = new Film();

$u->save();
