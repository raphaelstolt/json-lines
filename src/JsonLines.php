<?php

namespace Rs\JsonLines;

use Rs\JsonLines\Exception\File\NonReadable;
use Rs\JsonLines\Exception\File\NonWriteable;
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
     * @throws InvalidJson
     * @return \stdClass
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
     * @throws NonTraversable
     * @throws InvalidJson
     * @return string
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
     * Enlines a given data structure into a JSON Lines file.
     *
     * @param  mixed  $data Data to enline as JSON Lines
     * @param  string $file Path of the file to enline to. Adding the `gz`
     *                      extension will gzip compress the JSON Lines.
     * @throws NonTraversable
     * @throws InvalidJson
     * @return void
     */
    public function enlineToFile($data, $file)
    {
        if (!$fileHandle = @fopen($file, 'w')) {
            throw new NonWriteable('Non writeable file');
        }

        $ext = pathinfo($file, PATHINFO_EXTENSION);

        foreach ($data as $line) {
            self::guardedJsonLine($line);
            $jsonLine = json_encode($line, JSON_UNESCAPED_UNICODE)
                . self::LINE_SEPARATOR;
            if ($ext === 'gz') {
                $jsonLine = gzencode($jsonLine);
            }
            fputs($fileHandle, $jsonLine);
        }

        fclose($fileHandle);
    }

    /**
     * Delines given JSON Lines into JSON.
     *
     * @param  string $jsonLines JSON Lines to deline into JSON
     * @throws InvalidJson
     * @return string
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

    /**
     * Yields file lines.
     *
     * @param  string $file
     * @throws NonReadable
     * @return string
     */
    protected function getFileLines($file)
    {
        if (!$fileHandle = @fopen($file, 'r')) {
            throw new NonReadable('Non existent or non readable file');
        }

        while ($line = fgets($fileHandle)) {
            yield $line;
        }

        fclose($fileHandle);
    }

    /**
     * Delines from a given JSON Lines file into JSON.
     *
     * @param  string $jsonLinesFile
     * @throws NonReadable
     * @return string
     */
    public function delineFromFile($jsonLinesFile)
    {
        $jsonLines = [];
        foreach ($this->getFileLines($jsonLinesFile) as $line) {
            $this->guardedJsonLine($line);
            $jsonLines[] = trim($line);
        }

        return '[' . implode(',', $jsonLines) . ']';
    }
    
    /**
     * Delines the next given JSON Lines file into JSON.
     *
     * @param  string $jsonLinesFile
     * @throws NonReadable
     * @return string
     */
    public function delineEachLineFromFile($jsonLinesFile)
    {
        $jsonLines = [];
        foreach ($this->getFileLines($jsonLinesFile) as $line) {
            $this->guardedJsonLine($line);
            yield trim($line);
        }

    }
}
