<?php

namespace Rs\JsonLines;

class JsonLines
{
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

        return implode(PHP_EOL, $lines) . PHP_EOL;
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
        $jsonLines = explode(PHP_EOL, trim($jsonLines));

        foreach ($jsonLines as $line) {
            $lines[] = json_decode($line);
        }

        return json_encode($lines);
    }
}
