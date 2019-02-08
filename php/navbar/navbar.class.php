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

	    // init ul for nav
        $nav = new HTML_Element("nav");

        $nav->class = " navbar navbar-expand-lg navbar-light bg-light ";

        $links = new HTML_Element("ul");
        $links->class = " navbar-nav mr-auto ";

        $this->getNavLinks($links);

        $nav->text .= $links;

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

	    $navItem = new HTML_Element("li");
	    $navItem->class = " nav-item ";

	    $navLink = new HTML_Element("a");
	    $navLink->class = " nav-link ";
        $navLink->id = "home";
        $navLink->onclick = "openTab(".HOME_TAB.")";
        $navLink->text .= "Home";

        $navItem->text .= $navLink;
        return $navItem;

	}

	protected function getSimplifyPDpageLink() {

        $navItem = new HTML_Element("li");
        $navItem->class = " nav-item ";

        $navLink = new HTML_Element("a");
        $navLink->class = " nav-link ";
        $navLink->id = "simplify_pd_page";
        $navLink->onclick = "openTab(".SIMPLIFY_PD.")";
        $navLink->text .= "Simplify PD Codes";

        $navItem->text .= $navLink;
        return $navItem;

    }
	
}