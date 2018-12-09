<?php

class Simplified_PD_Processor {

    // the input and output files for Jason's C code
    private $inputFile;
    private $outputFile;

    // arrays containing the pd codes from the input and output files
    // they look like: array(0 => "PD[X[.....]]", 1 => "PD[X[.....]]", ... )
    private $inputPDs;
    private $outputPDs;

    public function __construct($inputFile = NULL, $outputFile = NULL) {

        $this->inputFile = $inputFile;
        $this->outputFile = $outputFile;

        $this->initInputPDs();
        $this->initOutputPDs();

    }

    private function initInputPDs() {

        $this->inputPDs = $this->getPDsFromTxtFile($this->inputFile);

    }

    private function initOutputPDs() {

        $this->outputPDs = $this->getPDsFromTxtFile($this->outputFile);

    }

    private function getPDsFromTxtFile($file) {

        $pdCount = -1;
        $PDs = [];

        while(!feof($file)) {

            $line = fgets($file);

            if(strpos($line, "PD") !== false) {
                // if the line has PD in it, it's a new pd code
                $pdCount++;

                $PDs[$pdCount] = $line;

            } else if(strpos($line, "X[") !== false) {
                // if the line didn't have PD in it but does have X[ in it, it's not the end of the pd code yet
                // so append it
                $PDs[$pdCount] .= $line;
            }

        }

        return $PDs;

    }

    public function getInputFileContainer() {

        $table = new HTML_Element("table");
        $table->style = "width: 80%;";

        foreach($this->inputPDs as $key => $pd) {
            $tr = new HTML_Element("tr");
            $tr->text .= $pd;

            $table->text .= $tr;
        }

        return $table;

    }


}