<?php

ClassLoader::addClasses(array(
    'ContentEhemalige'   => 'system/modules/ehemalige/elements/ContentEhemalige.php',
    'EhemaligeModel'     => 'system/modules/ehemalige/models/EhemaligeModel.php'
));

TemplateLoader::addFiles(array(
	'ce_ehemalige'       => 'system/modules/ehemalige/templates'
));

