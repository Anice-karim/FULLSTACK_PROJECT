<?php
/**
 * Barcode Generator using Picqer PHP Barcode Generator library
 * 
 * This file requires Composer and the picqer/php-barcode-generator package
 * Install with: composer require picqer/php-barcode-generator
 */

// Define and require Composer autoloader
$autoloadPath = __DIR__ . '/../../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die("Composer autoload.php not found. Please run 'composer install'.");
}
require $autoloadPath;

// Import the barcode generator class
use Picqer\Barcode\BarcodeGeneratorPNG;

/**
 * Generate a Code 128 barcode and save it as a PNG file
 * 
 * @param string $text The text to encode in the barcode
 * @param string $filepath The path where the PNG file should be saved
 * @param int $width The width factor of the barcode
 * @param int $height The height of the barcode
 * @return bool True if saved successfully, false otherwise
 */
function generateBarcodePNG($text, $filepath, $width = 2, $height = 80) {
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($text, $generator::TYPE_CODE_128, $width, $height);

    $dir = dirname($filepath);
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0755, true)) {
            echo "Failed to create directory: $dir";
            return false;
        }
    }
    if (!is_writable($dir)) {
        echo "Directory not writable: $dir";
        return false;
    }
    if (file_put_contents($filepath, $barcode) === false) {
        echo "Failed to write barcode image to file: $filepath";
        return false;
    }
    return true;
}


/**
 * Output a Code 128 barcode image directly to the browser
 * 
 * @param string $text The text to encode in the barcode
 * @param int $width The width factor
 * @param int $height The height of the barcode
 */
function outputBarcodePNG($text, $width = 2, $height = 80) {
    try {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($text, $generator::TYPE_CODE_128, $width, $height);

        header('Content-Type: image/png');
        echo $barcode;
    } catch (Exception $e) {
        header('Content-Type: text/plain');
        echo 'Error generating barcode: ' . $e->getMessage();
    }
}

// Example usage (when script is called directly)
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    $text = $_GET['text'] ?? 'TEST123';

    if (isset($_GET['output']) && $_GET['output'] === 'direct') {
        outputBarcodePNG($text);
    } else {
        $filename = $_GET['filename'] ?? 'barcode_' . time() . '.png';
        if (!preg_match('/\.png$/i', $filename)) {
            $filename .= '.png';
        }

        $dir = __DIR__ . '/barcodes';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filepath = $dir . '/' . $filename;
        $success = generateBarcodePNG($text, $filepath);

        if ($success) {
            echo "Barcode generated successfully: $filepath<br>";
            echo "<img src='barcodes/$filename' alt='Generated Barcode'>";
        } else {
            echo "Failed to generate barcode. Check PHP error logs for details.";
        }
    }
}
?>
