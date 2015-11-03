<?php namespace ContaoEhemalige\Elements;

/**
 * Class ContentEhemalige
 *
 * @copyright  Martin Kozianka 2014-2015
 * @author     Martin Kozianka <http://kozianka.de>
 * @package    contao-ehemalige
 */

use ContaoEhemalige\Models\EhemaligeModel;

class ContentEhemalige extends \ContentElement
{
	protected $strTemplate = 'ce_ehemalige';

	public function generate()
    {
		return parent::generate();
	}

	protected function compile()
    {
        global $objPage;

        $arrEntries    = [];
        $arrColumn     = null;
        $arrValues     = null;

        $jahrgang      = \Input::get('ehJahrgang');
        $arrJahrgang   = [
            ['key' => 'all','val' => 'Alle Jahrgänge anzeigen','sel' => ('all' == $jahrgang) ? 'selected="selected" ' : '']
        ];

        if (\Input::get('ehJahrgang') === '')
        {
            $this->redirect($this->addToUrl('ehJahrgang='));
        }

        $result = $this->Database->execute("SELECT DISTINCT jahrgang from tl_ehemalige ORDER BY jahrgang ASC");

        while($result->next())
        {
            $arrJahrgang[] = [
                'key'  => $result->jahrgang,
                'val'  => $result->jahrgang,
                'sel'  => ($result->jahrgang == $jahrgang) ? 'selected="selected" ' : ''
            ];
        }

        $this->Template->action      = ($objPage) ? $this->generateFrontendUrl($objPage->row()) : '#NOT_FOUND';
        $this->Template->arrJahrgang = $arrJahrgang;

        if(\Input::get('ehSearch'))
        {
            $filter     = '%'.trim(\Input::get('ehSearch')).'%';
            $arrColumn  = ["name LIKE ? OR vorname LIKE  ? OR email LIKE  ? OR email2 LIKE  ?
                            OR geburtsname LIKE ? OR homepage LIKE ? OR jahrgang LIKE ?"];
            $arrValues = [$filter, $filter, $filter, $filter, $filter, $filter, $filter];
            $strOrder  = 'jahrgang ASC, name ASC';
        }
        elseif($jahrgang === 'all')
        {
            $strOrder   = 'jahrgang ASC, name ASC';
        }
        elseif($jahrgang)
        {
            $arrColumn  = ["jahrgang = ?"];
            $arrValues  = [$jahrgang];
            $strOrder   = 'jahrgang ASC, name ASC';
        }
        else
        {
            // Nothing to do!
            return;
        }

        $ehemaligeCollection = EhemaligeModel::findAll([
            'column'  => $arrColumn,
            'value'   => $arrValues,
            'order'   => $strOrder,
        ]);

        $tmplEmail = '{{email::%s}}';
        $tmplHp    = '<a href="%s" target="_blank">%s</a>';

        if ($ehemaligeCollection)
        {
            foreach($ehemaligeCollection as $eObj)
            {
                $entry             = $eObj->row();

                $entry['kontakt']  = ($eObj->email) ? sprintf($tmplEmail, $eObj->email) : '';
                $entry['kontakt'] .= ($eObj->email2) ? ', '.sprintf($tmplEmail, $eObj->email2) : '';
                $entry['kontakt'] .= ($eObj->homepage) ? ', '.sprintf($tmplHp, $eObj->homepage, \StringUtil::substr($eObj->homepage, 32)) : '';

                $arrEntries[]      = $entry;
            }
        }
        $this->Template->entries = $arrEntries;
	}
}
