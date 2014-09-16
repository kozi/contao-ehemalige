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
            'mode'                    => 1,
            'fields'                  => array('name', 'vorname'),
            'flag'                    => 2,
            'panelLayout'             => 'filter; search, sort, limit',
        ),
        'label' => array
        (
            'fields'                  => array('name', 'vorname', 'info', 'jahrgang'),
            'showColumns'             => true,
            'label_callback'          => array('tl_ehemalige', 'labelCallback')
        ),
        'global_operations' => array
        (
            'import' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ehemalige']['importCsv'],
                'href'                => 'key=import',
                'class'               => 'header_icon header_ehemalige_import',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="i"'
            ),
            'export' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ehemalige']['exportCsv'],
                'href'                => 'key=export',
                'class'               => 'header_icon header_ehemalige_export',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="x"'
            ),
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ),
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
        'default'                     => '{title_legend}, name, geburtsname, vorname, email, email2, homepage, jahrgang'
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
        'info' => array
        (
            'label'                   => $GLOBALS['TL_LANG']['tl_ehemalige']['info'],
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
            'inputType'               => 'text',
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
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
		$cYear  = intval(\Date::parse('Y'));
        for($i = 1955;$i <= $cYear;$i++) {
            $values[$i] = $i;
        }
		return $values;
	}


    public function labelCallback($row, $label, DataContainer $dc, $args = null) {
        if ($args === null) {
            return $label;
        }

        $args[0] .= ($row['geburtsname']) ? ' ('.$row['geburtsname'].')' : '';
        $args[0]  = str_replace(' ', '&nbsp;', $args[0]);

        // Info
        $args[2]  = (($row['email']) ? $row['email'] : '')
                    .(($row['email2']) ? ', '.$row['email2'] : '')
                    .(($row['homepage']) ? ', '.$row['homepage'] : '');

        return $args;
    }
}
