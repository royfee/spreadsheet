<?php
/**
 * Example: Load, modify, and output Excel file
 *
 * Loads an existing Excel file, adds a new row at the current position,
 * then outputs the modified file.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

$filepath = __DIR__ . '/import.xlsx';

Helper::newSpreadsheet($filepath)
    ->addRow(['Modified A1'])
    ->output('ModifiedExcel');
