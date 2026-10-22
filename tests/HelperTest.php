<?php

namespace royfee\spreadsheet\tests;

use PHPUnit\Framework\TestCase;
use royfee\spreadsheet\Helper;

class HelperTest extends TestCase
{
    protected function setUp(): void
    {
        Helper::newSpreadsheet();
    }

    public function testNewSpreadsheetReturnsInstance(): void
    {
        $result = Helper::newSpreadsheet();
        $this->assertNotNull($result);
    }

    public function testGetSpreadsheetReturnsObject(): void
    {
        $spreadsheet = Helper::getSpreadsheet();
        $this->assertInstanceOf(\PhpOffice\PhpSpreadsheet\Spreadsheet::class, $spreadsheet);
    }

    public function testAddRowWritesData(): void
    {
        Helper::newSpreadsheet()
            ->addRow(['A1', 'B1', 'C1']);

        $sheet = Helper::getSheet();
        $this->assertSame('A1', $sheet->getCell([1, 1])->getValue());
        $this->assertSame('B1', $sheet->getCell([2, 1])->getValue());
        $this->assertSame('C1', $sheet->getCell([3, 1])->getValue());
    }

    public function testAddRowsWritesMultipleRows(): void
    {
        Helper::newSpreadsheet()
            ->addRows([
                ['Row1-Col1', 'Row1-Col2'],
                ['Row2-Col1', 'Row2-Col2'],
            ]);

        $sheet = Helper::getSheet();
        $this->assertSame('Row1-Col1', $sheet->getCell([1, 1])->getValue());
        $this->assertSame('Row2-Col1', $sheet->getCell([1, 2])->getValue());
        $this->assertSame('Row2-Col2', $sheet->getCell([2, 2])->getValue());
    }

    public function testAddDataWithHeaderMapping(): void
    {
        $headers = [
            ['field' => 'name', 'value' => 'Name'],
            ['field' => 'email', 'value' => 'Email'],
        ];
        $body = [
            ['name' => 'Nick', 'email' => 'nick@example.com'],
            ['name' => 'Eric', 'email' => 'eric@example.com'],
        ];

        Helper::newSpreadsheet()->addData($headers, $body);

        $sheet = Helper::getSheet();
        $this->assertSame('Name', $sheet->getCell([1, 1])->getValue());
        $this->assertSame('Email', $sheet->getCell([2, 1])->getValue());
        $this->assertSame('Nick', $sheet->getCell([1, 2])->getValue());
        $this->assertSame('eric@example.com', $sheet->getCell([2, 3])->getValue());
    }

    public function testAddDataWithIndexField(): void
    {
        $headers = [
            ['field' => 'index', 'value' => 'SN'],
            ['field' => 'name', 'value' => 'Name'],
        ];
        $body = [
            ['name' => 'Nick'],
            ['name' => 'Eric'],
        ];

        Helper::newSpreadsheet()->addData($headers, $body);

        $sheet = Helper::getSheet();
        $this->assertSame(1, $sheet->getCell([1, 2])->getValue());
        $this->assertSame(2, $sheet->getCell([1, 3])->getValue());
    }

    public function testGetRowReadsData(): void
    {
        Helper::newSpreadsheet()
            ->addRow(['A', 'B', 'C'])
            ->addRow(['D', 'E', 'F']);

        Helper::setRowOffset(0);
        $row = Helper::getRow();
        $this->assertSame(['A', 'B', 'C'], $row);
    }

    public function testGetRowsReadsAllData(): void
    {
        Helper::newSpreadsheet()
            ->addRows([
                ['A', 'B'],
                ['C', 'D'],
                ['E', 'F'],
            ]);

        $rows = Helper::getRows();
        $this->assertCount(3, $rows);
        $this->assertSame(['A', 'B'], $rows[0]);
        $this->assertSame(['E', 'F'], $rows[2]);
    }

    public function testGetRowsWithOffset(): void
    {
        Helper::newSpreadsheet()
            ->addRows([
                ['A', 'B'],
                ['C', 'D'],
                ['E', 'F'],
            ]);

        $rows = Helper::getRows(true, ['rowOffset' => 1, 'rows' => 2]);
        $this->assertCount(2, $rows);
        $this->assertSame(['C', 'D'], $rows[0]);
    }

    public function testSetSheetByIndex(): void
    {
        Helper::newSpreadsheet()
            ->setSheet(0, 'Sheet One')
            ->addRow(['Data on sheet 0']);

        Helper::setSheet(1, 'Sheet Two')
            ->addRow(['Data on sheet 1']);

        $this->assertSame(2, Helper::getSheetCount());
    }

    public function testSetSheetAutoCreatesSheets(): void
    {
        Helper::newSpreadsheet()
            ->setSheet(3, 'Fourth Sheet');

        $this->assertGreaterThanOrEqual(4, Helper::getSheetCount());
    }

