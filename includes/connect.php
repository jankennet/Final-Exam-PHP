<?php

const HOST = 'localhost'; //DB Location
const USER = 'root'; //Identity for authorization to access database
const PWD = '';
const DBNAME = 'belano_visitor_system';

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