<?php

/**
 * Class EhemaligenManager
 *
 * @copyright  Martin Kozianka 2014
 * @author     Martin Kozianka <http://kozianka.de>
 * @package    ehemalige
 */
use League\Csv\Writer;
use League\Csv\Reader;

class EhemaligenManager extends \System {
    private $filenamePrefix = '/files/ehemalige/ehemalige';
    private $filenameSuffix = '.csv';
    public function importCsv() {
        $this->import('Database');

        $filename = $this->filenamePrefix.$this->filenameSuffix;

        if (!file_exists(TL_ROOT.$filename)) {
            \Message::add(sprintf('Die Datei <strong>%s</strong> existiert nicht.', $filename), 'TL_ERROR');
            \Controller::redirect(\Environment::get('script').'?do=ehemalige');
        }


        $reader = Reader::createFromPath(TL_ROOT.$filename);

        // Check for correct headers
        $headers = $reader->fetchOne();
        foreach(\EhemaligeModel::$ARR_CSV_HEADER as $key) {
            if (!in_array($key, $headers)) {
                \Message::add(sprintf('Der Schlüssel <strong>%s</strong> fehlt in der Kopfzeile <strong>%s</strong> in der Datei %s.',
                    $key, implode(', ', $headers), $filename), 'TL_ERROR');
                \Controller::redirect(\Environment::get('script').'?do=ehemalige');
            }
        }

        $this->Database->execute('TRUNCATE TABLE tl_ehemalige');

        $arrRows = $reader->setOffset(1)->fetchAssoc($headers);
        $count = 0;
        foreach($arrRows as $row) {

            if ($row['name'] !== null && strlen($row['name']) > 0 ) {
                $row['tstamp'] = time();
                $objEhemalige = new \EhemaligeModel();
                $objEhemalige->setRow($row);
                $objEhemalige->save();
                $count++;
            }
        }

        \Message::add(sprintf('Es wurden <strong>%s</strong> Einträge aus der Datei <strong>%s</strong> importiert.',
            $count, $filename), 'TL_INFO');
        \Controller::redirect(\Environment::get('script').'?do=ehemalige');

    }

    public function exportCsv() {
        $message        = '%s Einträge in Datei <strong>%s</strong> exportiert.';
        $filename       = $this->filenamePrefix.$this->filenameSuffix;

        if (file_exists(TL_ROOT.$filename)) {
            $filename = $this->filenamePrefix.'-'.\Date::parse('Y-m-d_h-i-s').$this->filenameSuffix;
        }

        $writer     = Writer::createFromPath(TL_ROOT.$filename, 'w+');
        $collection = \EhemaligeModel::findAll(array('order' => 'name ASC'));

        // CSV-Header schreiben
        $writer->insertOne(EhemaligeModel::$ARR_CSV_HEADER);
        $count = 0;
        foreach($collection as $objEhemalige) {
            // CSV-Zeilen schreiben
            $writer->insertOne($objEhemalige->getCsvArray());
            $count++;
        }
        \Message::add(sprintf($message, $count, $filename), 'TL_INFO');
        \Controller::redirect(\Environment::get('script').'?do=ehemalige');
    }
}
