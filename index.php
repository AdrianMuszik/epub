<?php
declare(strict_types=1);

include_once(__DIR__.'/vendor/autoload.php');

use ePub\Exception\OutOfBoundsException;
use Epub\Service\DownloaderService;
use Epub\Service\XMLWriter;
use Epub\Service\epubCheckService;

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

const DOWNLOAD_DIR = __DIR__."/temp";

$DownloadService = new DownloaderService(DOWNLOAD_DIR);
$reader = new ePub\Reader();
$XMLWriter = new XMLWriter();
$checker = new epubCheckService();
$data = [];
foreach(FILE_URLS as $fileURL) {
    $bookId = basename($fileURL);
    $filePath = $DownloadService->downloadUrL($fileURL);
    $ebook = $reader->load($filePath);
    $data[$bookId] = [];
    $data[$bookId]['epubCheckResult'] = $checker->runChecker($filePath);
    foreach(ITEMS as $item) {
        try {
            $data[$bookId][$item] = $ebook->getMetadata()->getValue($item);
        } catch(OutOfBoundsException) {
            $data[$bookId][$item] = "";
        }
    }
}
$XMLWriter->saveArrayAsXML($data, DOWNLOAD_DIR, "collected");

