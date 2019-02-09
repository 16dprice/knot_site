<?php

class Upload_PD_Codes_Content {

    public function __toString() {

        $container = new HTML_Element("div");

        $displayTableContainer = $this->getMinimalDiagramsTableDisplay();
        $uploadContainer = $this->getUploadMinimalDiagramsForm();

        $container->text .= $displayTableContainer . $uploadContainer;

        return $container->__toString();
    }

    private function getMinimalDiagramsTableDisplay() {

        // TODO look into datatables to display knots that are already in the database
        $displayTableContainer = new HTML_Element("div");

        $db = Database::getInstance();

        $query = "SELECT * FROM minimal_diagrams;";
        $results = $db->runSelectQuery($query);

        $table = $db->viewResultsAsTable($results);

        $displayTableContainer->text .= $table;

        return $displayTableContainer;

    }

    private function getUploadMinimalDiagramsForm() {

        $uploadContainer = new HTML_Element("div", ["class" => " form-group "]);

        // --------------------------------------------------------------------------------

        $knotTypeInputLabel = new HTML_Element("label");
        $knotTypeInputLabel->text = "Knot Type: ";

        $knotTypeInput = new HTML_Element("input");
        $knotTypeInput->type = "text";
        $knotTypeInput->id = "minimal_diagrams_knot_type_input";
        $knotTypeInput->class = " centered ";

        $uploadContainer->text .= $knotTypeInputLabel . $knotTypeInput . "<br>";

        // --------------------------------------------------------------------------------

        $inputLabel = new HTML_Element("label");
        $inputLabel->text .= "Select File to Upload:";

        $fileInputElement = new HTML_Element("input");
        $fileInputElement->type = "file";
        $fileInputElement->id = "minimal_diagrams_file_upload_input";
        $fileInputElement->class = " form-control-file centered ";
        $fileInputElement->style = "width: 20%;";

        $uploadContainer->text .= $inputLabel . $fileInputElement;

        // --------------------------------------------------------------------------------

        $submitElement = new HTML_Element("button");
        $submitElement->text = "Upload Record";
        $submitElement->onclick = "uploadMinimalDiagramsRecord();";

        $uploadContainer->text .= $submitElement;


        return $uploadContainer;


    }

}