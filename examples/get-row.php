<?php
/**
 * Example: Read Excel file - Get first two rows
 *
 * Loads an existing Excel file and reads the first two rows.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

$filepath = __DIR__ . '/import.xlsx';

$row1 = Helper::newSpreadsheet($filepath)
    ->getRow();

$row2 = Helper::getRow();

echo "Row 1:\n";
print_r($row1);
echo "\nRow 2:\n";
print_r($row2);
