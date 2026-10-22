<?php
/**
 * Example: Extract PhpSpreadsheet object from Helper
 *
 * Demonstrates how to get the underlying PhpSpreadsheet and Sheet objects
 * from the Helper for direct manipulation.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

// Start with Helper
Helper::newSpreadsheet()
    ->setSheet(0, 'MySheet')
    ->addRow(['SN']);

// Extract the PhpSpreadsheet object
$objSpreadsheet = Helper::getSpreadsheet();
$objSpreadsheet->getProperties()
    ->setCreator('Your Name')
    ->setTitle('Office 2007 XLSX Document');

// Extract the active Sheet object
$objSheet = Helper::getSheet();
$objSheet->setCellValue('A2', '1');
$objSheet->setCellValue('A3', '2');

// Continue using Helper to output
Helper::output('ExtractExample');
