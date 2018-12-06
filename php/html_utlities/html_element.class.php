<?php

class HTML_Element {

	protected $tag = "";
	protected $attributes = [];
	protected $propertiesNoEndTag = ["link"];

	public function __construct($tag = "p", $attributes = []) {
		$this->tag = $tag;
		
		foreach($attributes as $key => $value) {
			$this->$key = $value;
		}
	}

	// send it to a string
	public function __toString() {

		$retStr = "<$this->tag";

		$text = "";

		// assumed key for the text in an element is text
		foreach($this->attributes as $key => $value) {
			if(strcmp($key, "text") == 0 && $this->isPropSet("text")) {
				$text = $value;
			} else if(strcmp(substr($key, 0, 5), "data_") == 0) {
			    $retStr .= " data-" . substr($key, 5) . " = \"$value\" ";
            } else if(strcmp($key, "tag") != 0) {
				$retStr .= " $key = \"$value\" ";
			}
		}
		
		// check to see if element needs ending tag
		if(in_array($this->tag, $this->propertiesNoEndTag)) {
			$retStr .= ">";
		} else {
			 $retStr .= ">" . $text . "</$this->tag>";
		}

		return $retStr;

	}
	
	// magic methods
	public function __get($attribute) {
		if(isset($this->attributes[$attribute])) {
			return $this->attributes[$attribute];
		}
		return "";
	}

	public function __set($attribute, $value) {
		$this->attributes[$attribute] = $value;
	}
	
	// true if property has already been set
	// will still return true if property has been set to null
	// this only checks for existence of the key matching property
	public function isPropSet($attribute) {
		$keys = array_keys($this->attributes);
		return in_array($attribute, $keys);
	}

}