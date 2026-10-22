<?php
/**
 * Example: Cell style attributes
 *
 * Demonstrates applying styles to individual cells and entire rows,
 * including font, alignment, borders, fill, and number formats.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

Helper::newSpreadsheet()
    // Individual cell styles
    ->addRow([
        'Percentage',
        '10%',
        ['value' => 'Styled Content', 'style' => [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFF0000'],
            ],
            'alignment' => ['horizontal' => 'right'],
            'borders' => [
                'top' => ['borderStyle' => 'thin'],
            ],
            'fill' => [
                'fillType' => 'linear',
                'rotation' => 90,
                'startColor' => ['argb' => 'FFA0A0A0'],
                'endColor' => ['argb' => 'FFFFFFFF'],
            ],
        ]],
        ['value' => '10000', 'style' => [
            'numberFormat' => [
                'formatCode' => '#,##0',
            ],
        ]],
    ])
    // Row with thousands separator format
    ->addRow(['1000', '2000', '3000', '4000'], ['style' => [
        'numberFormat' => [
            'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ],
    ]])
    // Row with percentage format
    ->addRow(['0.1', '0.15', '0.3145', '0.855'], ['style' => [
        'numberFormat' => [
            'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00,
        ],
    ]])
    ->save('StyleAttributes');
