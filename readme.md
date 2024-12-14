# CsvToJson Library

## Overview
The `CsvToJson` library is a PHP utility that converts CSV files to JSON format. It includes robust error handling and logs issues (e.g., row mismatches) in an `exception.txt` file within the `output` directory.

## Features
1. Converts CSV data into JSON format.
2. Logs row mismatches and errors to an `exception.txt` file.
3. Customizable CSV delimiters, enclosures, and escape characters.
4. Automatically creates an output directory for exceptions.

## Requirements
- PHP 7.2 or higher.

## Installation
Clone the repository or copy the `CsvToJson` class into your project:

Include the library in your PHP script:

```php
require_once 'MyLibrary/src/CsvToJson.php';
use MyLibrary\CsvToJson;
```

## Usage
### Basic Example
```php
use MyLibrary\CsvToJson;

try {
    $json = CsvToJson::convert('test_data/file.csv');
    echo $json;
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
```

### Parameters of the `convert` Method

| **Parameter**   | **Description**                        |**Default**         |
| `$csvFilePath`  | Path to the CSV file                   | N/A                |
| `$outputDir`    | Directory to store exception logs      |`output`            |
| `$delimiter`    | Field delimiter used in the CSV file   | `,` (comma)        |
| `$enclosure`    | Field enclosure character              | `"` (double quote) |
| `$escape`       | Escape character                       | `\\` (backslash)   |


### Advanced Example
```php
use MyLibrary\CsvToJson;

try {
    $json = CsvToJson::convert(
        'test_data/file.csv', // CSV file path
        'output',             // Custom output directory
        ';',                  // Delimiter (semicolon)
        '\''                  // Escape character
    );
    echo $json;
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
```

## Output
The JSON representation of the CSV data will be returned. Any row mismatches or errors will be logged in an `exception.txt` file within the output directory.

Example `exception.txt` content:

CSV Processing Errors:
Skipping row due to column mismatch: ["","","","","Isamel","70","75","78","73","80"]
Skipping row due to column mismatch: ["","","","","Grace","80","85","82","81","83"]