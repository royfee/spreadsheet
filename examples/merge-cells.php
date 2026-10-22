<?php
/**
 * Example: Cell merging with colspan and rowspan
 *
 * Demonstrates how to merge cells using 'col' (colspan) and 'row' (rowspan) attributes.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

Helper::newSpreadsheet()
    ->addRows([
        // Header row with merged cells
        [
            ['value' => 'SN', 'row' => 2],           // Merges vertically (rowspan=2)
            ['value' => 'Language', 'col' => 2],      // Merges horizontally (colspan=2)
            ['value' => 'Block', 'row' => 2, 'col' => 2], // Merges both ways
        ],
        // Sub-header row
        [
            '',                                       // Skipped (merged above)
            'English',
            '繁體中文',
            ['skip' => 2],                            // Skip 2 columns (merged above)
        ],
    ])
    ->addRows([
        ['1', 'Computer', '電腦', '#15'],
        ['2', 'Phone', '手機', '#4', '#62'],
    ])
    ->save('MergedExcel');
