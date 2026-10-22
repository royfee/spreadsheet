<?php
require __DIR__ . '/_config.php';
use \royfee\spreadsheet\Helper;

Helper::newSpreadsheet()
    ->addRows([
        [
            ['value'=>'SN', 'row'=>2, 'key'=>'sn'],
            ['value'=>'Language', 'col'=>2, 'key'=>'lang'],
            ['value'=>'Block', 'row'=>2, 'col'=>2, 'key'=>'block'],
        ],
        [
            '',
            ['value'=>'English', 'key'=>'lang-en'],
            ['value'=>'繁體中文', 'key'=>'lang-zh'],
            ['skip'=>2, 'key'=>'block-skip'],
        ],
    ])
    ->addRows([
        ['1', 'Computer','電腦','#15'],
        ['2', 'Phone','手機','#4','#62'],
    ]);

// Print coordinate maps (before output/save)
echo "=== Coordinate Map ===\n";
print_r(Helper::getCoordinateMap());

echo "\n=== Range Map ===\n";
print_r(Helper::getRangeMap());

echo "\n=== Specific Key Lookups ===\n";
echo "sn start cell: " . Helper::getCoordinateMap('sn') . "\n";
echo "sn start column: " . Helper::getColumnMap('sn') . "\n";
echo "sn start row: " . Helper::getRowMap('sn') . "\n";
echo "sn range: " . Helper::getRangeMap('sn') . "\n";
echo "All range: " . Helper::getRangeAll() . "\n";

// Save to file instead of output (output calls exit)
$filepath = Helper::save('MapOfCoordinates');
echo "\nSaved to: {$filepath}\n";