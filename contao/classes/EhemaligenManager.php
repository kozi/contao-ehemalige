<?php

/**
 * Class EhemaligenManager
 *
 * @copyright  Martin Kozianka 2014
 * @author     Martin Kozianka <http://kozianka.de>
 * @package    ehemalige
 */

class EhemaligenManager extends \System {
    private $filenamePrefix = '/files/ehemalige/ehemalige';
    private $filenameSuffix = '.csv';
    public function importCsv() {
        $filename = $this->filenamePrefix.$this->filenameSuffix;

        if (!file_exists(TL_ROOT.$filename)) {
            \Message::add(sprintf('Die Datei <strong>%s</strong> existiert nicht.', $filename), 'TL_ERROR');
            \Controller::redirect(\Environment::get('script').'?do=ehemalige');
        }

        $strInput = file_get_contents(TL_ROOT.$filename);
        if ($strInput === false) {
            \Message::add(sprintf('Der Inhalt der Datei <strong>%s</strong> konnte nicht gelesen werden.', $filename), 'TL_ERROR');
            \Controller::redirect(\Environment::get('script').'?do=ehemalige');
        }

        $arrCsv = str_getcsv($strInput);
        var_dump($arrCsv);

            // str_getcsv — Parst einen CSV-String in ein Array
            //  array str_getcsv ( string $input [, string $delimiter = ',' [, string $enclosure = '"' [, string $escape = '\\' ]]] )
        \Message::add('Importiert', 'TL_INFO');
        \Controller::redirect(\Environment::get('script').'?do=ehemalige');


    }

    public function exportCsv() {
        $message        = '%s Einträge in Datei <strong>%s</strong> exportiert.';
        $filename       = $this->filenamePrefix.$this->filenameSuffix;

        if (file_exists(TL_ROOT.$filename)) {
            $filename = $this->filenamePrefix.'-'.\Date::parse('Y-m-d_h-i-s').$this->filenameSuffix;
        }

        $fileHandle = fopen(TL_ROOT.$filename, 'w+');
        $collection = \EhemaligeModel::findAll(array('order' => 'name ASC'));

        // CSV-Header schreiben
        fputcsv($fileHandle, EhemaligeModel::$ARR_CSV_HEADER);
        $count = 0;
        foreach($collection as $objEhemalige) {
            // CSV-Zeilen schreiben
            fputcsv($fileHandle, $objEhemalige->getCsvArray());
            $count++;
        }
        fclose($fileHandle);

        \Message::add(sprintf($message, $count, $filename), 'TL_INFO');
        \Controller::redirect(\Environment::get('script').'?do=ehemalige');
    }
}
