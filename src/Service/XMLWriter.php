<?php

declare(strict_types=1);

namespace Epub\Service;

class XMLWriter extends FileWriter
{
    public function saveArrayAsXML(array $array, string $saveLocation, string $saveFileName = "collected.xml"): void
    {
        $x = new \XMLWriter();
        $x->openMemory();
        $x->startDocument("1.0");
        $this->traverseArray($x, $array);
        $x->endDocument();
        $this->saveFile($x, $saveLocation, $saveFileName);
    }

    protected function traverseArray(\XMLWriter $x, array $array): void
    {
        foreach($array as $name => $item) {
            $x->startElement($name);
            if(is_array($item)) {
                $this->traverseArray($x, $item);
            } else {
                $x->text($item);
            }
            $x->endElement();
        }
    }

    protected function saveFile(\XMLWriter $x, string $saveLocation, string $saveFileName): void
    {
        $extension = pathinfo($saveFileName, PATHINFO_EXTENSION);
        $saveFileName .= empty($extension) ? '.xml' : '';
        $directory = realpath($saveLocation);
        $filePath = $directory . "/" . $saveFileName;
        var_dump($filePath);
        $fh = $this->openFile($filePath, 'w');
        $this->writeFile($fh, $x->outputMemory());
        $this->closeFile($fh);
    }
}