    public function testSetSheetNormalizesTitle(): void
    {
        Helper::newSpreadsheet()
            ->setSheet(0, '*Invalid:Chars/Here?', true);

        $sheet = Helper::getSheet(0);
        $title = $sheet->getTitle();
        $this->assertStringNotContainsString('*', $title);
        $this->assertStringNotContainsString(':', $title);
        $this->assertStringNotContainsString('/', $title);
        $this->assertStringNotContainsString('?', $title);
    }

    public function testSetSheetTruncatesLongTitle(): void
    {
        $longTitle = str_repeat('A', 50);
        Helper::newSpreadsheet()
            ->setSheet(0, $longTitle, true);

        $sheet = Helper::getSheet(0);
        $this->assertSame(31, mb_strlen($sheet->getTitle()));
    }

    public function testRowOffset(): void
    {
        Helper::setRowOffset(5);
        $this->assertSame(5, Helper::getRowOffset());
    }

    public function testNum2alpha(): void
    {
        $this->assertSame('A', Helper::num2alpha(1));
        $this->assertSame('B', Helper::num2alpha(2));
        $this->assertSame('Z', Helper::num2alpha(26));
        $this->assertSame('AA', Helper::num2alpha(27));
        $this->assertSame('AB', Helper::num2alpha(28));
        $this->assertSame('AZ', Helper::num2alpha(52));
        $this->assertSame('BA', Helper::num2alpha(53));
    }

    public function testAlpha2num(): void
    {
        $this->assertSame(1, Helper::alpha2num('A'));
        $this->assertSame(2, Helper::alpha2num('B'));
        $this->assertSame(26, Helper::alpha2num('Z'));
        $this->assertSame(27, Helper::alpha2num('AA'));
        $this->assertSame(28, Helper::alpha2num('AB'));
        $this->assertSame(52, Helper::alpha2num('AZ'));
        $this->assertSame(53, Helper::alpha2num('BA'));
    }

