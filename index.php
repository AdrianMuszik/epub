<?php
declare(strict_types=1);

include_once(__DIR__.'/vendor/autoload.php');

use ePub\Exception\OutOfBoundsException;
use Epub\Service\DownloaderService;
use Epub\Service\XMLWriter;

const FILE_URLS = [
    "https://account.publishdrive.com/Books/Book1.epub",
    "https://account.publishdrive.com/Books/Book2.epub",
    "https://account.publishdrive.com/Books/Book3.epub",
    "https://account.publishdrive.com/Books/Book4.epub",

];
const ITEMS = [
    'title',
    'creator',
    'publisher'
];

$DownloadService = new DownloaderService();
$reader = new ePub\Reader();
$XMLWriter = new XMLWriter();
$data = [];
foreach(FILE_URLS as $fileURL) {
    $bookId = basename($fileURL);
    $filePath = $DownloadService->downloadUrL($fileURL);
    $ebook = $reader->load($filePath);
    $data[$bookId] = [];
    foreach( ITEMS as $item) {
        try {
            $data[$bookId][$item] = $ebook->getMetadata()->getValue($item);
        } catch(OutOfBoundsException $e) {
        }
    }
}
$XMLWriter->saveArrayAsXML($data, __DIR__."/temp");

