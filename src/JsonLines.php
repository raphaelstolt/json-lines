<?php

namespace Rs\JsonLines;

class JsonLines
{
    const LINE_SEPARATOR = "\r\n";

    /**
     * @param  mixed $data Data to enline as JSON Lines
     * @return string
     */
    public function enline($data)
    {

        $lines = [];
        foreach ($data as $line) {
            if (is_array($line)) {
                $line = json_encode($line, JSON_UNESCAPED_UNICODE);
            }

            $lines[] = $line;
        }

        return implode(self::LINE_SEPARATOR, $lines)
            . self::LINE_SEPARATOR;
    }

    /**
     * @param  string $jsonLines JSON Lines to deline into JSON
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
            $lines[] = json_decode($line);
        }

        return json_encode($lines);
    }
}
