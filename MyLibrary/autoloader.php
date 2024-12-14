<?php
// Autoloader for CsvToExcelConverter
spl_autoload_register(function ($class) {
    $prefix = 'MyLibrary\\';
    $baseDir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // Not part of MyLibrary, skip
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Autoloader for PhpSpreadsheet
spl_autoload_register(function ($class) {
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    $baseDir = __DIR__ . 'src/PhpSpreadsheet/src/PhpSpreadsheet/'; // Path to PhpSpreadsheet

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
