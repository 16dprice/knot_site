<?php

class Simplify_PD_Content {

    public function __toString() {

        $container = new HTML_Element("div");

        $container->text .= $this->getFileUploadInput();

        $container->text .= $this->getInputFileContainer();
        $container->text .= $this->getOutputFileContainer();

        return $container->__toString();

    }

    private function getFileUploadInput() {

        $uploadContainer = new HTML_Element("table");
        $uploadContainer->class = " centered ";

        // build the file upload input and append to ul
        $inputText = "Select File to Upload:";
        $fileInputElement = new HTML_Element("input");
        $fileInputElement->type = "file";
        $fileInputElement->id = "pd_code_file_upload_input";

        $uploadContainer->text .= "<tr><td>$inputText</td><td>$fileInputElement</td></tr>";

        // build the file upload submit button and append to ul
        $fileSubmitElement = new HTML_Element("button");
        $fileSubmitElement->text = "Upload File";
        $fileSubmitElement->onclick = "uploadPDcodeToSimplify();";

        $uploadContainer->text .= "<tr><td colspan='2'>$fileSubmitElement</td></tr>";

        return $uploadContainer;

    }

    // a table will eventually go in here
    private function getInputFileContainer() {

        $container = new HTML_Element("div", ["id" => "inputFileContainer"]);

        return $container;

    }

    // a table will eventually go in here
    private function getOutputFileContainer() {

        $container = new HTML_Element("div", ["id" => "outputFileContainer"]);

        return $container;

    }

}