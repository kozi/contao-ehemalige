<?php

/**
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2014-2015 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    ehemalige 
 * @license    LGPL 
 * @filesource
 */

$GLOBALS['BE_MOD']['content']['ehemalige'] = [
            'tables'     => ['tl_ehemalige'],
            'icon'       => 'system/modules/ehemalige/assets/graduation-hat.png',
            'stylesheet' => 'system/modules/ehemalige/assets/be-style.css',

            'import'     => ['EhemaligenManager', 'importCsv'],
            'export'     => ['EhemaligenManager', 'exportCsv'],
];

$GLOBALS['TL_CTE']['includes']['ehemalige'] = 'ContentEhemalige';





