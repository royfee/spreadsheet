<?php
/**
 * Example: Save spreadsheet to file
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

$savePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'save_example';

$filepath = Helper::newSpreadsheet()
    ->addRow(['ID', 'Name', 'Email'])
    ->addRows([
        ['1', 'Nick', 'nick@example.com'],
        ['2', 'Eric', 'eric@example.com'],
    ])
    ->save($savePath);

echo "Successfully wrote to: {$filepath}\n";
