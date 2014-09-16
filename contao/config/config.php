<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    ehemalige 
 * @license    LGPL 
 * @filesource
 */

$GLOBALS['BE_MOD']['content']['ehemalige'] = array(
            'tables'     => array('tl_ehemalige'),
            'icon'       => 'system/modules/ehemalige/assets/graduation-hat.png',
            'stylesheet' => 'system/modules/ehemalige/assets/be-style.css',

            'import'     => array('EhemaligenManager', 'importCsv'),
            'export'     => array('EhemaligenManager', 'exportCsv'),
);

$GLOBALS['TL_CTE']['includes']['ehemalige'] = 'ContentEhemalige';





