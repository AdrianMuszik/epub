<?php

declare(strict_types=1);

namespace Epub\Service;

class FileWriter
{
    public function openFile(string $filePath, string $mode = "a+")
    {
        return fopen($filePath, $mode);
    }

    public function writeFile($fileStream, string $stringToWrite): bool
    {
        if(!$this->isOpen($fileStream)) {
            throw new \ErrorException("fileStream is eather not a a fileStream or was closed!");
        }
        if(fwrite($fileStream, $stringToWrite) === false) {
            throw new \ErrorException("Could not write to file");
        }
        return true;
    }

    public function closeFile($fileStream): bool
    {
        if(!$this->isOpen($fileStream)) {
            return true;
        }
        return fclose($fileStream);

    }

    protected function isOpen($fileStream) : bool
    {
        return is_resource($fileStream);
    }
}
