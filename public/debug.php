<?php
// Tymczasowy plik diagnostyczny - USUŃ PO DEBUGOWANIU!
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>PHP Info</h2>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Required: 8.3+<br><br>";

echo "<h2>Required Extensions</h2>";
$extensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo'];
foreach ($extensions as $ext) {
    $status = extension_loaded($ext) ? '✅' : '❌';
    echo "$status $ext<br>";
}

echo "<h2>Paths</h2>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script: " . __FILE__ . "<br>";
echo "Dir: " . __DIR__ . "<br>";

echo "<h2>Storage Writable</h2>";
$storagePath = __DIR__ . '/../storage';
$logsPath = __DIR__ . '/../storage/logs';
$cachePath = __DIR__ . '/../storage/framework/cache';
$viewsPath = __DIR__ . '/../storage/framework/views';
$sessionsPath = __DIR__ . '/../storage/framework/sessions';

$paths = [
    'storage' => $storagePath,
    'storage/logs' => $logsPath,
    'storage/framework/cache' => $cachePath,
    'storage/framework/views' => $viewsPath,
    'storage/framework/sessions' => $sessionsPath,
];

foreach ($paths as $name => $path) {
    $exists = file_exists($path) ? 'exists' : 'MISSING';
    $writable = is_writable($path) ? '✅ writable' : '❌ NOT writable';
    echo "$name: $exists, $writable<br>";
}

echo "<h2>Env File</h2>";
$envPath = __DIR__ . '/../.env';
echo file_exists($envPath) ? '✅ .env exists' : '❌ .env MISSING';
echo "<br>";

echo "<h2>Vendor</h2>";
$vendorPath = __DIR__ . '/../vendor/autoload.php';
echo file_exists($vendorPath) ? '✅ vendor/autoload.php exists' : '❌ vendor/autoload.php MISSING - run composer install';
echo "<br>";

echo "<h2>Try Bootstrap</h2>";
try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "✅ Autoload OK<br>";

    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "✅ Bootstrap OK<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
