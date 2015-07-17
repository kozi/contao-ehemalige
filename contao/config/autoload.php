<?php

ClassLoader::addClasses([
    'EhemaligenManager'  => 'system/modules/ehemalige/classes/EhemaligenManager.php',
    'ContentEhemalige'   => 'system/modules/ehemalige/elements/ContentEhemalige.php',
    'EhemaligeModel'     => 'system/modules/ehemalige/models/EhemaligeModel.php',
]);

TemplateLoader::addFiles([
	'ce_ehemalige'       => 'system/modules/ehemalige/templates'
]);

