<?php
/**
 * Example: Row and cell attributes
 *
 * Demonstrates how row attributes apply to all cells, and how cell attributes
 * can override row-level settings.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

// Row-level attributes (apply to all cells in the row)
$headRowAttributes = [
    'width' => 30,
    'style' => [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFF0000'],
        ],
        'alignment' => ['horizontal' => 'center'],
        'borders' => [
            'top' => ['borderStyle' => 'thin'],
        ],
        'fill' => [
            'fillType' => 'linear',
            'rotation' => 90,
            'startColor' => ['argb' => 'FFA0A0A0'],
            'endColor' => ['argb' => 'FFFFFFFF'],
        ],
    ],
];

// Row-level attributes for data rows
$rowAttributes = [
    'style' => [
        'font' => [
            'color' => ['argb' => 'FF00FF00'],
        ],
        'alignment' => ['horizontal' => 'right'],
    ],
];

Helper::newSpreadsheet()
    // Header row with row-level styling, some cells override
    ->addRow([
        'Header 1',
        'Header 2',
        ['value' => 'Custom Width', 'width' => 40],  // Override row width
        ['value' => 'Custom Style', 'style' => [       // Override row style
            'font' => ['color' => ['argb' => 'FF0000FF']],
        ]],
    ], $headRowAttributes)
    // Data rows with row-level styling
    ->addRows([
        ['Data 1', 'Data 2', 'Data 3', 'Data 4'],
        ['Data 5', 'Data 6', 'Data 7', 'Data 8'],
    ], $rowAttributes)
    ->output('RowAttributes');
