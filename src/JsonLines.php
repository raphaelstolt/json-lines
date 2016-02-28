<?php

namespace Rs\JsonLines;

use Rs\JsonLines\Exception\InvalidJson;
use Rs\JsonLines\Exception\NonTraversable;

class JsonLines
{
    const LINE_SEPARATOR = "\n";

    /**
     * Checks if the given data structure is traversable.
     *
     * @param  mixed $data Possibly traversable data
     * @return boolean
     */
    protected function isTraversable($data)
    {
        if (!is_array($data) && !$data instanceof Traversable) {
            return false;
        }

        if (is_array($data) && count($data) === 0) {
            return false;
        }

        return true;
    }

    /**
     * Guards the JSON validity of the given JSON line and returns
     * its decode value.
     *
     * @param  mixed $line
     * @return \stdClass
     * @throws InvalidJson
     */
    protected function guardedJsonLine($line)
    {
        if (is_string($line)) {
            $guardedJsonLine = json_decode($line);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new InvalidJson('Invalid Json line detected');
            }

            return $guardedJsonLine;
        }
    }

    /**
     * Enlines a given data structure into JSON Lines.
     *
     * @param  mixed $data Data to enline as JSON Lines
     * @return string
     * @throws NonTraversable
     * @throws InvalidJson
     */
    public function enline($data)
    {
        if (!$this->isTraversable($data)) {
            throw new NonTraversable('Require something to travers');
        }

        $lines = [];
        foreach ($data as $line) {
            self::guardedJsonLine($line);
            $lines[] = json_encode($line, JSON_UNESCAPED_UNICODE);
        }

        return implode(self::LINE_SEPARATOR, $lines)
            . self::LINE_SEPARATOR;
    }

    /**
     * Delines given JSON Lines into JSON.
     *
     * @param  string $jsonLines JSON Lines to deline into JSON
     * @return string
     * @throws InvalidJson
     */
    public function deline($jsonLines)
    {
        if (empty($jsonLines)) {
            return json_encode([]);
        }
        $lines = [];
        $jsonLines = explode(self::LINE_SEPARATOR, trim($jsonLines));

        foreach ($jsonLines as $line) {
            $lines[] = self::guardedJsonLine($line);
        }

        return json_encode($lines);
    }
}
