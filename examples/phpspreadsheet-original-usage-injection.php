<?php
/**
 * Example: Inject existing PhpSpreadsheet object
 *
 * Demonstrates how to create a PhpSpreadsheet object directly,
 * then inject it into the Helper for further manipulation.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

// Create PhpSpreadsheet object directly
$objSpreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$objSpreadsheet->getProperties()
    ->setCreator('Your Name')
    ->setTitle('Office 2007 XLSX Document');

// Get the active sheet and set initial data
$objSheet = $objSpreadsheet->setActiveSheetIndex(0);
$objSheet->setTitle('MySheet');
$objSheet->setCellValue('A1', 'SN');

// Inject into Helper and continue using the fluent API
Helper::newSpreadsheet($objSpreadsheet)
    ->setSheet($objSheet)
    ->setRowOffset(1)  // Start writing from row 2 (row 1 has 'SN')
    ->addRows([
        ['1'],
        ['2'],
        ['3'],
    ]);

Helper::output('InjectionExample');
