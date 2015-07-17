<?php

/**
 * Class ContentEhemalige
 *
 * @copyright  Martin Kozianka 2014-2015
 * @author     Martin Kozianka <http://kozianka.de>
 * @package    ehemalige
 */

class EhemaligeModel extends \Model
{
    public static $ARR_CSV_HEADER = ['name','geburtsname','vorname','email','email2','homepage','jahrgang'];

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_ehemalige';

    public function getCsvArray()
    {
        $valueArr  = $this->row();
        $returnArr = array();
        foreach(static::$ARR_CSV_HEADER as $key)
        {
            $returnArr[$key] = $valueArr[$key];
        }
        return $returnArr;
    }

}
