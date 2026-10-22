<?php
/**
 * Example: Using PhpSpreadsheet's native fromArray() method
 *
 * Demonstrates how to extract the PhpSpreadsheet object from Helper
 * and use its native methods like fromArray().
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

// Get the PhpSpreadsheet object from Helper
$spreadsheet = Helper::newSpreadsheet()
    ->getSpreadsheet();

// Data array
$arrayData = [
    [null, 2010, 2011, 2012],
    ['Q1', 12,   15,   21],
    ['Q2', 56,   73,   86],
    ['Q3', 52,   61,   69],
    ['Q4', 30,   32,    0],
];

// Use native PhpSpreadsheet fromArray()
$spreadsheet->getActiveSheet()
    ->fromArray($arrayData, null)
    ->fromArray(
        $arrayData,  // Data to set
        null,        // Null value replacement
        'D5'         // Top-left coordinate (default is A1)
    );

Helper::save('FromArrayExample');
