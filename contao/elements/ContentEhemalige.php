<?php

/**
 * Class ContentEhemalige
 *
 * @copyright  Martin Kozianka 2014
 * @author     Martin Kozianka <http://kozianka.de>
 * @package    ehemalige
 */

class ContentEhemalige extends \ContentElement {

	protected $strTemplate = 'ce_ehemalige';

	public function generate() {
		return parent::generate();
	}

	protected function compile() {
        global $objPage;

        $arrEntries    = array();
        $arrColumn     = null;
        $arrValues     = null;

        $jahrgang      = \Input::get('ehJahrgang');
        $arrJahrgang   = array(
            array('key' => 'all','val' => 'Alle Jahrgänge anzeigen','sel' => ('all' == $jahrgang) ? 'selected="selected" ' : '')
        );

        if (\Input::get('ehJahrgang') === '') {
            $this->redirect($this->addToUrl('ehJahrgang='));
        }

        $result = $this->Database->execute("SELECT DISTINCT jahrgang from tl_ehemalige ORDER BY jahrgang ASC");
        while($result->next()) {
            $arrJahrgang[] = array(
                'key'  => $result->jahrgang,
                'val'  => $result->jahrgang,
                'sel'  => ($result->jahrgang == $jahrgang) ? 'selected="selected" ' : ''
            );
        }

        $this->Template->action      = $this->generateFrontendUrl($objPage->row());
        $this->Template->arrJahrgang = $arrJahrgang;

        if(\Input::get('ehSearch')) {
            $filter     = '%'.trim(\Input::get('ehSearch')).'%';
            $arrColumn  = array("name LIKE ? OR vorname LIKE  ? OR email LIKE  ? OR email2 LIKE  ?
                            OR geburtsname LIKE ? OR homepage LIKE ? OR jahrgang LIKE ?");
            $arrValues = array($filter, $filter, $filter, $filter, $filter, $filter, $filter);
            $strOrder  = 'jahrgang ASC, name ASC';
        } elseif($jahrgang === 'all') {
            $strOrder   = 'jahrgang ASC, name ASC';
        } elseif($jahrgang) {
            $arrColumn  = array("jahrgang = ?");
            $arrValues  = array($jahrgang);
            $strOrder   = 'jahrgang ASC, name ASC';
        }
        else {
            // Nothing to do!
            return;
        }

        $ehemaligeCollection = \EhemaligeModel::findAll(array(
            'column'  => $arrColumn,
            'value'   => $arrValues,
            'order'   => $strOrder,
        ));
        $tmplEmail = '{{email::%s}}';
        $tmplHp    = '<a href="%s" target="_blank">%s</a>';
        if ($ehemaligeCollection) {
            foreach($ehemaligeCollection as $eObj) {

                $entry             = $eObj->row();

                $entry['kontakt']  = ($eObj->email) ? sprintf($tmplEmail, $eObj->email) : '';
                $entry['kontakt'] .= ($eObj->email2) ? ', '.sprintf($tmplEmail, $eObj->email2) : '';
                $entry['kontakt'] .= ($eObj->homepage) ? ', '.sprintf($tmplHp, $eObj->homepage, \String::substr($eObj->homepage, 32)) : '';

                $arrEntries[]      = $entry;
            }
        }
        $this->Template->entries     = $arrEntries;
	}
}
