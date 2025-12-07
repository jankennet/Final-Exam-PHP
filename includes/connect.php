<?php

if (!defined('HOST')) {
    define('HOST', 'localhost'); //DB Location
}
if (!defined('USER')) {
    define('USER', 'root'); //Identity for authorization to access database
}
if (!defined('PWD')) {
    define('PWD', '');
}
if (!defined('DBNAME')) {
    define('DBNAME', 'belano_visitor_system');
}

if (!function_exists('ConnectDB')) {
    function ConnectDB() {
        
        $conn = new mysqli(HOST, USER, PWD, DBNAME);
        if($conn -> connect_error) {
            die('Error Connection');
            exit;
        }

        return $conn;
    }
}

?>