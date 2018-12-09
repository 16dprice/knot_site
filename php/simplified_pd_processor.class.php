<?php

class Simplified_PD_Processor {

    private $inputFile;
    private $outputFile;

    public function __construct($inputFile = NULL, $outputFile = NULL) {

        $this->inputFile = $inputFile;
        $this->outputFile = $outputFile;

    }

    public function getInputFileContainer() {

        $container = new HTML_Element("div");

        $lines = [];

        while(!feof($this->inputFile)) {
            $line = fgets($this->inputFile);
            if($line != "\n") {
                $lines[] = $line;
            }
        }

        foreach($lines as $line) {

        }

    }


}