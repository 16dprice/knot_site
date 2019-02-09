<?php

class Database {

    protected $servername;
    protected $user;
    protected $pass;
    protected $dbname;

    protected static $instances = [];

    protected $conn = null;

    private function __construct($servername = "db", $user = "root", $pass = "research-pass124", $dbname = "test") {

        $this->servername = $servername;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;

        $this->conn = new mysqli($this->servername, $this->user, $this->pass, $this->dbname);

    }

    // returns an instance of this class, that's why the constructor is private
    // singleton OOP design pattern
    public static function getInstance() {

        $dbname = "flype_db";

        $cwd = getcwd();

        if(strpos($cwd, 'sandboxes') !== false) {
            // this means we are in a sandbox environment
            // so get the developer

            $explodedString = explode("/", $cwd);
            $developer = "dj"; // default

            for($i = 0; $i < count($explodedString); $i++) {
                if($explodedString[$i] === "sandboxes") {
                    $developer = $explodedString[$i + 1];
                }
            }

            $dbname = $developer . "_sandbox_db";

        }

        if(!isset(self::$instances[$dbname])) {
            self::$instances[$dbname] = new Database("db", "root", "research-pass124", $dbname);
        }

        return self::$instances[$dbname];

    }

    //<editor-fold desc="Specialized Query Methods">

    public function runInsertQuery($mysql) {

        $isValid = $this->conn->query($mysql);

        return $isValid;

    }

    public function runSelectQuery($mysql) {

        $results = $this->conn->query($mysql);
        $results = $results->fetch_all(MYSQLI_ASSOC);

        return $results;

    }

    public function runDeleteQuery($mysql) {

        $isValid = $this->conn->query($mysql);

        return $isValid;

    }

    //</editor-fold>

    // expects array(0 => array('field' => 'val', ... ), 1 => ... )
    public static function viewResultsAsTable($results) {

        if(count($results) > 0) {
            $table = new HTML_Element("table");
//            $table->style .= " left: 0; right: 0; width: 80%; margin: 0 auto; ";
            $table->class .= " centered ";

            $firstRes = $results[0];

            $tablesHeaders = array_keys($firstRes);

            $headerTR = new HTML_Element("tr");
            foreach ($tablesHeaders as $header) {
                $headerTR->text .= "<th style='text-align: center;'>$header</th>";
            }
            $table->text .= $headerTR;

            foreach ($results as $res) {
                $rowTR = new HTML_Element("tr");

                foreach ($res as $field => $val) {
                    $rowTR->text .= "<td>$val</td>";
                }

                $table->text .= $rowTR;

            }

            return $table;
        } else {
            return "Nothing in results given to viewResultsAsTable.";
        }

    }

}