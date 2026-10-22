<?php
/**
 * Example: Loop through all rows with attribute key mapping
 *
 * Reads an Excel file row by row and maps columns to attribute keys.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

$filepath = __DIR__ . '/import.xlsx';

$helper = Helper::newSpreadsheet($filepath);

// Attribute keys for database table schema
$attrKeys = ['sn', 'value', 'number', 'tag', 'datetime'];

$headRow = $helper->getRow(); // Skip header row
$count = 0;

// Process each row
while ($row = $helper->getRow()) {
    $count++;
    $attr = [];
    foreach ($attrKeys as $key => $attrKey) {
        $attr[$attrKey] = $row[$key] ?? null;
    }
    echo "Row {$count} data with attributes format:\n";
    print_r($attr);
    echo str_repeat('-', 40) . "\n";
}

echo "Total rows processed: {$count}\n";