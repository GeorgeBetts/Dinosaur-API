<?php

namespace App\Library;

use InvalidArgumentException;

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
     * @return string
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
        // return the geologic period of the date e.g. Jurassic
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
