<?php

namespace royfee\spreadsheet\tests;

use PHPUnit\Framework\TestCase;
use royfee\spreadsheet\xml\Excelxml;
use royfee\spreadsheet\xml\Export;

class ExcelxmlTest extends TestCase
{
    public function testAddWorksheetAndGetWorkbook(): void
    {
        $xml = new Excelxml('UTF-8');
        $xml->addWorksheet('TestSheet', [
            ['Name', 'Age'],
            ['Nick', '30'],
        ]);

        $output = $xml->getWorkbook();

        $this->assertStringContainsString('<?xml version="1.0"', $output);
        $this->assertStringContainsString('TestSheet', $output);
        $this->assertStringContainsString('Nick', $output);
        $this->assertStringContainsString('30', $output);
        $this->assertStringContainsString('</Workbook>', $output);
    }

    public function testNumericCellType(): void
    {
        $xml = new Excelxml('UTF-8');
        $xml->addWorksheet('Numbers', [
            [100, 200],
        ]);

        $output = $xml->getWorkbook();
        $this->assertStringContainsString('ss:Type="Number"', $output);
    }

    public function testStringCellTypeForLeadingZero(): void
    {
        $xml = new Excelxml('UTF-8');
        $xml->addWorksheet('Phone', [
            ['0123456'],
        ]);

        $output = $xml->getWorkbook();
        $this->assertStringContainsString('ss:Type="String"', $output);
    }

    public function testWriteWorkbookToFile(): void
    {
        $tmpFile = 'test_xml_export_' . uniqid() . '.xml';
        $tmpDir = sys_get_temp_dir();

        $xml = new Excelxml('UTF-8');
        $xml->addWorksheet('Sheet1', [
            ['A', 'B'],
            ['C', 'D'],
        ]);

        $result = $xml->writeWorkbook($tmpFile, $tmpDir . '/');
        $this->assertStringContainsString('written', $result);

        $filepath = $tmpDir . '/' . $tmpFile;
        $this->assertFileExists($filepath);
        $this->assertGreaterThan(0, filesize($filepath));

        @unlink($filepath);
    }

    public function testWorksheetTitleSanitization(): void
    {
        $xml = new Excelxml('UTF-8');
        $xml->addWorksheet('Invalid:Title/With*Bad?Chars', [
            ['data'],
        ]);

        $output = $xml->getWorkbook();
        preg_match('/ss:Name="([^"]*)"/', $output, $matches);
        $title = $matches[1] ?? '';
        $this->assertStringNotContainsString(':', $title);
        $this->assertStringNotContainsString('/', $title);
        $this->assertStringNotContainsString('*', $title);
        $this->assertStringNotContainsString('?', $title);
    }

    public function testMultipleWorksheets(): void
    {
        $xml = new Excelxml('UTF-8');
        $xml->addWorksheet('Sheet1', [['A']]);
        $xml->addWorksheet('Sheet2', [['B']]);

        $output = $xml->getWorkbook();
        $this->assertStringContainsString('Sheet1', $output);
        $this->assertStringContainsString('Sheet2', $output);
    }

    public function testExportFluentInterface(): void
    {
        $export = new Export();
        $result = $export->newSheet()
            ->addRow(['Header1', 'Header2'])
            ->addRows([
                ['Data1', 'Data2'],
                ['Data3', 'Data4'],
            ]);

        $this->assertInstanceOf(Export::class, $result);
    }

    public function testExportAddSheet(): void
    {
        $export = new Export();
        $export->addSheet(0, 'First Sheet');
        $export->addSheet(1, 'Second Sheet');
        $export->addRow(['Data on second sheet']);

        $output = $export->getWorkbook();
        $this->assertStringContainsString('First Sheet', $output);
        $this->assertStringContainsString('Second Sheet', $output);
    }

    public function testExportAddData(): void
    {
        $export = new Export();
        $export->newSheet()
            ->addData([
                ['A', 'B'],
                ['C', 'D'],
            ]);

        $output = $export->getWorkbook();
        $this->assertStringContainsString('A', $output);
        $this->assertStringContainsString('D', $output);
    }
}
