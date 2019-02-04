<?php

class Navbar {
	
	protected $navLinkCallbacks = [
	    "getHomeLink",
        "getSimplifyPDpageLink"
    ];
	
	public function __construct() {
		
	}

	public function __toString() {
        return $this->getNav()->__toString();
    }

    public function getNav() {

		// init nav
		$nav = new HTML_Element("nav");

        $nav->class .= " custom-nav "; // my custom nav class

		// give nav all bootstrap classes
		$nav->class .= " navbar "; // gives it a basic navbar look
		$nav->class .= " navbar-inverse "; // makes it black instead of white

		// get the nav links
		$this->getNavLinks($nav);

		// return container with nav in it
		return $nav;
		
	}
	
	protected function getNavLinks($nav) {

	    // this loop appends all the links to $nav
        // it doesn't return anything because the $nav is an object so we just append to the object
		foreach($this->navLinkCallbacks as $callback) {

		    $navLink = $this->$callback();

		    // a callback will return null if the user is not authenticated to use the link (previous functionality, but we may end up having users)
		    if($navLink != null) {
                $nav->text .= $this->$callback();
            }

        }
		
	}
	
	protected function getHomeLink() {
		$navHome = new HTML_Element("a");
		
		$navHome->id = "home";
		$navHome->class = "navbar-brand clickable";
		$navHome->onclick = "openTab(".HOME_TAB.")";
		$navHome->text .= "Home";
		
		return $navHome;
	}

	protected function getSimplifyPDpageLink() {
	    $navPDpage = new HTML_Element("a");

        $navPDpage->id = "simplify_pd_page";
        $navPDpage->class = "navbar-brand clickable";
        $navPDpage->onclick = "openTab(".SIMPLIFY_PD.")";
        $navPDpage->text .= "Simplify PD Codes";

        return $navPDpage;
    }
	
}