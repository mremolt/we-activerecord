<?php

namespace models;

require_once '../library/autoload.php';

/**
 * Description of User
 *
 * @author Marc Remolt <m.remolt@webmasters.de>
 */
class Film extends \library\ActiveRecord
{
    
}

class Filmgesellschaft extends \library\ActiveRecord
{
    
}

print Film::getTableName();

var_dump(Film::getTableColumns());
var_dump(Film::getTableColumns(false));

var_dump(Filmgesellschaft::getTableColumns());

$u = new Film();

$u->save();
