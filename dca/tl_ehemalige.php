<?php

$GLOBALS['TL_DCA']['tl_ehemalige'] = array(

	// Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'closed'                      => false,
        'notEditable'                 => false,        
        'sql' => array(
            'keys' => array
            (
                'id'  => 'primary'                
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 2,
            'fields'                  => array('name DESC'),
            'flag'                    => 1,
            'panelLayout'             => 'filter; search, sort, limit',
        ),
        'label' => array
        (
            'fields'                  => array('name', 'vorname', 'email', 'homepage', 'jahrgang'),
            'showColumns'             => true,            
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif',
                'attributes'          => 'class="contextmenu"'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            )
        )

    ),


	// Palettes
    'palettes' => array
    (
        'default'                     => '{title_legend}, name, geburtsname, vorname, email, jahrgang,'
    ),

	// Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
        ),
        'name' => array
        (
            'label'                   => $GLOBALS['TL_LANG']['tl_ehemalige']['name'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,            
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'geburtsname' => array
        (
            'label'                   => $GLOBALS['TL_LANG']['tl_ehemalige']['geburtsname'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,            
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),        
        'vorname' => array
        (
            'label'                   => $GLOBALS['TL_LANG']['tl_ehemalige']['vorname'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,            
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'email' => array
        (
            'label'                   => $GLOBALS['TL_LANG']['tl_ehemalige']['email'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,            
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'rgxp' => 'email'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'email2' => array
        (
            'label'                   => $GLOBALS['TL_LANG']['tl_ehemalige']['email'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50', 'rgxp' => 'email'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'homepage' => array
        (
            'label'                   => $GLOBALS['TL_LANG']['tl_ehemalige']['homepage'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,            
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50', 'rgxp' => 'url'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'jahrgang' => array
        (
            'label'                   => $GLOBALS['TL_LANG']['tl_ehemalige']['jahrgang'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'options_callback'        => array("tl_ehemalige", "getJahrgaenge"),
            'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'chosen' => true),
            'sql'                     => "smallint(5) NOT NULL default '0'"
        ),

    ) //fields

);


class tl_ehemalige extends \System {

	public function getJahrgaenge() {	
		$cYear = intval(\Date::parse('Y'));
		return range (1955, $cYear);
	}

}
