JsonLines
================
[![Build Status](https://secure.travis-ci.org/raphaelstolt/json-lines.png)](http://travis-ci.org/raphaelstolt/json-lines)
[![Version](http://img.shields.io/packagist/v/stolt/json-lines.svg?style=flat)](https://packagist.org/packages/stolt/json-lines)
![PHP Version](http://img.shields.io/badge/php-5.5+-ff69b4.svg)

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

#### Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information.

#### Running Tests
``` bash
$ composer test
```

#### Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for more details.

#### License
This library is licensed under the MIT license. Please see [License file](LICENSE.md) for more information.
