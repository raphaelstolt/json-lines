<?php

$test_data = [
'id' => rand(1, 15000),
'name' => 'Some name',
'documents' => [
    'id' => rand(50000, 60000),
    'name' => 'some_name',
    'location' => 'some_location',
    'creation' => date('Y-m-d'),
    'is_readable' => true,
],
];

$file = fopen(__DIR__ . '/tests/fixtures/metadata_catalogue.jsonl', 'w');
$json = [];
$dataSetCount = 7770;
foreach (range(0, $dataSetCount) as $i) {
    //9900
    fputs($file, json_encode($test_data) . "\n");
    $json[] = $test_data;
}
fclose($file);

file_put_contents(__DIR__ . '/tests/fixtures/metadata_catalogue.json', json_encode($json));

echo 'Generated ' . ($dataSetCount + 1) . ' datasets.' . PHP_EOL;
