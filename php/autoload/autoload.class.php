<?php
/**
 * Created by PhpStorm.
 * User: dj
 * Date: 7/14/18
 * Time: 4:49 PM
 */

class Autoload {

    // This will hold all files that are able to be include by the autoloader.
    // The files in this are based on the directories passed in during construct.
    protected static $filesToInclude = [];

    // List of directories to be combed through for possible files to be included
    // on page. Set in construct.
    protected $directores = [];

    /**
     * Construct. This sets given variables and pulls all files from directories passed in.
     * @param array $directories: Array of directories where files will be pulled from
     */
    public function __construct($directories) {

        // set class directories variable
        $this->directories = $directories;

        // pull all file names based on given directories
        foreach($this->directories as $dir) {
            $this->pullFiles($dir);
        }

        // register this class and the autoLoad function to PHP Autoloader
        spl_autoload_register(["Autoload", "autoLoad"], true, false);

    }

    /**
     * This is the function that is registered by the PHP Autoloader it checks to make sure that
     * the given class or trait has not already been loaded. If it hasn't been, it will call the findFile function.
     * @param string $fileName: file name given by Autoloader that needs to be loaded
     */
    public static function autoLoad($fileName) {
        if(!Autoload::alreadyRequired($fileName)) {
            Autoload::findFile($fileName);
        }
    }

    /**
     * This function checks to see if the given class has already been required. Uses class_exists function
     * for this.
     * @param string $className: this is the class name that is checked against existing classes
     */
    protected static function alreadyRequired($fileName) {
        // false in second part of function is to prevent method from attempting autoload
        return class_exists($fileName, false) || trait_exists($fileName, false);
    }

    /**
     * This function will find the given class or trait in the filesToInclude array. If it exists, it will
     * make another function call to require it.
     * @param string $fileName: the file name that is checked for existence in filesToInclude array
     */
    protected static function findFile($fileName) {
        // lower case class name
        $fileNameLower = strtolower($fileName);
        // check if key exists
        if(array_key_exists($fileNameLower . ".class.php", Autoload::$filesToInclude)) {
            Autoload::requireClass($fileName);
        } else if(array_key_exists($fileNameLower . ".trait.php", Autoload::$filesToInclude)) {
            Autoload::requireTrait($fileName);
        }
    }

    /**
     * This function will require a file given it's class name
     * @param string $className: class to be required
     */
    protected static function requireClass($className) {
        // lower case class name
        $classNameLower = strtolower($className);
        // file path
        $path = Autoload::$filesToInclude[$classNameLower . ".class.php"];
        // check if file path is valid in class array
        if(is_file($path)) {
            require_once($path);
        }
    }

    /**
     * This function will require a file given it's trait name
     * @param string $traitName: trait to be required
     */
    protected static function requireTrait($traitName) {
        // lower case class name
        $traitNameLower = strtolower($traitName);
        // file path
        $path = Autoload::$filesToInclude[$traitNameLower . ".trait.php"];
        // check if file path is valid in class array
        if(is_file($path)) {
            require_once($path);
        }
    }

    /**
     * This function will pull all files ending in .class.php in a given directory. It is also recursive, so it
     * will pull all files from all child directories as well.
     * @param string $dir: The directory to be scanned
     */
    protected function pullFiles($dir) {
        // Check if the Dir Exists
        if ( file_exists($dir) ) {
            // get file names from directory
            $resourceFiles = scandir($dir);

            foreach($resourceFiles as $file) {
                // make sure that the file is not a duplicate
                // if it is, die
                if(array_key_exists($file, Autoload::$filesToInclude)) {
                    // string to print to screen
                    $errorString = "$dir/$file is a duplicate.";
                    // loop through and find the duplicate file
                    foreach(Autoload::$filesToInclude as $foundFile => $foundFilePath) {
                        if($foundFile == $file) {
                            $errorString .= "<br>Duplicate located in $foundFilePath.";
                        }
                    }
                    die("$errorString Please delete unnecessary copies.");
                    // Would Like to Use Debug, but the Class isn't Found
                    // debug::die_die_die("$dir/$file is a duplicate. Please delete other copies.", "Duplicate Class File");
                }
                // variable that holds the full filepath of the file
                // NOTE: this still may be a directory, there is no gaurantee that this is actually a file
                $filePath = $dir . "/" . $file;
                // php scandir returns two vals of '.' and '..' that can be ignored
                if(strcmp($file, ".") != 0 && strcmp($file, "..") != 0) {
                    // check if file given is directory
                    if(!is_dir($filePath)) {
                        // if it is, make sure it ends in .class.php
                        if($this->endsWith($file, [".class.php", ".trait.php"])) {
                            // if it does, append to filesToInclude array
                            Autoload::$filesToInclude[$file] = $filePath;
                        }
                    } else {
                        // if the file was actually a directory, recursively call function again
                        $this->pullFiles($filePath);
                    }
                }
            }
        } else {
//                DEBUG::error("Directoy Path Not Found[" . $dir . "]", "Autoload Error");
        }

    }


    /**
     * This function will determine if a given haystack ends in any one of the strings given in needles
     * @param string $haystack: The string whose ending characters will be checked
     * @param array $needles: Array of allowed strings to be at the end of $haystack
     * @return boolean: returns true if the haystack ends in one of the needles, false otherwise
     */
    protected function endsWith($haystack, $needles) {

        // boolean return value
        $endsWithNeedle = false;

        // loop through needles and determine if haystack ends with one of the needles
        foreach($needles as $needle) {
            // get length of value to find
            $length = strlen($needle);

            // if the needle is at the end of the haystack, set return value to true
            if(substr($haystack, -$length) === $needle) $endsWithNeedle = true;
        }

        // returns true if the needle has 0 length OR if the haystack was determined to end with a given needle
        return $endsWithNeedle;

    }

}
