<?php
/**
 * Example: Read all rows from Excel file
 *
 * Loads an existing Excel file and reads all rows into a 2D array.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

$filepath = __DIR__ . '/import.xlsx';

$data = Helper::newSpreadsheet($filepath)
    ->getRows();

echo "Total rows: " . count($data) . "\n\n";
print_r($data);
