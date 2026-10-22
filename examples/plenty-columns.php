<?php
/**
 * Example: Testing num2alpha() for columns 1-100
 *
 * This demonstrates the column number to letter conversion.
 */
require __DIR__ . '/_config.php';

use \royfee\spreadsheet\Helper;

// Generate column letters for columns 1-100
$columns = [];
for ($i = 1; $i <= 100; $i++) {
    $columns[$i] = Helper::num2alpha($i);
}

echo "Column number to letter mapping (1-100):\n";
echo str_repeat('-', 50) . "\n";

foreach ($columns as $num => $letter) {
    printf("%3d => %s\n", $num, $letter);
}

// Verify round-trip conversion
echo "\n" . str_repeat('-', 50) . "\n";
echo "Verifying round-trip conversion (alpha2num):\n";
$errors = 0;
foreach ($columns as $num => $letter) {
    $backToNum = Helper::alpha2num($letter);
    if ($backToNum !== $num) {
        echo "ERROR: {$num} => {$letter} => {$backToNum}\n";
        $errors++;
    }
}
echo $errors === 0 ? "All conversions correct!\n" : "Found {$errors} errors.\n";