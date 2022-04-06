<?php

require __DIR__ . '/_config.php';

$row = [];
for ($i=1; $i <= 100 ; $i++) { 
    $value = \royfee\spreadsheet\Helper::num2alpha($i);
    $row[] = $value;
}
exit;
\yidas\phpSpreadsheet\Helper::newSpreadsheet()
    ->addRow($row)
    ->output();