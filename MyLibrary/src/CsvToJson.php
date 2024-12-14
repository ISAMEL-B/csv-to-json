<?php

namespace CsvToExcelConverter;

use Exception;

/**
 * A library for converting CSV files to JSON format.
 */
class CsvToJson
{
    /**
     * Converts a CSV file to a JSON string.
     *
     * @param string $csvFilePath The path to the CSV file to be converted.
     * @param string $outputDir The directory to store logs for exceptions and errors.
     * @param string $delimiter The delimiter used to separate fields in the CSV file (default is a comma).
     * @param string $enclosure The character used to enclose fields in the CSV file (default is a double quote).
     * @param string $escape The escape character used in the CSV file (default is a backslash).
     * @return string JSON representation of the CSV file.
     * @throws Exception If the CSV file is missing, unreadable, or improperly formatted.
     */
    public static function convert(
        string $csvFilePath,
        string $outputDir = '../output',
        string $delimiter = ',',
        string $enclosure = '"',
        string $escape = '\\'
    ): string {
        // Check if the CSV file exists
        if (!file_exists($csvFilePath)) {
            throw new Exception("CSV file does not exist: $csvFilePath");
        }

        // Check if the CSV file is readable
        if (!is_readable($csvFilePath)) {
            throw new Exception("CSV file is not readable: $csvFilePath");
        }

        // Ensure the output directory exists or create it
        if (!is_dir($outputDir) && !mkdir($outputDir, 0755, true)) {
            throw new Exception("Failed to create output directory: $outputDir");
        }

        // Define the path for the exception log file
        $exceptionFile = "$outputDir/exception.txt";
        file_put_contents($exceptionFile, "CSV Processing Errors:\n", LOCK_EX);

        $data = []; // Array to store processed CSV data

        try {
            // Open the CSV file for reading
            if (($handle = fopen($csvFilePath, 'r')) === false) {
                throw new Exception("Failed to open CSV file: $csvFilePath");
            }

            // Read the header row (first row of the CSV)
            $headers = fgetcsv($handle, 0, $delimiter, $enclosure, $escape);
            if ($headers === false || empty($headers)) {
                throw new Exception("CSV file is empty or has invalid headers.");
            }

            // Process each row of the CSV file
            while (($row = fgetcsv($handle, 0, $delimiter, $enclosure, $escape)) !== false) {
                // Check if the number of columns matches the number of headers
                if (count($row) !== count($headers)) {
                    // Log mismatched rows in the exception file
                    file_put_contents(
                        $exceptionFile,
                        "Skipping row due to column mismatch: " . json_encode($row) . "\n",
                        FILE_APPEND | LOCK_EX
                    );
                    continue; // Skip the invalid row
                }

                // Combine the header and row data into an associative array
                $data[] = array_combine($headers, $row);
            }

            fclose($handle); // Close the CSV file
        } catch (Exception $e) {
            // Handle any errors encountered during processing
            throw new Exception("Error processing CSV file: {$e->getMessage()}", 0, $e);
        }

        // Convert the data array to a JSON string
        $json = json_encode($data, JSON_PRETTY_PRINT);
        if ($json === false) {
            // Handle JSON encoding errors
            throw new Exception("Failed to encode data to JSON: " . json_last_error_msg());
        }

        return $json; // Return the resulting JSON string
    }
}