    public function testNum2alphaAlpha2numRoundTrip(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            $alpha = Helper::num2alpha($i);
            $this->assertSame($i, Helper::alpha2num($alpha), "Round-trip failed for {$i} => {$alpha}");
        }
    }

    public function testCoordinateMap(): void
    {
        Helper::newSpreadsheet()
            ->addRow([
                ['key' => 'name', 'value' => 'Nick'],
                ['key' => 'email', 'value' => 'nick@test.com'],
            ]);

        $this->assertSame('A1', Helper::getCoordinateMap('name'));
        $this->assertSame('B1', Helper::getCoordinateMap('email'));
    }

    public function testColumnMap(): void
    {
        Helper::newSpreadsheet()
            ->addRow([
                ['key' => 'id', 'value' => '1'],
                ['key' => 'name', 'value' => 'Nick'],
            ]);

        $this->assertSame('A', Helper::getColumnMap('id'));
        $this->assertSame('B', Helper::getColumnMap('name'));
    }

    public function testRowMap(): void
    {
        Helper::newSpreadsheet()
            ->addRow([
                ['key' => 'first', 'value' => 'Row1'],
            ])
            ->addRow([
                ['key' => 'second', 'value' => 'Row2'],
            ]);

        $this->assertSame(1, Helper::getRowMap('first'));
        $this->assertSame(2, Helper::getRowMap('second'));
    }

    public function testRangeMapWithMerge(): void
    {
        Helper::newSpreadsheet()
            ->addRow([
                ['key' => 'merged', 'value' => 'Merged', 'col' => 2],
            ]);

        $range = Helper::getRangeMap('merged');
        $this->assertSame('A1:B1', $range);
    }

    public function testCellMergeWithColspan(): void
    {
        Helper::newSpreadsheet()
            ->addRow([
                ['value' => 'Merged', 'col' => 3],
            ]);

        $sheet = Helper::getSheet();
        $mergeCells = $sheet->getMergeCells();
        $this->assertNotEmpty($mergeCells);
        $this->assertContains('A1:C1', $mergeCells);
    }

    public function testCellMergeWithRowspan(): void
    {
        Helper::newSpreadsheet()
            ->addRow([
                ['value' => 'Merged', 'row' => 2],
            ]);

        $sheet = Helper::getSheet();
        $mergeCells = $sheet->getMergeCells();
        $this->assertNotEmpty($mergeCells);
        $this->assertContains('A1:A2', $mergeCells);
    }

    public function testSaveCreatesFile(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'spreadsheet_test_');

        $filepath = Helper::newSpreadsheet()
            ->addRow(['Test', 'Data'])
            ->save($tmpFile);

        $this->assertFileExists($filepath);
        $this->assertGreaterThan(0, filesize($filepath));

        @unlink($filepath);
    }

    public function testSaveAppendsExtension(): void
    {
        $tmpDir = sys_get_temp_dir();
        $basename = 'test_save_' . uniqid();
        $filepath = Helper::newSpreadsheet()
            ->addRow(['Test'])
            ->save("{$tmpDir}/{$basename}");

        $this->assertStringEndsWith('.xlsx', $filepath);
        $this->assertFileExists($filepath);

        @unlink($filepath);
    }

    public function testCellValueSetsSpecificCell(): void
    {
        Helper::newSpreadsheet();
        Helper::cellValue('A', 1, 'Hello');
        Helper::cellValue('B', 2, 'World');

        $sheet = Helper::getSheet();
        $this->assertSame('Hello', $sheet->getCell([1, 1])->getValue());
        $this->assertSame('World', $sheet->getCell([2, 2])->getValue());
    }

    public function testCellValueWithNumericColumn(): void
    {
        Helper::newSpreadsheet();
        Helper::cellValue(3, 1, 'Col3');

        $sheet = Helper::getSheet();
        $this->assertSame('Col3', $sheet->getCell([3, 1])->getValue());
    }

    public function testCellValueWithExplicitType(): void
    {
        Helper::newSpreadsheet();
        Helper::cellValue('A', 1, ['type' => 'STRING', 'value' => '123']);

        $sheet = Helper::getSheet();
        $cell = $sheet->getCell([1, 1]);
        $this->assertSame('123', $cell->getValue());
        $this->assertSame(\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING, $cell->getDataType());
    }

    public function testSetHeight(): void
    {
        Helper::newSpreadsheet()
            ->addRow(['Row with height'])
            ->setHeight(30);

        $sheet = Helper::getSheet();
        $this->assertSame(30.0, $sheet->getRowDimension(1)->getRowHeight());
    }

    public function testGetRangeAll(): void
    {
        Helper::newSpreadsheet()
            ->addRow(['A', 'B', 'C'])
            ->addRow(['D', 'E', 'F']);

        $range = Helper::getRangeAll();
        $this->assertSame('A1:C2', $range);
    }

    public function testSetAutoSize(): void
    {
        Helper::newSpreadsheet()
            ->addRow(['Short', 'A longer text value'])
            ->setAutoSize('A', 'B');

        $sheet = Helper::getSheet();
        $this->assertTrue($sheet->getColumnDimension('A')->getAutoSize());
        $this->assertTrue($sheet->getColumnDimension('B')->getAutoSize());
    }

    public function testSetWrapText(): void
    {
        Helper::newSpreadsheet()
            ->addRow(['Text that should wrap'])
            ->setWrapText('A1:A1');

        $sheet = Helper::getSheet();
        $this->assertTrue($sheet->getStyle('A1:A1')->getAlignment()->getWrapText());
    }

    public function testSetStyle(): void
    {
        Helper::newSpreadsheet()
            ->addRow(['Styled text'])
            ->setStyle([
                'font' => ['bold' => true],
            ], 'A1:A1');

        $sheet = Helper::getSheet();
        $this->assertTrue($sheet->getStyle('A1:A1')->getFont()->getBold());
    }

    public function testFluentInterface(): void
    {
        $result = Helper::newSpreadsheet()
            ->addRow(['A'])
            ->addRows([['B']])
            ->setRowOffset(5)
            ->setColumnOffset(0);

        $this->assertNotNull($result);
    }

    public function testInjectExistingSpreadsheet(): void
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getActiveSheet()->setCellValue([1, 1], 'Injected');

        Helper::newSpreadsheet($spreadsheet);
        Helper::setSheet(0);
        $sheet = Helper::getSheet();

        $this->assertSame('Injected', $sheet->getCell([1, 1])->getValue());
    }

    public function testGetRowReturnsEmptyArrayWhenPastLastRow(): void
    {
        Helper::newSpreadsheet()
            ->addRow(['Only', 'One', 'Row']);

        Helper::setRowOffset(0);
        Helper::getRow();
        $result = Helper::getRow();

        $this->assertSame([], $result);
    }

    public function testGetRowsWithCallback(): void
    {
        Helper::newSpreadsheet()
            ->addRow(['A', 'B']);

        $callbackValues = [];
        Helper::getRows(true, [], function ($value, $col, $row) use (&$callbackValues) {
            $callbackValues[] = $value;
        });

        $this->assertContains('A', $callbackValues);
        $this->assertContains('B', $callbackValues);
    }

    public function testSkipColumn(): void
    {
        Helper::newSpreadsheet()
            ->addRow([
                'A',
                ['skip' => 2],
                'D',
            ]);

        $sheet = Helper::getSheet();
        $this->assertSame('A', $sheet->getCell([1, 1])->getValue());
        $this->assertSame('D', $sheet->getCell([4, 1])->getValue());
    }

    public function testColumnWidth(): void
    {
        Helper::newSpreadsheet()
            ->addRow([
                ['value' => 'Wide Column', 'width' => 50],
            ]);

        $sheet = Helper::getSheet();
        $this->assertSame(50.0, $sheet->getColumnDimension('A')->getWidth());
    }

    public function testGetActiveSheetIndex(): void
    {
        Helper::newSpreadsheet()
            ->setSheet(0, 'First');

        $this->assertSame(0, Helper::getActiveSheetIndex());

        Helper::setSheet(1, 'Second');
        $this->assertSame(1, Helper::getActiveSheetIndex());
    }
}
