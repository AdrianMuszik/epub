<?php

declare(strict_types=1);

namespace Epub\Service;

class epubCheckService
{
    public string $output;
    public function __construct(
        protected readonly string $pathToEpubCheck = "epubcheck.jar",
        public string $mode = "opf",
        public string $version = "2",
        public bool $returnOutputAsXML = true,
    )
    {}

    public function runChecker(string $filePath): ?string
    {
        if(!$filePath) {
            throw new \Exception("filePath is empty!");
        }
        //this should run but right now just mock results
        //$this->output = shell_exec("java -jar {$this->pathToEpubCheck} {$filePath} --mode {$this->mode} -v {$this->version} --out -");
        $this->output = "mock result";
        if($this->returnOutputAsXML) {
            return $this->output;
        }
        return null;
    }

}
