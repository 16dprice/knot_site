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


        $container = new HTML_Element("div"); // the 'form'


        $fileUploadContainer = new HTML_Element("div", ["class" => " form-group "]);

        $inputLabel = new HTML_Element("label");
        $inputLabel->text .= "Select File to Upload:";

        $fileInputElement = new HTML_Element("input");
        $fileInputElement->type = "file";
        $fileInputElement->id = "pd_code_file_upload_input";
        $fileInputElement->class = " form-control-file centered ";
        $fileInputElement->style = "width: 20%;";

        $fileUploadContainer->text .= $inputLabel . $fileInputElement;
        $container->text .= $fileUploadContainer;

        // --------------------------------------------------------------------------------

        $fileSubmitElement = new HTML_Element("button");
        $fileSubmitElement->text = "Upload File";
        $fileSubmitElement->onclick = "uploadPDcodeToSimplify();";

        $container->text .= $fileSubmitElement;

        return $container;

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