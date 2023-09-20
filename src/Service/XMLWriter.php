<?php

declare(strict_types=1);

namespace Epub\Service;

class XMLWriter
{
    public function saveArrayAsXML(array $array, string $saveLocation)
    {
        $x = new \XMLWriter();
        $x->openMemory();
        $x->startDocument("1.0");
        $this->traverseArray($x, $array);
        $x->endDocument();
        var_dump($x->outputMemory());
    }

    protected function traverseArray(\XMLWriter $x, array $array)
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
}
