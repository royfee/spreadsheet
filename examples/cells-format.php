<?php
/**
 * Example: Using addData() with header field mapping
 *
 * Demonstrates how to define headers with 'field' keys and map body data to columns.
 * The 'field' => 'index' auto-generates row numbers.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

$filepath = Helper::newSpreadsheet()
    ->addData(
        // Header definition with field mapping
        [
            ['field' => 'index', 'value' => 'No.', 'width' => 10],
            ['field' => 'name', 'value' => 'Name', 'width' => 20],
            ['field' => 'sex', 'value' => 'Sex', 'width' => 10],
            ['field' => 'email', 'value' => 'Email', 'width' => 30],
        ],
        // Body data - field names map to columns
        [
            ['name' => 'Zhang San', 'sex' => 'M', 'email' => 'zhangsan@example.com'],
            ['name' => 'Li Si', 'sex' => 'F', 'email' => 'lisi@example.com'],
            ['name' => 'Wang Wu', 'sex' => 'M', 'email' => 'wangwu@example.com'],
        ]
    )
    ->save('CellsFormat');

echo "Saved to: {$filepath}\n";