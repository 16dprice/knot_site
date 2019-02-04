<?php

abstract class Shell_V0 {

	abstract protected function getBody();
	
	public function __construct() {

	}

	// returns html for page
	public function getHtml($title) {
		return "<!DOCTYPE html> <html>" . $this->getHead($title) . $this->getBody() . "</html>";
	}
	
	// get the head for the page
	protected function getHead($title) {
	
		$head = new HTML_Element("head");
	
		// make and set the title
		$titleEl = new HTML_Element("title");
		$titleEl->text = $title;
		
		$head->text = $titleEl;
	
		// include all the css files
        $head->text .= $this->getAllCssFiles();

        // include all the js files
        $head->text .= $this->getAllJsFiles();

		// include jquery
		$head->text .= self::jsLink("http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.js");

        // Font Awesome
        $head->text .= self::externalCssLink(
            'https://use.fontawesome.com/releases/v5.0.8/css/all.css',
            [
                'integrity' => 'sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S',
                'crossorigin' => 'anonymous'
            ]
        );

        return $head;
	
	}

    //<editor-fold desc="Functions To Include CSS Files">

    protected function getAllCssFiles() {

	    $cssFiles = "";

	    // scan the css directory and get a link for the css files there
        foreach(scandir(getcwd()."/css") as $cssFile) {
            if(strcmp($cssFile, ".") != 0 && strcmp($cssFile, "..") != 0) {
                $cssFiles .= self::cssLink(substr(getcwd()."/css/$cssFile", 13));
            }
        }

        return $cssFiles;

    }
	
	// easy way to add css link
	protected static function cssLink($href) {
	
		$link = new HTML_Element("link");
	
		$link->rel = "stylesheet";
		$link->type = "text/css";
		$link->href = $href;
	
		return $link;
	
	}

    protected static function externalCssLink( $href, $additionalProperties = [], $media = NULL ) {
        // Init link
        $link = new HTML_Element('link');

        // Set as stylesheet
        $link->rel = 'stylesheet';

        // Href
        $link->href = $href;

        // Iterate through additional properties
        foreach ($additionalProperties as $key => $value) {
            // Set additional property
            $link->$key = $value;
        }

        // Media
        if ( $media != NULL ) {
            $link->media = $media;
        }

        return $link;
    }

    //</editor-fold>

    //<editor-fold desc="Functions To Include JS Files">

    protected function getAllJsFiles() {

	    $jsFiles = "";

        // scan the js directory and get a link for the js files there
        foreach(scandir(getcwd()."/js") as $jsFile) {
            if(strcmp($jsFile, ".") != 0 && strcmp($jsFile, "..") != 0) {
                $jsFiles .= self::jsLink(substr(getcwd()."/js/$jsFile", 13));
            }
        }

        return $jsFiles;

    }
	
	// easy way to add js link
    protected static function jsLink($src) {

		$script = new HTML_Element("script");
	
		$script->src = $src;
	
		return $script;
	
	}

    //</editor-fold>


}
