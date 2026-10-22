<?php
/**
 * Example: Basic write - Output Excel to browser
 *
 * Creates a simple spreadsheet with headers and data rows,
 * then streams it to the browser for download.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

Helper::newSpreadsheet()
    ->addRow(['ID', 'Name', 'Email'])
    ->addRows([
        ['1', 'Nick', 'nick@example.com'],
        ['2', 'Eric', 'eric@example.com'],
    ])
    ->save('MyExcel');
