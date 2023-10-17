JsonLines
================
![Test](https://github.com/raphaelstolt/json-lines/workflows/Test/badge.svg)
[![Version](http://img.shields.io/packagist/v/stolt/json-lines.svg?style=flat)](https://packagist.org/packages/stolt/json-lines)
![PHP Version](http://img.shields.io/badge/php-8.0+-ff69b4.svg)

This is a library to __enline__ to the [JSON Lines](http://jsonlines.org/) format and to __deline__ back from it to JSON.

#### Installation via Composer
``` bash
$ composer require stolt/json-lines
```

#### Usage
To __enline__ a data structure into JSON Lines use the `enline` method.
```php
$jsonLines = (new JsonLines())->enline([
    ["one" => 1, "two" => 2],
    ["three" => 3, "four" => 4, "five" => 5],
    ["six" => 6, "seven" => 7, "key" => "value"],
    ["nested" => ["a", "b", "c"]],
]);
var_dump($jsonLines);
```
Which will give you the following JSON Lines string.
```text
string(107) "{"one":1,"two":2}
{"three":3,"four":4,"five":5}
{"six":6,"seven":7,"key":"value"}
{"nested":["a","b","c"]}
"
```
To __enline__ a data structure into a JSON Lines file use the `enlineToFile` method, adding the `gz` extension will gzip compress the JSON Lines as shown next.
```php
(new JsonLines())->enlineToFile([
    ["one" => 1, "two" => 2],
    ["three" => 3, "four" => 4, "five" => 5],
    ["six" => 6, "seven" => 7, "key" => "value"],
    ["nested" => ["a", "b", "c"]],
    'out.jsonl.gz'
]);
```

To __deline__ JSON Lines back into JSON use the `deline` method.
```php
$json = (new JsonLines())->deline('{"one":1,"two":2}
{"three":3,"four":4,"five":5}
{"six":6,"seven":7,"key":"value"}
{"nested":["a","b","c"]}'
);
var_dump($json)
```
Which will give you the following JSON string, which is _only_ beautified here to illustrate the data structure.
```text
string(287) "[
    {
        "one": 1,
        "two": 2
    },
    {
        "three": 3,
        "four": 4,
        "five": 5
    },
    {
        "six": 6,
        "seven": 7,
        "key": "value"
    },
    {
        "nested": [
            "a",
            "b",
            "c"
        ]
    }
]"
```

To __deline__ a complete JSON Lines file back into JSON use the `delineFromFile` method.
```php
$json = (new JsonLines())->delineFromFile('/path/to/enlined.jsonl');
```

To __deline__ a complete JSON Lines file line-by-line, use the `delineEachLineFromFile` method. This allows to iterate over a large file without storing the entire delined file in memory.
```php
$json_lines = (new JsonLines())->delineEachLineFromFile('/path/to/enlined.jsonl');
foreach ($json_lines as $json_line) {
    var_dump($json_line);
}
```

#### Running tests
``` bash
$ composer test
```

#### License
This library is licensed under the MIT license. Please see [LICENSE](LICENSE.md) for more details.

#### Changelog
Please see [CHANGELOG](CHANGELOG.md) for more details.

#### Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for more details.
