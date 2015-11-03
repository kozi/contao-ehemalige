<?php

/**
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2014-2015 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    contao-ehemalige
 * @license    LGPL 
 * @filesource
 */

$GLOBALS['TL_MODELS']['tl_ehemalige']       = '\ContaoEhemalige\Models\EhemaligeModel';
$GLOBALS['TL_CTE']['includes']['ehemalige'] = '\ContaoEhemalige\Elements\ContentEhemalige';

$GLOBALS['BE_MOD']['content']['ehemalige'] = [
            'tables'     => ['tl_ehemalige'],
            'icon'       => 'system/modules/ehemalige/assets/graduation-hat.png',
            'stylesheet' => 'system/modules/ehemalige/assets/be-style.css',

            'import'     => ['\ContaoEhemalige\EhemaligenManager', 'importCsv'],
            'export'     => ['\ContaoEhemalige\EhemaligenManager', 'exportCsv'],
];






