<?php

declare(strict_types=1);

namespace Epub\Service;

class DownloaderService
{
    public function __construct(
        protected readonly string $downloadDir = __DIR__."/../../temp",
    )
    {}

    public function downloadUrL(string $url): string
    {
        if(!$url) {
            throw new \Exception("url is empty!");
        }
        $this->directoryExists();
        return $this->DownloadFile($url);


    }

    protected function directoryExists(): void {
        if(!file_exists($this->downloadDir)) {
            if(!mkdir($this->downloadDir)) {
                throw new \ErrorException("Cant create directory: " . $this->downloadDir);
            }
        }
    }

    protected function DownloadFile(string $url): string
    {
        $fileName = basename($url);
        $filePath = $this->downloadDir."/". $fileName;
        if(file_exists($filePath)) {
            return $filePath;
        }
        $ch = curl_init($url);
        $fp = fopen($filePath, 'wb');

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if(curl_exec($ch)) {
            curl_close($ch);
        fclose($fp);
        return $filePath;
        } else {
            throw new \ErrorException(curl_error($ch));
        }

    }
}
