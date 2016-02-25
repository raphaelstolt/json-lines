JsonLines
================
![PHP Version](http://img.shields.io/badge/php-5.6+-ff69b4.svg)

This is a library to `enline` to the [JSON Lines](http://jsonlines.org/) format and to `deline` back from it to JSON.

#### Installation via Composer
``` bash
$ composer require rs/json-lines
```

#### Usage
To `enline` a data structure into JSON Lines use the enline method. The current implementation __doesn't__ persist the result into a `.jsonl` file.
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

To `deline` JSON Lines back into JSON use the deline method.
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
