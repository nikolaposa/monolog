<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Monolog\Logger;

/**
 * Used for testing purposes.
 *
 * It records all records and gives you access to them for verification.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class TestHandler extends AbstractHandler
{
    protected $records;
    protected $recordsByLevel;

    public function getRecords()
    {
        return $this->records;
    }

    public function hasError($record)
    {
        return $this->hasRecord($record, Logger::ERROR);
    }

    public function hasWarning($record)
    {
        return $this->hasRecord($record, Logger::WARNING);
    }

    public function hasInfo($record)
    {
        return $this->hasRecord($record, Logger::INFO);
    }

    public function hasDebug($record)
    {
        return $this->hasRecord($record, Logger::DEBUG);
    }

    public function hasErrorrecords()
    {
        return isset($this->recordsByLevel[Logger::ERROR]);
    }

    public function hasWarningrecords()
    {
        return isset($this->recordsByLevel[Logger::WARNING]);
    }

    public function hasInforecords()
    {
        return isset($this->recordsByLevel[Logger::INFO]);
    }

    public function hasDebugrecords()
    {
        return isset($this->recordsByLevel[Logger::DEBUG]);
    }

    protected function hasRecord($record, $level = null)
    {
        if (null === $level) {
            $records = $this->records;
        } else {
            $records = $this->recordsByLevel[$level];
        }
        foreach ($records as $msg) {
            if ($msg['message'] === $record) {
                return true;
            }
        }
        return false;
    }

    public function write($record)
    {
        $this->recordsByLevel[$record['level']][] = $record;
        $this->records[] = $record;
    }
}