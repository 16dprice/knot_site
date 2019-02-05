<?php

class Shell extends Shell_V0 {

    // the callbacks for all of the tab constants
    protected $tabConfig = [
        HOME_TAB => "getHomeBody",
        SIMPLIFY_PD => "getSimplifyPDpage"
    ];

    public function getHtml($title) {

        // init html with head tag
        $html = "<!DOCTYPE html> <html>" . $this->getHead($title);

        // init body
        $body = new HTML_Element("body", ["style" => "background-color: EFECE9 ;"]);

        // standard container for the page
        // this should go under the nav bar
        $page = new HTML_Element("div");
        $page->class .= " page centered ";

        // if the tab is set, get it
        // else, set the tab to the home tab and get it
        if (isset($_SESSION["tab"])) {

            $tab = $_SESSION["tab"];

        } else {

            $_SESSION["tab"] = HOME_TAB;
            $tab = $_SESSION["tab"];

        }

        // get the content for the selected tab and append it to the page
        $content = $this->{$this->tabConfig[$tab]}();
        $page->text .= $content;

        // get the navbar
        $nav = new Navbar();

        // append the nav and the page to the body
        $body->text .= $nav;
        $body->text .= $page;


        // append the body to the html and close it
        $html .= $body . "</html>";

        // return
        return $html;

    }

    protected function getHead($title) {

        $head = parent::getHead($title);

        // compiled and minified bootstrap CSS
        $bootCSS = new HTML_Element("link");

        $bootCSS->rel = "stylesheet";
        $bootCSS->href = "https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css";
        $bootCSS->integrity = "sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS";
        $bootCSS->crossorigin = "anonymous";

        $head->text .= $bootCSS;


        // optional bootstrap theme
        $bootOpt = new HTML_Element("link");

        $bootOpt->rel = "stylesheet";
        $bootOpt->href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css";
        $bootOpt->integrity = "sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp";
        $bootOpt->crossorigin = "anonymous";

        $head->text .= $bootOpt;


        // compiled and minified bootstrap JS
        $bootJS = new HTML_Element("script");

        $bootJS->src = "https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js";
        $bootJS->integrity = "sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k";
        $bootJS->crossorigin = "anonymous";

        $head->text .= $bootJS;


        // https://stackoverflow.com/questions/35233768/bootstrap-inverse-table-and-thead-not-styling-correctly
        // more bootstrap CSS
        $bootCSSmore = self::cssLink("https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css");

        $head->text .= $bootCSSmore;


        // more bootstrap js (reference link above for context)
        $bootJSmore = self::jsLink("https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/js/bootstrap.min.js");

        $head->text .= $bootJSmore;


        return $head;

    }

    protected function getBody() {

        $body = new HTML_Element("body");

        $nav = new Navbar();
        $info = new Home_Content();

        $body->text .= $nav->getNav();
        $body->text .= $info->getContainer();

        return $body;

    }

    protected function getHomeBody() {

        // get the content for the home page
        $homeContent = new Home_Content();

        // return
        return $homeContent;

    }

    protected function getSimplifyPDpage() {

        $simplifyPDpage = new Simplify_PD_Content();

        return $simplifyPDpage;

    }


}