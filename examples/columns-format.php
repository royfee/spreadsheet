<?php
/**
 * Example: Column width formatting
 *
 * Demonstrates setting column widths using the 'width' attribute.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

Helper::newSpreadsheet()
    ->addRow([
        ['value' => 'ID', 'width' => 10],
        ['value' => 'Name', 'width' => 25],
        ['value' => 'Email', 'width' => 50],
    ])
    ->addRows([
        ['1', 'Nick', 'nick@example.com'],
        ['2', 'Eric', 'eric@example.com'],
    ])
    ->save('ColumnsFormat');
