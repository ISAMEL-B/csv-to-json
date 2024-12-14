<?php

require '../autoloader.php';

use MyLibrary\CsvToJson;
require '../src/CsvToJson';
// Prompt the user to enter the path to the CSV file
echo "Enter the full path to the CSV file: ";
$csvFilePath = trim(fgets(STDIN)); // Read user input from the terminal

// Check if the file exists
if (!file_exists($csvFilePath)) {
    echo "The specified CSV file does not exist. Exiting..\n";
    exit(1);
}

// Extract the name of the CSV file without its extension
$csvFileName = pathinfo($csvFilePath, PATHINFO_FILENAME);

// Create the output folder if it doesn't exist
$outputDir = '../output';
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true); // Create the folder with proper permissions
}

// Set the output file name with the same name as the CSV, but with a .json extension
$outputFileName = $csvFileName . '.json';
$outputFilePath = $outputDir . DIRECTORY_SEPARATOR . $outputFileName;

try {
    // Convert the CSV to JSON
    $json = CsvToJson::convert($csvFilePath);

    // Write the JSON to the output file
    file_put_contents($outputFilePath, $json);

    echo "JSON file created successfully: $outputFilePath\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
