<?php

namespace Rs\JsonLines\Tests;

use Rs\JsonLines\JsonLines;
use PHPUnit_Framework_TestCase as PHPUnit;

class JsonLinesTest extends PHPUnit
{
    protected $jsonLines;

    public function setUp()
    {
        $this->jsonLines = new JsonLines();
    }
    /**
     * @test
     */
    public function enline()
    {

        $expectedLines = <<<JSON_LINES
{"one":1,"two":2}
{"three":3,"four":4,"five":5}
{"six":6,"seven":7,"key":"value"}
{"nested":["a","b","c"]}

JSON_LINES;

        $lines = $this->jsonLines->enline([
            ["one" => 1, "two" => 2],
            ["three" => 3, "four" => 4, "five" => 5],
            ["six" => 6, "seven" => 7, "key" => "value"],
            ["nested" => ["a", "b", "c"]],
        ]);

        $this->assertEquals($expectedLines, $lines);
    }

    /**
     * @test
     */
    public function enlineWithFixture()
    {
        $fedJson = file_get_contents(
            __DIR__ . '/fixtures/winning_hands.json'
        );
        $enlinedJson = file_get_contents(
            __DIR__ . '/fixtures/winning_hands.jsonl'
        );

        $this->assertEquals(
            $enlinedJson,
            $this->jsonLines->enline(json_decode($fedJson, true))
        );
    }

    /**
     * @test
     */
    public function deline()
    {
        $expectedJson = json_encode([
            ["one" => 1, "two" => 2],
            ["three" => 3, "four" => 4, "five" => 5],
            ["six" => 6, "seven" => 7, "key" => "value"],
            ["nested" => ["a", "b", "c"]],
        ]);

        $fedJsonLines = <<<JSON_LINES
{"one":1,"two":2}
{"three":3,"four":4,"five":5}
{"six":6,"seven":7,"key":"value"}
{"nested":["a","b","c"]}

JSON_LINES;

        $this->assertEquals(
            $expectedJson,
            $this->jsonLines->deline($fedJsonLines)
        );
        $this->assertEquals(
            "[]",
            $this->jsonLines->deline("")
        );
    }

    /**
     * @test
     */
    public function delineWithFixture()
    {
        $delinedJson = json_encode(json_decode(file_get_contents(
            __DIR__ . '/fixtures/winning_hands.json'
        )));

        $fedJsonLines = file_get_contents(
            __DIR__ . '/fixtures/winning_hands.jsonl'
        );

        $this->assertEquals(
            $delinedJson,
            $this->jsonLines->deline($fedJsonLines)
        );
    }
}
