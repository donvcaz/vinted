<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.24
 * Time: 18.20
 */

namespace AppBundle\Service;


use Symfony\Component\HttpKernel\Kernel;

class TextFileService {

    const FILE_LINE_DELIMITER = ' ';

    private $handle;

    private $fileName;

    public function __construct(Kernel $kernel, $fileName) {
        $this->fileName = $kernel->locateResource($fileName);
    }

    public function next(){
        if(!$this->handle){
            $this->handle = $this->readFile();
        }
        if($this->handle && ($line = fgets($this->handle)) !== false) {
            return trim($line);
        } else {
            $this->closeFile();
            return false;
        }
    }

    private function readFile()
    {
        return fopen($this->fileName, "r");
    }

    private function closeFile()
    {
        fclose($this->handle);
        $this->handle = null;
    }

} 