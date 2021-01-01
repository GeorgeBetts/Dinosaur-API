<?php

namespace App\Library;

/**
 * This class is designed to handle prehistoric dates
 * in the format provided by wikidata
 *
 * The format is as follows:
 * -yyyy-mm-ddTh:m:sZ
 * e.g. "-155000000-01-01T00:00:00Z"
 *
 * The first parameter is the number of years before BCE
 * which is the only relevent value in this format
 */

class PrehistoricDate
{
    protected $date;

    public function __construct($date)
    {
        $this->setDate($date);
    }

    /**
     * Provides a human readable format for the date
     *
     * @return string | bool
     */
    public function humanReadable()
    {
        if ($this->date) {
            $yearsBce = explode('-', $this->date)[1];
            if (strlen($yearsBce) > 6) {
                $yearsBce = (intval($yearsBce) / 1000000) . ' million';
            }
            return $yearsBce . " years BCE";
        } else {
            return false;
        }
    }


    public function period()
    {
        if ($this->date) {
            $yearsBce = intval(explode('-', $this->date)[1]) / 1000000;
            switch (true) {
                case ($yearsBce < 0.0042):
                    return 'Modern';
                    break;
                case ($yearsBce >= 0.0042 && $yearsBce < 3.6):
                    return 'Quaternary';
                    break;
                case ($yearsBce >= 3.6 && $yearsBce < 28.1):
                    return 'Neogene';
                    break;
                case ($yearsBce >= 28.1 && $yearsBce < 72.1):
                    return 'Paleogene';
                    break;
                case ($yearsBce >= 72.1 && $yearsBce < 152.1):
                    return 'Cretaceous';
                    break;
                case ($yearsBce >= 152.1 && $yearsBce < 208.5):
                    return 'Jurassic';
                    break;
                case ($yearsBce >= 208.5 && $yearsBce < 254.14):
                    return 'Triassic';
                    break;
                case ($yearsBce >= 254.14 && $yearsBce < 303.7):
                    return 'Permian';
                    break;
                case ($yearsBce >= 303.7 && $yearsBce < 372.2):
                    return 'Carboniferous';
                    break;
                case ($yearsBce >= 372.2 && $yearsBce < 423):
                    return 'Devonian';
                    break;
                case ($yearsBce >= 423 && $yearsBce < 445.2):
                    return 'Silurian';
                    break;
                case ($yearsBce >= 445.2 && $yearsBce < 489.5):
                    return 'Ordovician';
                    break;
                case ($yearsBce >= 489.5 && $yearsBce < 635):
                    return 'Cambrian';
                    break;
                case ($yearsBce >= 635):
                    return 'Precambrian';
                    break;
                default:
                    return 'Unknown';
                    break;
            }
        } else {
            return false;
        }
    }

    public function yearsAgo()
    {
        // return how many years ago from today this date is
    }

    /**
     * Validates and sets the date property of the class
     *
     * @param [string] $date
     * @return void
     */
    protected function setDate($date)
    {
        if ($this->validate($date)) {
            $this->date = $date;
        } else {
            $this->date = false;
        }
    }

    /**
     * Validates a passed date string
     *
     * @param [string] $date
     * @return bool
     */
    protected function validate($date)
    {
        if (is_string($date)) {
            return preg_match_all('/^-[0-9]+-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]+Z$/', $date) > 0 ? true : false;
        } else {
            return false;
        }
    }
}
