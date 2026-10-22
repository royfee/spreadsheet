<?php
/**
 * Example: Multiple sheets management
 *
 * Demonstrates creating, navigating, and naming multiple worksheets.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

// First sheet
Helper::newSpreadsheet()
    ->setSheet(0, 'First Sheet')
    ->addRow(['Sheet Index', 'Sheet Count'])
    ->addRows([
        [Helper::getActiveSheetIndex(), Helper::getSheetCount()],
    ]);

// Second sheet - set by title without giving index
Helper::setSheet(null, 'Second Sheet')
    ->addRow(['Sheet Index', 'Sheet Count'])
    ->addRows([
        [Helper::getActiveSheetIndex(), Helper::getSheetCount()],
    ]);

// Auto-create a sheet that doesn't exist yet
$obj = Helper::getSheet('Third Sheet', true);

// Sheet title normalization - invalid characters are removed
Helper::setSheet(null, '*This [sheet] name has been auto-normalizing', true)
    ->addRow(['Sheet Index', 'Sheet Count'])
    ->addRows([
        [Helper::getActiveSheetIndex(), Helper::getSheetCount()],
    ]);

Helper::save('MultiSheets');
